<?php

namespace Tests\Lib\Middleware;

use Anthropic\Client;
use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Lib\Middleware\BetaFallbackState;
use Anthropic\Lib\Middleware\RefusalFallbackMiddleware;
use Http\Client\Exception\NetworkException;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * The streaming path of RefusalFallbackMiddleware: refused SSE streams are
 * retried down the chain and the continuation is spliced onto the open
 * stream.
 *
 * The sibling SDKs report surfaced refusals and failed hops through a
 * logger; this middleware has no reporting hook, so those tests pin only
 * the wire-visible behavior. There is likewise no strict/lenient response
 * validation switch, so one client serves every test.
 *
 * @internal
 *
 * @phpstan-type EventStream BaseStream<\Anthropic\Beta\Messages\BetaRawMessageStartEvent|\Anthropic\Beta\Messages\BetaRawMessageDeltaEvent|\Anthropic\Beta\Messages\BetaRawMessageStopEvent|\Anthropic\Beta\Messages\BetaRawContentBlockStartEvent|\Anthropic\Beta\Messages\BetaRawContentBlockDeltaEvent|\Anthropic\Beta\Messages\BetaRawContentBlockStopEvent>
 */
#[CoversNothing]
class RefusalFallbackStreamingTest extends TestCase
{
    private const API_KEY = 'my-anthropic-api-key';
    private const FALLBACK_MODEL = 'claude-opus-4-8';
    private const SECOND_MODEL = 'claude-sonnet-4-6';
    private const FALLBACKS = [['model' => self::FALLBACK_MODEL]];
    private const TWO_FALLBACKS = [['model' => self::FALLBACK_MODEL], ['model' => self::SECOND_MODEL]];

    private const PARAMS = [
        'model' => 'claude-fable-5',
        'max_tokens' => 1024,
        'messages' => [['role' => 'user', 'content' => 'Hey claudius! Can you tell me what a solar eclipse is?']],
    ];

    private const TOOL_USE_ID = 'srvtoolu_01';

    private ScriptedTransport $transporter;

    private string|false $errorLog = false;

    protected function setUp(): void
    {
        $this->transporter = new ScriptedTransport;
        // silence the missing-BetaFallbackState warning in tests that fall back without one
        $this->errorLog = ini_set('error_log', '/dev/null');
    }

    protected function tearDown(): void
    {
        ini_set('error_log', false === $this->errorLog ? '' : $this->errorLog);
    }

    // --- happy path -----------------------------------------------------------

    public function testSplicesTheFallbackOntoTheRefusedStream(): void
    {
        $this->serve(self::sseResponse(self::streamA()), self::sseResponse(self::streamB()));
        $client = $this->makeClient(new RefusalFallbackMiddleware(self::FALLBACKS));

        $events = self::collect($this->createStream($client));

        // A's thinking + text are forwarded, a fallback boundary block is emitted
        // at the next monotonic index, then B's blocks continue after it.
        $this->assertSame([
            [0, 'thinking'],
            [1, 'text'],
            [2, 'fallback'],
            [3, 'text'],
        ], self::blockStarts($events));

        // The fallback block carries the from/to model transition.
        $fallback = self::boundaries($events)[0] ?? null;
        $this->assertSame('claude-fable-5', self::at($fallback, 'from', 'model'));
        $this->assertSame(self::FALLBACK_MODEL, self::at($fallback, 'to', 'model'));

        // Exactly one message_start (A's) and one message_stop reach the client —
        // B's message_start is suppressed.
        $this->assertCount(1, self::ofType($events, 'message_start'));
        $this->assertCount(1, self::ofType($events, 'message_stop'));
        $this->assertCount(1, self::ofType($events, 'message_delta'));
    }

    public function testUsageIterationsIsTheTwoEntryServerShape(): void
    {
        $this->serve(self::sseResponse(self::streamA()), self::sseResponse(self::streamB()));
        $client = $this->makeClient(new RefusalFallbackMiddleware(self::FALLBACKS));

        $events = self::collect($this->createStream($client));

        $messageDelta = self::first($events, 'message_delta');
        $this->assertSame('end_turn', self::at($messageDelta, 'delta', 'stop_reason'));
        // the 2-entry server shape, with no spurious `message: null` entry
        $this->assertSame([
            ['message', 'claude-fable-5'],
            ['fallback_message', self::FALLBACK_MODEL],
        ], self::iterations($messageDelta));
    }

    public function testBuildsRequestBAsAShapeBContinuation(): void
    {
        $this->serve(self::sseResponse(self::streamA()), self::sseResponse(self::streamB()));
        $client = $this->makeClient(new RefusalFallbackMiddleware(self::FALLBACKS));

        self::collect($this->createStream($client));

        $bodies = $this->requestBodies();
        $this->assertCount(2, $bodies);
        $bodyB = $bodies[1];

        // Model swapped to the fallback, credit token from A's stop_details set.
        $this->assertSame(self::FALLBACK_MODEL, $bodyB['model']);
        $credit = self::arr($bodyB['fallback_credit_token']);
        $this->assertSame('best_effort', $credit['mode']);
        $this->assertIsString($credit['token']);
        $this->assertGreaterThan(0, strlen($credit['token']));

        // Mutually exclusive with server-side fallback — both spellings absent.
        $this->assertArrayNotHasKey('fallback', $bodyB);
        $this->assertArrayNotHasKey('fallbacks', $bodyB);

        // max_tokens untouched (any render-shaping change would 400).
        $this->assertSame(1024, $bodyB['max_tokens']);

        // Original turn preserved; one assistant turn appended carrying the
        // [thinking, text] partial output as-is — the prefill claim authorizes
        // it verbatim, so no client-side filtering or trimming.
        $messages = self::items($bodyB['messages']);
        $this->assertCount(2, $messages);
        $this->assertEquals(self::PARAMS['messages'][0], $messages[0]);
        $appended = self::arr($messages[1]);
        $this->assertSame('assistant', $appended['role']);
        $this->assertSame(['thinking', 'text'], self::types($appended['content']));
        $this->assertArrayHasKey('signature', self::arr(self::items($appended['content'])[0]));
    }

    public function testAppendsTheFallbackCreditBetaToBothTheOriginalAndHopRequests(): void
    {
        $this->serve(self::sseResponse(self::streamA()), self::sseResponse(self::streamB()));
        $client = $this->makeClient(new RefusalFallbackMiddleware(self::FALLBACKS));

        // the request already carries a beta header; the default is appended to it.
        self::collect($this->createStream($client, betas: ['interleaved-thinking-2025-05-14']));

        // compared as member lists: PHP joins header values without the space
        $this->assertSame([
            ['interleaved-thinking-2025-05-14', 'fallback-credit-2026-07-01'],
            ['interleaved-thinking-2025-05-14', 'fallback-credit-2026-07-01'],
        ], $this->betaHeaders());
    }

    // --- edge cases -----------------------------------------------------------

    public function testARefusalWithoutAPrefillClaimFallsBackToShapeA(): void
    {
        // fallback_has_prefill_claim: false — the partial output may not be
        // resent, so the middleware omits the prefill and resends the original
        // body with just the token attached.
        $noClaim = implode('', [
            self::messageStart(),
            self::ev([
                'type' => 'content_block_start',
                'index' => 0,
                'content_block' => ['type' => 'thinking', 'thinking' => '', 'signature' => ''],
            ]),
            self::ev([
                'type' => 'content_block_delta',
                'index' => 0,
                'delta' => ['type' => 'thinking_delta', 'thinking' => 'considering the request'],
            ]),
            self::ev([
                'type' => 'content_block_delta',
                'index' => 0,
                'delta' => ['type' => 'signature_delta', 'signature' => 'sig=='],
            ]),
            self::ev(['type' => 'content_block_stop', 'index' => 0]),
            self::refusalDelta('tok_abc', false),
            self::ev(['type' => 'message_stop']),
        ]);
        $this->serve(self::sseResponse($noClaim), self::sseResponse(self::streamB()));
        $client = $this->makeClient(new RefusalFallbackMiddleware(self::FALLBACKS));

        self::collect($this->createStream($client));

        $bodies = $this->requestBodies();
        $this->assertSame(self::redeemedToken('tok_abc'), $bodies[1]['fallback_credit_token']);
        // No appended assistant turn — identical body (shape-A).
        $this->assertEquals(self::PARAMS['messages'], $bodies[1]['messages']);
    }

    public function testRefusalWithNoCreditTokenPassesAThroughAndLogsAnError(): void
    {
        $noToken = preg_replace('/"fallback_credit_token":"[^"]*"/', '"fallback_credit_token":null', self::streamA());
        $this->assertIsString($noToken);
        $this->serve(self::sseResponse($noToken));
        $client = $this->makeClient(new RefusalFallbackMiddleware(self::FALLBACKS));

        $events = self::collect($this->createStream($client));

        // Only the original request was made — no fallback.
        $this->assertCount(1, $this->transporter->requests);
        // no logger to assert the "no fallback_credit_token" error through

        // A passes through unchanged, ending in its own refusal (no fallback block).
        $this->assertSame([], self::boundaries($events));
        $this->assertSame('refusal', self::at(self::first($events, 'message_delta'), 'delta', 'stop_reason'));
    }

    public function testA400OnThePrefillFormRetriesTheSameHopWithoutThePartial(): void
    {
        $this->serve(
            self::sseResponse(self::streamA()),
            self::errorResponse('bad prefill', 400),
            self::sseResponse(self::streamB()),
        );
        $client = $this->makeClient(new RefusalFallbackMiddleware(self::FALLBACKS));

        $events = self::collect($this->createStream($client));

        // Attempt 1 appends A's partial; the 400 drops it and attempt 2 redeems
        // the same token against the unchanged body.
        $bodies = $this->requestBodies();
        $this->assertCount(3, $bodies);
        $this->assertCount(2, self::items($bodies[1]['messages']));
        $this->assertSame(self::FALLBACK_MODEL, $bodies[2]['model']);
        $this->assertSame($bodies[1]['fallback_credit_token'], $bodies[2]['fallback_credit_token']);
        $this->assertEquals(self::PARAMS['messages'], $bodies[2]['messages']);

        // The recovered hop is not a failure: one boundary, a normal completion.
        $this->assertCount(1, self::boundaries($events));
        $this->assertSame('end_turn', self::at(self::first($events, 'message_delta'), 'delta', 'stop_reason'));
    }

    public function testAFallbackRequestThatRaisesReplaysTheRefusal(): void
    {
        $this->serve(self::sseResponse(self::streamA()), self::connectionError('connection reset'));
        $client = $this->makeClient(new RefusalFallbackMiddleware(self::FALLBACKS));

        $events = self::collect($this->createStream($client));

        // no logger to assert the connection error is reported against the fallback model

        // The stream still closes cleanly: A's refusal is replayed and
        // message_stop follows — not a hard stream error.
        $this->assertSame('refusal', self::at(self::first($events, 'message_delta'), 'delta', 'stop_reason'));
        $this->assertSame('message_stop', $events[count($events) - 1]['type'] ?? null);
    }

    public function testANonRefusalStreamIsPassedThroughUntouched(): void
    {
        $normal = implode('', [
            self::messageStart(),
            self::ev(['type' => 'content_block_start', 'index' => 0, 'content_block' => ['type' => 'text', 'text' => '']]),
            self::ev([
                'type' => 'content_block_delta',
                'index' => 0,
                'delta' => ['type' => 'text_delta', 'text' => 'Sure!'],
            ]),
            self::ev(['type' => 'content_block_stop', 'index' => 0]),
            self::ev([
                'type' => 'message_delta',
                'delta' => ['stop_reason' => 'end_turn', 'stop_sequence' => null],
                'usage' => ['output_tokens' => 3],
            ]),
            self::ev(['type' => 'message_stop']),
        ]);
        $this->serve(self::sseResponse($normal));
        $client = $this->makeClient(new RefusalFallbackMiddleware(self::FALLBACKS));

        $events = self::collect($this->createStream($client));

        $this->assertCount(1, $this->transporter->requests);
        $this->assertSame([
            'message_start',
            'start[0] text',
            'delta[0] text_delta',
            'stop[0]',
            'message_delta end_turn iter=[]',
            'message_stop',
        ], self::skeleton($events));
    }

    public function testServerSideFallbacksRaiseAnError(): void
    {
        $this->serve(self::sseResponse(self::streamA()));
        $client = $this->makeClient(new RefusalFallbackMiddleware(self::FALLBACKS));

        try {
            $client->beta->messages->createStream(
                maxTokens: 1024,
                messages: [['role' => 'user', 'content' => 'Hey claudius! Can you tell me what a solar eclipse is?']],
                model: 'claude-fable-5',
                fallbacks: [['model' => 'server-fallback']],
            );
            $this->fail('Expected AnthropicException to be thrown');
        } catch (AnthropicException $e) {
            // the PHP wording of the same error
            $this->assertStringContainsString(
                'Sending the `fallbacks` request param is not supported when using the '
                .'RefusalFallbackMiddleware. Either remove the middleware and send `fallbacks` with the '
                .'`server-side-fallback-2026-07-01` beta header to let the API handle refusal fallbacks, '
                .'or omit the `fallbacks` param to let the middleware handle them client-side.',
                $e->getMessage(),
            );
        }
        // the error is raised before any request is sent
        $this->assertCount(0, $this->transporter->requests);
    }

    // --- fallback state pinning -------------------------------------------------
    //
    // The state is handed to the middleware constructor rather than entered
    // as a context.

    public function testPinsTheStateToTheHopThatServed(): void
    {
        $this->serve(self::sseResponse(self::streamA()), self::sseResponse(self::streamB()));
        $state = new BetaFallbackState;
        $client = $this->makeClient(new RefusalFallbackMiddleware(self::FALLBACKS, state: $state));

        self::collect($this->createStream($client));

        $this->assertSame(0, $state->index);
    }

    public function testAPinnedStateStartsOnThePinnedEntryAndChainsPastIt(): void
    {
        $this->serve(self::sseResponse(self::streamA()), self::sseResponse(self::streamB()));
        $state = new BetaFallbackState;
        $state->index = 0;
        $client = $this->makeClient(new RefusalFallbackMiddleware(self::TWO_FALLBACKS, state: $state));

        self::collect($this->createStream($client));

        $bodies = $this->requestBodies();
        $this->assertCount(2, $bodies);
        // The initial request already carries the pinned entry's params; the
        // mid-stream refusal then chains to the entry after the pin.
        $this->assertSame(self::FALLBACK_MODEL, $bodies[0]['model']);
        $this->assertSame(self::SECOND_MODEL, $bodies[1]['model']);
        $this->assertSame(1, $state->index);
    }

    public function testWarnsOnceWhenFallingBackWithoutAState(): void
    {
        $this->serve(
            self::sseResponse(self::streamA()),
            self::sseResponse(self::streamB()),
            self::sseResponse(self::streamA()),
            self::sseResponse(self::streamB()),
        );
        $client = $this->makeClient(new RefusalFallbackMiddleware(self::FALLBACKS));

        // the warning goes through error_log(); route it to a file to read it back
        $log = tempnam(sys_get_temp_dir(), 'fallback-warn');
        $this->assertIsString($log);
        ini_set('error_log', $log);

        // drain the spliced stream so the fallback actually fires
        self::collect($this->createStream($client));
        self::collect($this->createStream($client));

        $warnings = array_values(array_filter(explode("\n", file_get_contents($log) ?: '')));
        @unlink($log);
        $this->assertCount(1, $warnings);
        $this->assertStringContainsString('BetaFallbackState', $warnings[0]);
    }

    // --- fallback chain ---------------------------------------------------------

    public function testARefusedHopWithoutAPrefillClaimDropsItsPartialFromTheNextRequest(): void
    {
        $this->serve(
            self::sseResponse(self::streamA()),
            self::sseResponse(self::hopRefusal('tok_b', false)),
            self::sseResponse(self::streamB()),
        );
        $client = $this->makeClient(new RefusalFallbackMiddleware(self::TWO_FALLBACKS));

        self::collect($this->createStream($client));

        $bodies = $this->requestBodies();
        $this->assertCount(3, $bodies);
        $this->assertSame(self::redeemedToken('tok_b'), $bodies[2]['fallback_credit_token']);
        // Hop 2 redeems the fresh token against the body it was minted for —
        // hop 1's request, including its appended turn — without hop 1's own
        // (unclaimed) partial output.
        $this->assertEquals($bodies[1]['messages'], $bodies[2]['messages']);
    }

    public function testAnHttpFailedHopIsSkippedAndTheUnredeemedTokenCarriesToTheNextEntry(): void
    {
        $this->serve(
            self::sseResponse(self::streamA()),
            self::jsonResponse(['type' => 'error', 'error' => ['type' => 'overloaded_error', 'message' => 'later']], 529),
            self::sseResponse(self::streamB()),
        );
        $client = $this->makeClient(
            new RefusalFallbackMiddleware([['model' => self::FALLBACK_MODEL], ['model' => self::SECOND_MODEL]])
        );

        $events = self::collect($this->createStream($client));

        // no logger to assert the "HTTP 529" hop-failure error through
        $this->assertCount(3, $this->transporter->requests);

        // Same token and continuation — the failed hop never redeemed them.
        $bodies = $this->requestBodies();
        $this->assertSame(self::SECOND_MODEL, $bodies[2]['model']);
        $this->assertSame($bodies[1]['fallback_credit_token'], $bodies[2]['fallback_credit_token']);
        $this->assertEquals($bodies[1]['messages'], $bodies[2]['messages']);

        // The failed hop was never reached: no seam for it — one boundary, from
        // A straight to the entry that served.
        $this->assertSame([
            ['claude-fable-5', self::SECOND_MODEL],
        ], array_map(self::fromTo(...), self::boundaries($events)));

        // The failed hop is absent from iterations (no usage came back).
        $delta = self::first($events, 'message_delta');
        $this->assertSame('end_turn', self::at($delta, 'delta', 'stop_reason'));
        $this->assertSame([
            ['message', 'claude-fable-5'],
            ['fallback_message', self::SECOND_MODEL],
        ], self::iterations($delta));
    }

    public function testATerminalRefusalWithNoEntriesLeftIsEmittedWithTheFullIterationChain(): void
    {
        $this->serve(self::sseResponse(self::streamA()), self::sseResponse(self::hopRefusal()));
        $client = $this->makeClient(new RefusalFallbackMiddleware(self::FALLBACKS));

        $events = self::collect($this->createStream($client));

        $this->assertCount(2, $this->transporter->requests);
        // no logger to assert the "no fallback entries remain" error through
        $delta = self::first($events, 'message_delta');
        $this->assertSame('refusal', self::at($delta, 'delta', 'stop_reason'));
        // The fresh token reaches the client for a manual retry.
        $this->assertNotNull(self::at($delta, 'delta', 'stop_details'));
        $this->assertSame('tok_b', self::at($delta, 'delta', 'stop_details', 'fallback_credit_token'));
        $this->assertSame([
            ['message', 'claude-fable-5'],
            ['fallback_message', self::FALLBACK_MODEL],
        ], self::iterations($delta));
    }

    public function testATokenLessRefusalOnTheFinalHopIsStillLogged(): void
    {
        $this->serve(self::sseResponse(self::streamA()), self::sseResponse(self::hopRefusal(null)));
        $client = $this->makeClient(new RefusalFallbackMiddleware(self::FALLBACKS));

        $events = self::collect($this->createStream($client));

        // no logger to assert the "no fallback_credit_token" error through
        $this->assertSame('refusal', self::at(self::first($events, 'message_delta'), 'delta', 'stop_reason'));
    }

    public function testAnEmptyChainPassesTheStreamThroughUntouched(): void
    {
        $middleware = new RefusalFallbackMiddleware([]);

        $request = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('POST', 'http://127.0.0.1:4010/v1/messages?beta=true')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(self::json([...self::PARAMS, 'stream' => true])))
        ;
        $response = self::sseResponse(self::streamA());

        $calls = [];
        $callNext = static function (RequestInterface $req) use (&$calls, $response): ResponseInterface {
            $calls[] = $req;

            return $response;
        };

        $out = $middleware->handle($request, $callNext);

        // With nothing to hop to, the response isn't even wrapped — no per-event
        // decode/re-encode overhead, and no error: this is the steady state of an
        // exhausted or fully-pinned chain.
        $this->assertSame($response, $out);
        $this->assertCount(1, $calls);
    }

    public function testAHopWhoseRequestRaisesIsSkippedAndTheUnredeemedTokenCarries(): void
    {
        $this->serve(
            self::sseResponse(self::streamA()),
            self::connectionError('connection reset'),
            self::sseResponse(self::streamB()),
        );
        $client = $this->makeClient(
            new RefusalFallbackMiddleware([['model' => self::FALLBACK_MODEL], ['model' => self::SECOND_MODEL]])
        );

        $events = self::collect($this->createStream($client));

        // no logger to assert the connection error is reported against the fallback model
        $this->assertCount(3, $this->transporter->requests);

        // Same token — the raising hop never redeemed it.
        $bodies = $this->requestBodies();
        $this->assertSame(self::SECOND_MODEL, $bodies[2]['model']);
        $this->assertSame($bodies[1]['fallback_credit_token'], $bodies[2]['fallback_credit_token']);

        // The stream completes normally from the next entry.
        $delta = self::first($events, 'message_delta');
        $this->assertSame('end_turn', self::at($delta, 'delta', 'stop_reason'));
        $this->assertSame([
            ['message', 'claude-fable-5'],
            ['fallback_message', self::SECOND_MODEL],
        ], self::iterations($delta));
    }

    // --- pre-stream refusals ------------------------------------------------------
    //
    // A refusal that arrives before any output streamed: the retry is free and
    // invisible, so it fires even without a credit token, and the serving hop's
    // message_start opens the wire carrying the primary's message id.

    public function testTheServingStartOpensTheWireWithThePrimaryMessageId(): void
    {
        $this->serve(self::sseResponse(self::preStreamRefusal()), self::sseResponse(self::servingStream()));
        $client = $this->makeClient(new RefusalFallbackMiddleware(self::FALLBACKS));

        $events = self::collect($this->createStream($client));

        // The refused hop's message_start never reaches the client; the serving
        // hop's opens the wire, rewritten to the primary's message id.
        $starts = self::ofType($events, 'message_start');
        $this->assertCount(1, $starts);
        $this->assertSame(self::FALLBACK_MODEL, self::at($starts[0], 'message', 'model'));
        $this->assertSame('msg_a', self::at($starts[0], 'message', 'id'));

        // One seam at index 0, then the serving hop's content after it.
        $this->assertSame([[0, 'fallback'], [1, 'text']], self::blockStarts($events));
        $delta = self::first($events, 'message_delta');
        $this->assertSame('end_turn', self::at($delta, 'delta', 'stop_reason'));
        $this->assertSame([
            ['message', 'claude-fable-5'],
            ['fallback_message', self::FALLBACK_MODEL],
        ], self::iterations($delta));
    }

    public function testATokenLessPreStreamRefusalStillRetries(): void
    {
        $tokenLess = implode('', [self::messageStart(), self::refusalDelta(null), self::ev(['type' => 'message_stop'])]);
        $this->serve(self::sseResponse($tokenLess), self::sseResponse(self::servingStream()));
        $client = $this->makeClient(new RefusalFallbackMiddleware(self::FALLBACKS));

        $events = self::collect($this->createStream($client));

        // nothing had streamed, so the retry fired despite the missing token
        $bodies = $this->requestBodies();
        $this->assertCount(2, $bodies);
        $this->assertSame(self::FALLBACK_MODEL, $bodies[1]['model']);
        $this->assertArrayNotHasKey('fallback_credit_token', $bodies[1]);
        $this->assertSame('end_turn', self::at(self::first($events, 'message_delta'), 'delta', 'stop_reason'));
    }

    public function testAChainOfPreStreamDeclinesQueuesEverySeamInOrder(): void
    {
        $this->serve(
            self::sseResponse(self::preStreamRefusal()),
            self::sseResponse(implode('', [self::messageStart(), self::refusalDelta('tok_b'), self::ev(['type' => 'message_stop'])])),
            self::sseResponse(self::servingStream(self::SECOND_MODEL)),
        );
        $client = $this->makeClient(new RefusalFallbackMiddleware(self::TWO_FALLBACKS));

        $events = self::collect($this->createStream($client));

        // serving start first, then both seams, then the serving content
        $this->assertSame('message_start', $events[0]['type'] ?? null);
        $this->assertSame('msg_a', self::at($events[0], 'message', 'id'));
        $this->assertSame([[0, 'fallback'], [1, 'fallback'], [2, 'text']], self::blockStarts($events));
        [$seamOne, $seamTwo] = self::boundaries($events);
        $this->assertSame(['claude-fable-5', self::FALLBACK_MODEL], self::fromTo($seamOne));
        $this->assertSame([self::FALLBACK_MODEL, self::SECOND_MODEL], self::fromTo($seamTwo));
        $delta = self::first($events, 'message_delta');
        $this->assertSame([
            ['message', 'claude-fable-5'],
            ['message', self::FALLBACK_MODEL],
            ['fallback_message', self::SECOND_MODEL],
        ], self::iterations($delta));
    }

    // --- history seam replay ------------------------------------------------------
    //
    // Pinning is explicit-state-only: a `fallback` seam block replayed in the
    // request history never pins — without a `BetaFallbackState` the first request
    // goes to the original model. The seam blocks themselves are this middleware's
    // client-side markers, so they are filtered out of the wire request, and an
    // assistant turn that was only a seam is dropped whole — `content: []` is an
    // invalid body.

    public function testAHistorySeamWithoutAStateDoesNotPin(): void
    {
        $this->serve(self::sseResponse(self::servingStream('claude-fable-5')));
        $client = $this->makeClient(new RefusalFallbackMiddleware(self::TWO_FALLBACKS));

        $stream = $client->beta->messages->createStream(
            maxTokens: 1024,
            messages: [
                ['role' => 'user', 'content' => 'hello'],
                [
                    'role' => 'assistant',
                    'content' => [
                        [
                            'type' => 'fallback',
                            'from' => ['model' => 'claude-fable-5'],
                            'to' => ['model' => self::FALLBACK_MODEL],
                        ],
                        ['type' => 'text', 'text' => 'earlier turn'],
                    ],
                ],
                ['role' => 'user', 'content' => 'and again?'],
            ],
            model: 'claude-fable-5',
        );
        self::collect($stream);

        $bodies = $this->requestBodies();
        $this->assertCount(1, $bodies);
        // no state, no pin — the first request goes to the original model
        $this->assertSame('claude-fable-5', $bodies[0]['model']);
        // the seam block is the middleware's own marker — filtered off the wire
        $this->assertEquals([['type' => 'text', 'text' => 'earlier turn']], self::at($bodies[0], 'messages', 1, 'content'));
        $this->assertSame([['fallback-credit-2026-07-01']], $this->betaHeaders());
    }

    public function testASeamOnlyAssistantTurnIsDroppedWhole(): void
    {
        $this->serve(self::sseResponse(self::servingStream('claude-fable-5')));
        $client = $this->makeClient(new RefusalFallbackMiddleware(self::FALLBACKS));

        $stream = $client->beta->messages->createStream(
            maxTokens: 1024,
            messages: [
                ['role' => 'user', 'content' => 'hello'],
                [
                    'role' => 'assistant',
                    'content' => [
                        [
                            'type' => 'fallback',
                            'from' => ['model' => 'claude-fable-5'],
                            'to' => ['model' => self::FALLBACK_MODEL],
                        ],
                    ],
                ],
                ['role' => 'user', 'content' => 'and again?'],
            ],
            model: 'claude-fable-5',
        );
        self::collect($stream);

        $bodies = $this->requestBodies();
        $this->assertCount(1, $bodies);
        // stripping left the assistant turn empty, so the turn is omitted —
        // not sent as `content: []`, which the server rejects
        $this->assertEquals([
            ['role' => 'user', 'content' => 'hello'],
            ['role' => 'user', 'content' => 'and again?'],
        ], $bodies[0]['messages']);
        // the rest of the request is intact
        $this->assertSame('claude-fable-5', $bodies[0]['model']);
        $this->assertSame(1024, $bodies[0]['max_tokens']);
        $this->assertSame([['fallback-credit-2026-07-01']], $this->betaHeaders());
    }

    // --- per-hop overrides ----------------------------------------------------------

    public function testEntryOverridesApplyToTheHopRequest(): void
    {
        $this->serve(self::sseResponse(self::streamA()), self::sseResponse(self::streamB()));
        $client = $this->makeClient(new RefusalFallbackMiddleware([['model' => self::FALLBACK_MODEL, 'max_tokens' => 32]]));

        self::collect($this->createStream($client));

        $bodies = $this->requestBodies();
        $this->assertSame(1024, $bodies[0]['max_tokens']);
        // the entry's overrides are merged over the hop's body, applied to the
        // serving hop only
        $this->assertSame(32, $bodies[1]['max_tokens']);
        $this->assertSame(self::FALLBACK_MODEL, $bodies[1]['model']);
    }

    // --- cancellation -----------------------------------------------------------

    public function testClosingTheStreamMidPassthroughTearsDownWithoutAFallbackRequest(): void
    {
        $this->serve(self::sseResponse(self::streamA()));
        $client = $this->makeClient(new RefusalFallbackMiddleware(self::FALLBACKS));

        $stream = $this->createStream($client);
        $seen = 0;
        foreach ($stream as $_event) {
            ++$seen;
            if (2 === $seen) {
                break;
            }
        }
        $stream->close();

        // The splice never reached A's refusal, so no hop request was issued and
        // teardown released the underlying response without error.
        $this->assertCount(1, $this->transporter->requests);
    }

    // --- tool-use refusals ----------------------------------------------------
    //
    // Synthetic SSE (web_search-shaped) built from the documented wire shapes:
    // server_tool_use streams its input via input_json_delta after an empty
    // `input:{}`, and *_tool_result blocks arrive as a single content_block_start
    // with full content (no deltas). The server decides prefillability and
    // signals it via `fallback_has_prefill_claim`; the client's only rewrite is
    // reassembling tool inputs from their accumulated JSON deltas.

    public function testRefusalAfterACompletedServerTool(): void
    {
        $streamA = implode('', [
            self::messageStart(),
            self::ev([
                'type' => 'content_block_start',
                'index' => 0,
                'content_block' => ['type' => 'thinking', 'thinking' => '', 'signature' => ''],
            ]),
            self::ev([
                'type' => 'content_block_delta',
                'index' => 0,
                'delta' => ['type' => 'thinking_delta', 'thinking' => 'let me look this up'],
            ]),
            self::ev([
                'type' => 'content_block_delta',
                'index' => 0,
                'delta' => ['type' => 'signature_delta', 'signature' => 'sig=='],
            ]),
            self::ev(['type' => 'content_block_stop', 'index' => 0]),
            // server_tool_use: real input arrives via input_json_delta, not content_block_start.
            self::ev([
                'type' => 'content_block_start',
                'index' => 1,
                'content_block' => [
                    'type' => 'server_tool_use',
                    'id' => self::TOOL_USE_ID,
                    'name' => 'web_search',
                    'input' => new \stdClass,
                ],
            ]),
            self::ev([
                'type' => 'content_block_delta',
                'index' => 1,
                'delta' => ['type' => 'input_json_delta', 'partial_json' => '{"query":"solar eclipse"}'],
            ]),
            self::ev(['type' => 'content_block_stop', 'index' => 1]),
            // web_search_tool_result: full content in the start frame, no deltas.
            self::ev([
                'type' => 'content_block_start',
                'index' => 2,
                'content_block' => [
                    'type' => 'web_search_tool_result',
                    'tool_use_id' => self::TOOL_USE_ID,
                    'content' => [
                        [
                            'type' => 'web_search_result',
                            'url' => 'https://example.com',
                            'title' => 'x',
                            'encrypted_content' => 'e',
                            'page_age' => null,
                        ],
                    ],
                ],
            ]),
            self::ev(['type' => 'content_block_stop', 'index' => 2]),
            self::ev(['type' => 'content_block_start', 'index' => 3, 'content_block' => ['type' => 'text', 'text' => '']]),
            self::ev([
                'type' => 'content_block_delta',
                'index' => 3,
                'delta' => ['type' => 'text_delta', 'text' => 'Based on that, '],
            ]),
            self::ev(['type' => 'content_block_stop', 'index' => 3]),
            self::refusalDelta(),
            self::ev(['type' => 'message_stop']),
        ]);
        $this->serve(self::sseResponse($streamA), self::sseResponse(self::streamB()));
        $client = $this->makeClient(new RefusalFallbackMiddleware(self::FALLBACKS));

        $events = self::collect($this->createStream($client));

        // A's four blocks forwarded, fallback boundary at index 4, B continues at 5.
        $this->assertSame([
            [0, 'thinking'],
            [1, 'server_tool_use'],
            [2, 'web_search_tool_result'],
            [3, 'text'],
            [4, 'fallback'],
            [5, 'text'],
        ], self::blockStarts($events));

        $appended = self::arr(self::at($this->requestBodies()[1], 'messages', 1));
        $this->assertSame('assistant', $appended['role']);
        $this->assertSame([
            'thinking',
            'server_tool_use',
            'web_search_tool_result',
            'text',
        ], self::types($appended['content']));
        // The tool input is the parsed input_json_delta payload, not the empty
        // `{}` from content_block_start.
        $this->assertEquals([
            'type' => 'server_tool_use',
            'id' => self::TOOL_USE_ID,
            'name' => 'web_search',
            'input' => ['query' => 'solar eclipse'],
        ], self::at($appended, 'content', 1));
        // The result keeps its pairing id and content.
        $this->assertSame(self::TOOL_USE_ID, self::at($appended, 'content', 2, 'tool_use_id'));
    }

    public function testFullFixtureToolWire(): void
    {
        $this->serve(self::sseResponse(self::streamATool()), self::sseResponse(self::streamB()));
        $client = $this->makeClient(new RefusalFallbackMiddleware(self::FALLBACKS));

        $events = self::collect($this->createStream($client));

        $this->assertSame([
            [0, 'server_tool_use'],
            [1, 'web_search_tool_result'],
            [2, 'text'],
            [3, 'fallback'],
            [4, 'text'],
        ], self::blockStarts($events));

        $appended = self::arr(self::at($this->requestBodies()[1], 'messages', 1));
        $this->assertSame([
            'server_tool_use',
            'web_search_tool_result',
            'text',
        ], self::types($appended['content']));
        // Tool input reassembled from the accumulated input_json_delta chunks.
        $this->assertEquals([
            'type' => 'server_tool_use',
            'id' => 'srvtoolu_fixture_a_0001',
            'name' => 'web_search',
            'input' => ['query' => 'solar eclipse viewing safety news 2026'],
        ], self::at($appended, 'content', 0));
        // The result block keeps its pairing id.
        $this->assertSame('srvtoolu_fixture_a_0001', self::at($appended, 'content', 1, 'tool_use_id'));
        $this->assertSame('web_search_tool_result', self::at($appended, 'content', 1, 'type'));
    }

    // --- fixtures ---------------------------------------------------------------

    /**
     * Wire-shaped synthetic capture — the primary refuses after a thinking +
     * partial-text block and mints a credit token; the fallback then completes
     * the message.
     */
    private static function streamA(): string
    {
        return self::fixture('stream-a-refusal.sse');
    }

    private static function streamB(): string
    {
        return self::fixture('stream-b-fallback.sse');
    }

    /**
     * Server-tool wire (synthetic, wire-shaped): server_tool_use streams its input
     * via input_json_delta after an empty `input:{}`, the web_search_tool_result
     * arrives as a single content_block_start carrying full content, and the
     * refusal terminal (message_delta + token) lands mid-tool-loop, after a
     * partial text block. The token is never redeemed (the mock serves the next
     * leg).
     */
    private static function streamATool(): string
    {
        return self::fixture('stream-a-toolrefusal.sse');
    }

    private static function fixture(string $name): string
    {
        $contents = file_get_contents(dirname(__DIR__, 3).'/fixtures/refusal-fallback/'.$name);
        assert(is_string($contents));

        return $contents;
    }

    /**
     * Serialize one event payload as an SSE frame (its `type` is the event name).
     *
     * @param array<string,mixed> $data
     */
    private static function ev(array $data): string
    {
        $type = $data['type'];
        assert(is_string($type));

        return "event: {$type}\ndata: ".self::json($data)."\n\n";
    }

    private static function messageStart(): string
    {
        return self::ev([
            'type' => 'message_start',
            'message' => [
                'id' => 'msg_a',
                'type' => 'message',
                'role' => 'assistant',
                'model' => 'claude-fable-5',
                'content' => [],
                'stop_reason' => null,
                'stop_sequence' => null,
                'usage' => ['input_tokens' => 12, 'output_tokens' => 1],
            ],
        ]);
    }

    private static function refusalDelta(?string $token = 'tok_abc', bool $hasPrefillClaim = true): string
    {
        return self::ev([
            'type' => 'message_delta',
            'delta' => [
                'stop_reason' => 'refusal',
                'stop_sequence' => null,
                'stop_details' => [
                    'type' => 'refusal',
                    'category' => null,
                    'explanation' => null,
                    'fallback_credit_token' => $token,
                    'fallback_has_prefill_claim' => is_null($token) ? null : $hasPrefillClaim,
                ],
            ],
            'usage' => ['output_tokens' => 20],
        ]);
    }

    /**
     * The request-body form of a redeemed credit token — the object shape, best-effort mode.
     *
     * @return array{token: string, mode: string}
     */
    private static function redeemedToken(string $token): array
    {
        return ['token' => $token, 'mode' => 'best_effort'];
    }

    /** A fallback hop that contributes one text block, then refuses with a fresh token. */
    private static function hopRefusal(?string $token = 'tok_b', bool $hasPrefillClaim = true): string
    {
        return implode('', [
            self::messageStart(),
            self::ev(['type' => 'content_block_start', 'index' => 0, 'content_block' => ['type' => 'text', 'text' => '']]),
            self::ev([
                'type' => 'content_block_delta',
                'index' => 0,
                'delta' => ['type' => 'text_delta', 'text' => 'Partial from B. '],
            ]),
            self::ev(['type' => 'content_block_stop', 'index' => 0]),
            self::refusalDelta($token, $hasPrefillClaim),
            self::ev(['type' => 'message_stop']),
        ]);
    }

    private static function servingStream(string $model = self::FALLBACK_MODEL, string $messageId = 'msg_b'): string
    {
        return implode('', [
            self::ev([
                'type' => 'message_start',
                'message' => [
                    'id' => $messageId,
                    'type' => 'message',
                    'role' => 'assistant',
                    'model' => $model,
                    'content' => [],
                    'stop_reason' => null,
                    'stop_sequence' => null,
                    'usage' => ['input_tokens' => 12, 'output_tokens' => 1],
                ],
            ]),
            self::ev(['type' => 'content_block_start', 'index' => 0, 'content_block' => ['type' => 'text', 'text' => '']]),
            self::ev(['type' => 'content_block_delta', 'index' => 0, 'delta' => ['type' => 'text_delta', 'text' => 'Happy to help.']]),
            self::ev(['type' => 'content_block_stop', 'index' => 0]),
            self::ev([
                'type' => 'message_delta',
                'delta' => ['stop_reason' => 'end_turn', 'stop_sequence' => null],
                'usage' => ['output_tokens' => 9],
            ]),
            self::ev(['type' => 'message_stop']),
        ]);
    }

    private static function preStreamRefusal(): string
    {
        return implode('', [self::messageStart(), self::refusalDelta('tok_abc', false), self::ev(['type' => 'message_stop'])]);
    }

    // --- harness ----------------------------------------------------------------

    private function serve(ResponseInterface|\Exception ...$results): void
    {
        foreach ($results as $result) {
            $this->transporter->script[] = $result;
        }
    }

    private function makeClient(RefusalFallbackMiddleware $middleware): Client
    {
        return new Client(
            apiKey: self::API_KEY,
            requestOptions: ['transporter' => $this->transporter, 'maxRetries' => 0, 'middleware' => [$middleware]],
        );
    }

    /**
     * @param list<string>|null $betas
     *
     * @return EventStream
     */
    private function createStream(Client $client, ?array $betas = null): BaseStream
    {
        return $client->beta->messages->createStream(
            maxTokens: 1024,
            messages: [['role' => 'user', 'content' => 'Hey claudius! Can you tell me what a solar eclipse is?']],
            model: 'claude-fable-5',
            betas: $betas,
        );
    }

    private static function sseResponse(string $body): ResponseInterface
    {
        return Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse(200)
            ->withHeader('Content-Type', 'text/event-stream')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($body))
        ;
    }

    /** @param array<string,mixed> $body */
    private static function jsonResponse(array $body, int $status): ResponseInterface
    {
        return Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse($status)
            ->withHeader('Content-Type', 'application/json')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(self::json($body)))
        ;
    }

    private static function errorResponse(string $message, int $status): ResponseInterface
    {
        return self::jsonResponse(['type' => 'error', 'error' => ['type' => 'invalid_request_error', 'message' => $message]], $status);
    }

    /** A transport-level failure, as a PSR-18 client raises it. */
    private static function connectionError(string $message): \Exception
    {
        return new NetworkException($message, Psr17FactoryDiscovery::findRequestFactory()->createRequest('POST', '/v1/messages'));
    }

    private static function json(mixed $value): string
    {
        return json_encode($value, flags: JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    }

    /**
     * Drains a stream into the events the consumer saw, in wire shape.
     *
     * @param EventStream $stream
     *
     * @return list<array<string,mixed>>
     */
    private static function collect(BaseStream $stream): array
    {
        $events = [];
        foreach ($stream as $event) {
            $events[] = self::arr(json_decode(self::json($event), associative: true));
        }

        return $events;
    }

    /** @return list<array<string,mixed>> */
    private function requestBodies(): array
    {
        return array_map(static function (RequestInterface $request): array {
            $body = $request->getBody();
            $body->rewind();

            return self::arr(json_decode($body->getContents(), associative: true, flags: JSON_THROW_ON_ERROR));
        }, $this->transporter->requests);
    }

    /**
     * The `anthropic-beta` header of every request sent, split into its members.
     *
     * @return list<list<string>>
     */
    private function betaHeaders(): array
    {
        return array_map(
            static fn (RequestInterface $request): array => array_values(array_filter(array_map('trim', explode(',', $request->getHeaderLine('anthropic-beta'))))),
            $this->transporter->requests,
        );
    }

    /**
     * Compact structural skeleton of a spliced stream — no text content.
     *
     * @param list<array<string,mixed>> $events
     *
     * @return list<string>
     */
    private static function skeleton(array $events): array
    {
        $out = [];
        foreach ($events as $event) {
            $type = self::str($event['type'] ?? null);
            $index = self::str($event['index'] ?? null);
            if ('content_block_start' === $type) {
                $block = self::arr($event['content_block'] ?? null);
                $label = 'fallback' === ($block['type'] ?? null)
                    ? 'fallback{'.self::str(self::at($block, 'from', 'model')).'->'.self::str(self::at($block, 'to', 'model')).'}'
                    : self::str($block['type'] ?? null);
                $out[] = "start[{$index}] {$label}";
            } elseif ('content_block_delta' === $type) {
                $out[] = "delta[{$index}] ".self::str(self::at($event, 'delta', 'type'));
            } elseif ('content_block_stop' === $type) {
                $out[] = "stop[{$index}]";
            } elseif ('message_delta' === $type) {
                $iterations = implode(',', array_map(static fn (array $i): string => "{$i[0]}:{$i[1]}", self::iterations($event)));
                $out[] = 'message_delta '.self::str(self::at($event, 'delta', 'stop_reason'))." iter=[{$iterations}]";
            } else {
                $out[] = $type;
            }
        }

        return $out;
    }

    /**
     * @param list<array<string,mixed>> $events
     *
     * @return list<array{int, string}>
     */
    private static function blockStarts(array $events): array
    {
        $out = [];
        foreach (self::ofType($events, 'content_block_start') as $event) {
            $index = $event['index'] ?? null;
            $out[] = [is_int($index) ? $index : -1, self::str(self::at($event, 'content_block', 'type'))];
        }

        return $out;
    }

    /**
     * The `fallback` seam blocks the consumer saw, in order.
     *
     * @param list<array<string,mixed>> $events
     *
     * @return list<array<string,mixed>>
     */
    private static function boundaries(array $events): array
    {
        $out = [];
        foreach (self::ofType($events, 'content_block_start') as $event) {
            $block = self::arr($event['content_block'] ?? null);
            if ('fallback' === ($block['type'] ?? null)) {
                $out[] = $block;
            }
        }

        return $out;
    }

    /**
     * @param array<string,mixed> $boundary
     *
     * @return array{string|null, string|null}
     */
    private static function fromTo(array $boundary): array
    {
        $from = self::at($boundary, 'from', 'model');
        $to = self::at($boundary, 'to', 'model');

        return [is_string($from) ? $from : null, is_string($to) ? $to : null];
    }

    /**
     * A message_delta's `usage.iterations` as (type, model) pairs.
     *
     * @param array<string,mixed> $messageDelta
     *
     * @return list<array{string|null, string|null}>
     */
    private static function iterations(array $messageDelta): array
    {
        $out = [];
        foreach (self::items(self::at($messageDelta, 'usage', 'iterations')) as $iteration) {
            $iteration = self::arr($iteration);
            $type = $iteration['type'] ?? null;
            $model = $iteration['model'] ?? null;
            $out[] = [is_string($type) ? $type : null, is_string($model) ? $model : null];
        }

        return $out;
    }

    /**
     * @param list<array<string,mixed>> $events
     *
     * @return list<array<string,mixed>>
     */
    private static function ofType(array $events, string $type): array
    {
        return array_values(array_filter($events, static fn (array $e): bool => $type === ($e['type'] ?? null)));
    }

    /**
     * @param list<array<string,mixed>> $events
     *
     * @return array<string,mixed>
     */
    private static function first(array $events, string $type): array
    {
        $matches = self::ofType($events, $type);
        self::assertNotEmpty($matches, "no {$type} event in the stream");

        return $matches[0];
    }

    /**
     * The `type` of every block in a content list.
     *
     * @return list<string>
     */
    private static function types(mixed $content): array
    {
        return array_map(static fn ($block): string => self::str(self::arr($block)['type'] ?? null), self::items($content));
    }

    /** Digs a path of keys out of nested decoded JSON; null when any step is absent. */
    private static function at(mixed $value, string|int ...$path): mixed
    {
        foreach ($path as $key) {
            if (!is_array($value) || !array_key_exists($key, $value)) {
                return null;
            }
            $value = $value[$key];
        }

        return $value;
    }

    /** @return array<string,mixed> */
    private static function arr(mixed $value): array
    {
        if (!is_array($value)) {
            return [];
        }
        $out = [];
        foreach ($value as $k => $v) {
            $out[strval($k)] = $v;
        }

        return $out;
    }

    /** @return list<mixed> */
    private static function items(mixed $value): array
    {
        return is_array($value) ? array_values($value) : [];
    }

    private static function str(mixed $value): string
    {
        return is_string($value) ? $value : (is_int($value) ? strval($value) : '');
    }
}

/**
 * A PSR-18 client that serves scripted results in order — a response is
 * returned, an exception is thrown — and records every request it was sent.
 *
 * @internal
 */
final class ScriptedTransport implements ClientInterface
{
    /** @var list<ResponseInterface|\Exception> */
    public array $script = [];

    /** @var list<RequestInterface> */
    public array $requests = [];

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $this->requests[] = $request;
        $result = array_shift($this->script);
        if (is_null($result)) {
            throw new \LogicException('unexpected request #'.count($this->requests).': nothing scripted');
        }
        if ($result instanceof \Exception) {
            throw $result;
        }

        return $result;
    }
}
