<?php

namespace Tests\Lib\Middleware;

use Anthropic\Beta\Messages\BetaMessage;
use Anthropic\Beta\Messages\BetaOutputConfig;
use Anthropic\Beta\Messages\BetaThinkingConfigAdaptive;
use Anthropic\Beta\Messages\BetaThinkingConfigDisabled;
use Anthropic\Beta\Messages\BetaThinkingConfigEnabled;
use Anthropic\Client;
use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\InternalServerException;
use Anthropic\Core\Util;
use Anthropic\Lib\Helpers\StainlessHelperHeader;
use Anthropic\Lib\Middleware\BetaFallbackState;
use Anthropic\Lib\Middleware\RefusalFallbackMiddleware;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 *
 * @phpstan-import-type BetaMessageParamShape from \Anthropic\Beta\Messages\BetaMessageParam
 * @phpstan-import-type BetaFallbackParamShape from \Anthropic\Beta\Messages\BetaFallbackParam
 * @phpstan-import-type BetaThinkingConfigParamShape from \Anthropic\Beta\Messages\BetaThinkingConfigParam
 * @phpstan-import-type BetaOutputConfigShape from \Anthropic\Beta\Messages\BetaOutputConfig
 * @phpstan-import-type RequestOptionShape from \Anthropic\RequestOptions
 */
#[CoversNothing]
class RefusalFallbackMiddlewareTest extends TestCase
{
    private const PRIMARY = 'claude-fable-5';
    private const FALLBACK = 'claude-opus-4-8';
    private const CREDIT_BETA = 'fallback-credit-2026-07-01';
    private const SERVER_SIDE_BETA = 'server-side-fallback-2026-06-01';

    /**
     * The wire shape the middleware redeems a token with: the object form,
     * best-effort, so a token-layer failure serves the retry instead of 400ing.
     *
     * @return array{token: string, mode: string}
     */
    private static function creditToken(string $token): array
    {
        return ['token' => $token, 'mode' => 'best_effort'];
    }

    private MockClient $transporter;

    protected function setUp(): void
    {
        $this->transporter = new MockClient;
        $this->transporter->setDefaultResponse(self::message(model: self::FALLBACK));
    }

    public function testRetriesWithFallbackParamsAndCreditToken(): void
    {
        $this->transporter->addResponse(self::refusal(model: self::PRIMARY, token: 'tok_1'));
        $this->transporter->addResponse(self::message(model: self::FALLBACK));

        $message = $this->create($this->client());

        $this->assertSame(self::FALLBACK, $message->model);

        $requests = $this->transporter->getRequests();
        $this->assertCount(2, $requests);

        $first = self::bodyOf($requests[0]);
        $this->assertSame(self::PRIMARY, $first['model']);
        $this->assertArrayNotHasKey('fallback_credit_token', $first);
        $this->assertStringContainsString(self::CREDIT_BETA, $requests[0]->getHeaderLine('anthropic-beta'));

        $leg = self::bodyOf($requests[1]);
        $this->assertSame(self::FALLBACK, $leg['model']);
        $this->assertSame(self::creditToken('tok_1'), $leg['fallback_credit_token']);
        $this->assertSame($first['messages'], $leg['messages']);
    }

    public function testRetriesEvenWhenNoCreditTokenWasMinted(): void
    {
        $this->transporter->addResponse(self::refusal(model: self::PRIMARY, token: null));
        $this->transporter->addResponse(self::message(model: self::FALLBACK));

        $message = $this->create($this->client());

        $this->assertSame(self::FALLBACK, $message->model);
        $requests = $this->transporter->getRequests();
        $this->assertCount(2, $requests);
        $this->assertArrayNotHasKey('fallback_credit_token', self::bodyOf($requests[1]));
    }

    public function testTagsEveryLegWithTheHelperHeader(): void
    {
        $this->transporter->addResponse(self::refusal(model: self::PRIMARY, token: 'tok_1'));
        $this->transporter->addResponse(self::message(model: self::FALLBACK));

        $this->create($this->client());

        $requests = $this->transporter->getRequests();
        $this->assertCount(2, $requests);
        foreach ($requests as $request) {
            $this->assertSame(
                StainlessHelperHeader::FALLBACK_REFUSAL_MIDDLEWARE,
                $request->getHeaderLine(StainlessHelperHeader::HEADER),
            );
        }
    }

    public function testHelperTagAppendsToAnExistingHelperHeader(): void
    {
        $this->transporter->addResponse(self::message(model: self::PRIMARY));

        $this->create($this->client(), requestOptions: [
            'extraHeaders' => [StainlessHelperHeader::HEADER => 'BetaToolRunner'],
        ]);

        // composes with other helper tags rather than clobbering them
        $this->assertSame(
            'BetaToolRunner, '.StainlessHelperHeader::FALLBACK_REFUSAL_MIDDLEWARE,
            $this->transporter->getRequests()[0]->getHeaderLine(StainlessHelperHeader::HEADER),
        );
    }

    public function testPinsTheConversationToTheAcceptedFallback(): void
    {
        $this->transporter->addResponse(self::refusal(model: self::PRIMARY, token: 'tok_1'));
        $this->transporter->addResponse(self::message(model: self::FALLBACK));
        $this->transporter->addResponse(self::message(model: self::FALLBACK));

        $state = new BetaFallbackState;
        $client = $this->client(new RefusalFallbackMiddleware([['model' => self::FALLBACK]], state: $state));

        $this->create($client);
        $this->assertSame(0, $state->index);
        $this->create($client);

        $requests = $this->transporter->getRequests();
        $this->assertCount(3, $requests);

        // the follow-up turn goes straight to the pinned fallback, tokenless
        $followUp = self::bodyOf($requests[2]);
        $this->assertSame(self::FALLBACK, $followUp['model']);
        $this->assertArrayNotHasKey('fallback_credit_token', $followUp);
    }

    public function testKeepsSeparateConversationsIndependent(): void
    {
        $this->transporter->addResponse(self::refusal(model: self::PRIMARY, token: 'tok_1'));
        $this->transporter->addResponse(self::message(model: self::FALLBACK));
        $this->transporter->addResponse(self::message(model: self::PRIMARY));

        // a fresh state per conversation keeps the two independent
        $this->create($this->client(new RefusalFallbackMiddleware([['model' => self::FALLBACK]], state: new BetaFallbackState)));
        $this->create($this->client(new RefusalFallbackMiddleware([['model' => self::FALLBACK]], state: new BetaFallbackState)));

        $requests = $this->transporter->getRequests();
        $this->assertCount(3, $requests);
        $this->assertSame(self::PRIMARY, self::bodyOf($requests[2])['model']);
    }

    public function testRequestLevelFallbackStatePinsAcrossRequests(): void
    {
        $this->transporter->addResponse(self::refusal(model: self::PRIMARY, token: 'tok_1'));
        $this->transporter->addResponse(self::message(model: self::FALLBACK));
        $this->transporter->addResponse(self::message(model: self::FALLBACK));

        // no constructor state: the pin comes in per-request instead
        $state = new BetaFallbackState;
        $client = $this->client(new RefusalFallbackMiddleware([['model' => self::FALLBACK]]));

        $this->create($client, requestOptions: ['fallbackState' => $state]);
        $this->assertSame(0, $state->index);
        $this->create($client, requestOptions: ['fallbackState' => $state]);

        $requests = $this->transporter->getRequests();
        $this->assertCount(3, $requests);

        // the follow-up turn goes straight to the pinned fallback, tokenless
        $followUp = self::bodyOf($requests[2]);
        $this->assertSame(self::FALLBACK, $followUp['model']);
        $this->assertArrayNotHasKey('fallback_credit_token', $followUp);
    }

    public function testRequestLevelFallbackStateOverridesConstructorState(): void
    {
        $this->transporter->addResponse(self::refusal(model: self::PRIMARY, token: 'tok_1'));
        $this->transporter->addResponse(self::message(model: self::FALLBACK));
        $this->transporter->addResponse(self::message(model: self::PRIMARY));

        $constructorState = new BetaFallbackState;
        $requestState = new BetaFallbackState;
        $client = $this->client(new RefusalFallbackMiddleware([['model' => self::FALLBACK]], state: $constructorState));

        // the refusal pins the request-level state, not the constructor's
        $this->create($client, requestOptions: ['fallbackState' => $requestState]);
        $this->assertSame(0, $requestState->index);
        $this->assertNull($constructorState->index);

        // without a request-level state the untouched constructor state
        // applies, so the next turn starts at the primary again
        $this->create($client);
        $this->assertSame(self::PRIMARY, self::bodyOf($this->transporter->getRequests()[2])['model']);
    }

    public function testLeavesAcceptedRequestsUntouched(): void
    {
        $this->transporter->addResponse(self::message(model: self::PRIMARY));

        $message = $this->create($this->client());

        $this->assertSame(self::PRIMARY, $message->model);
        $requests = $this->transporter->getRequests();
        $this->assertCount(1, $requests);
        $this->assertSame(self::PRIMARY, self::bodyOf($requests[0])['model']);
    }

    public function testReportsEachHopThroughOnFallback(): void
    {
        $this->transporter->addResponse(self::refusal(model: self::PRIMARY, token: 'tok_1'));
        $this->transporter->addResponse(self::message(model: self::FALLBACK));

        $hops = [];
        $middleware = new RefusalFallbackMiddleware(
            [['model' => self::FALLBACK]],
            onFallback: function (mixed $refused, array $entry, int $index) use (&$hops): void {
                // the refused message arrives decoded to an array
                $model = is_array($refused) ? ($refused['model'] ?? null) : null;
                $hops[] = [$model, $entry['model'], $index];
            },
        );

        $this->create($this->client($middleware));

        $this->assertSame([[self::PRIMARY, self::FALLBACK, 0]], $hops);
    }

    public function testReturnsTheLastRefusalWhenTheChainIsExhausted(): void
    {
        $this->transporter->addResponse(self::refusal(model: self::PRIMARY, token: 'tok_1'));
        $this->transporter->addResponse(self::refusal(model: self::FALLBACK, token: 'tok_2'));

        $message = $this->create($this->client());

        $this->assertSame('refusal', $message->stopReason);
        $this->assertSame(self::FALLBACK, $message->model);
        $this->assertCount(2, $this->transporter->getRequests());
    }

    public function testAppliesFallbackOverridesAndPreservesOtherFields(): void
    {
        $this->transporter->addResponse(self::refusal(model: self::PRIMARY, token: 'tok_1'));
        $this->transporter->addResponse(self::message(model: self::FALLBACK));

        $middleware = new RefusalFallbackMiddleware([
            ['model' => self::FALLBACK, 'max_tokens' => 2048],
        ]);

        $this->create($this->client($middleware));

        $leg = self::bodyOf($this->transporter->getRequests()[1]);
        $this->assertSame(2048, $leg['max_tokens']);
        $this->assertSame(self::FALLBACK, $leg['model']);
        // max_tokens is token-safe, so the credit still rides along
        $this->assertSame(self::creditToken('tok_1'), $leg['fallback_credit_token']);
    }

    public function testMergesOnlyAllowlistedEntryOverridesAndAlwaysAttachesTheToken(): void
    {
        $this->transporter->addResponse(self::refusal(model: self::PRIMARY, token: 'tok_1'));
        $this->transporter->addResponse(self::message(model: self::FALLBACK));

        $middleware = new RefusalFallbackMiddleware([
            ['model' => self::FALLBACK, 'thinking' => ['type' => 'enabled', 'budget_tokens' => 1024], 'temperature' => 0.5],
        ]);

        $this->create($this->client($middleware));

        $leg = self::bodyOf($this->transporter->getRequests()[1]);
        // thinking is on the server's override allowlist and merges; the
        // credit token always rides a retry leg
        $this->assertSame(['type' => 'enabled', 'budget_tokens' => 1024], $leg['thinking']);
        $this->assertSame(self::creditToken('tok_1'), $leg['fallback_credit_token']);
        // temperature is not allowlisted: dropped, not sent
        $this->assertArrayNotHasKey('temperature', $leg);
    }

    public function testNullOverrideUnsetsTheFieldOnTheRetriedLeg(): void
    {
        $this->transporter->addResponse(self::refusal(model: self::PRIMARY, token: 'tok_1'));
        $this->transporter->addResponse(self::message(model: self::FALLBACK));

        $middleware = new RefusalFallbackMiddleware([
            ['model' => self::FALLBACK, 'max_tokens' => 2048, 'thinking' => null],
        ]);

        $this->create($this->client($middleware), thinking: ['type' => 'enabled', 'budgetTokens' => 1024]);

        $requests = $this->transporter->getRequests();
        $this->assertCount(2, $requests);
        $this->assertEquals(
            ['type' => 'enabled', 'budget_tokens' => 1024],
            self::bodyOf($requests[0])['thinking'],
        );

        // a hop is a PATCH on the original params: a set field overrides, an
        // explicit null unsets (absent from the wire, not sent as null)
        $leg = self::bodyOf($requests[1]);
        $this->assertSame(2048, $leg['max_tokens']);
        $this->assertArrayNotHasKey('thinking', $leg);
    }

    public function testAbsentOverrideKeepsTheOriginalValue(): void
    {
        $this->transporter->addResponse(self::refusal(model: self::PRIMARY, token: 'tok_1'));
        $this->transporter->addResponse(self::message(model: self::FALLBACK));

        $this->create($this->client(), thinking: ['type' => 'enabled', 'budgetTokens' => 1024]);

        // the entry names only a model: every other original field rides the
        // retry unchanged
        $leg = self::bodyOf($this->transporter->getRequests()[1]);
        $this->assertSame(self::FALLBACK, $leg['model']);
        $this->assertSame(1024, $leg['max_tokens']);
        $this->assertEquals(['type' => 'enabled', 'budget_tokens' => 1024], $leg['thinking']);
    }

    public function testHopsPatchTheOriginalParamsAndNeverCompound(): void
    {
        $secondFallback = 'claude-sonnet-4-6';
        $this->transporter->addResponse(self::refusal(model: self::PRIMARY, token: 'tok_1'));
        $this->transporter->addResponse(self::refusal(model: self::FALLBACK, token: 'tok_2'));
        $this->transporter->addResponse(self::message(model: $secondFallback));

        $middleware = new RefusalFallbackMiddleware([
            ['model' => self::FALLBACK, 'max_tokens' => 2048, 'thinking' => null],
            ['model' => $secondFallback],
        ]);

        $this->create($this->client($middleware), thinking: ['type' => 'enabled', 'budgetTokens' => 1024]);

        $requests = $this->transporter->getRequests();
        $this->assertCount(3, $requests);

        $hop1 = self::bodyOf($requests[1]);
        $this->assertSame(2048, $hop1['max_tokens']);
        $this->assertArrayNotHasKey('thinking', $hop1);

        // hop 2 patches the ORIGINAL params: hop 1's max_tokens override and
        // thinking unset never leak forward
        $hop2 = self::bodyOf($requests[2]);
        $this->assertSame($secondFallback, $hop2['model']);
        $this->assertSame(1024, $hop2['max_tokens']);
        $this->assertEquals(['type' => 'enabled', 'budget_tokens' => 1024], $hop2['thinking']);
    }

    public function testOutputConfigSubfieldOverridePatchesTheExistingConfig(): void
    {
        $this->transporter->addResponse(self::refusal(model: self::PRIMARY, token: 'tok_1'));
        $this->transporter->addResponse(self::message(model: self::FALLBACK));

        $middleware = new RefusalFallbackMiddleware([
            ['model' => self::FALLBACK, 'output_config' => ['effort' => 'high']],
        ]);

        $this->create(
            $this->client($middleware),
            outputConfig: ['effort' => 'low', 'taskBudget' => ['total' => 500, 'type' => 'tokens']],
        );

        // output_config subfields patch one level deep: the entry sets only
        // effort, the original's task_budget rides along untouched
        $leg = self::bodyOf($this->transporter->getRequests()[1]);
        $this->assertEquals(
            ['effort' => 'high', 'task_budget' => ['total' => 500, 'type' => 'tokens']],
            $leg['output_config'],
        );
    }

    public function testOutputConfigSubfieldNullUnsetsOnlyThatSubfield(): void
    {
        $this->transporter->addResponse(self::refusal(model: self::PRIMARY, token: 'tok_1'));
        $this->transporter->addResponse(self::message(model: self::FALLBACK));

        $middleware = new RefusalFallbackMiddleware([
            ['model' => self::FALLBACK, 'output_config' => ['effort' => null]],
        ]);

        $this->create(
            $this->client($middleware),
            outputConfig: ['effort' => 'low', 'taskBudget' => ['total' => 500, 'type' => 'tokens']],
        );

        // an explicit null subfield unsets just that key from the wire
        $leg = self::bodyOf($this->transporter->getRequests()[1]);
        $this->assertEquals(['task_budget' => ['total' => 500, 'type' => 'tokens']], $leg['output_config']);
    }

    public function testWholeOutputConfigNullUnsetsIt(): void
    {
        $this->transporter->addResponse(self::refusal(model: self::PRIMARY, token: 'tok_1'));
        $this->transporter->addResponse(self::message(model: self::FALLBACK));

        $middleware = new RefusalFallbackMiddleware([
            ['model' => self::FALLBACK, 'output_config' => null],
        ]);

        $this->create($this->client($middleware), outputConfig: ['effort' => 'low']);

        // a null on the whole field unsets it, subfields and all
        $leg = self::bodyOf($this->transporter->getRequests()[1]);
        $this->assertArrayNotHasKey('output_config', $leg);
    }

    public function testAbsentOutputConfigKeepsTheOriginal(): void
    {
        $this->transporter->addResponse(self::refusal(model: self::PRIMARY, token: 'tok_1'));
        $this->transporter->addResponse(self::message(model: self::FALLBACK));

        $this->create($this->client(), outputConfig: ['effort' => 'low']);

        $leg = self::bodyOf($this->transporter->getRequests()[1]);
        $this->assertEquals(['effort' => 'low'], $leg['output_config']);
    }

    public function testOutputConfigSubfieldsCreateTheConfigWhenTheOriginalHasNone(): void
    {
        $this->transporter->addResponse(self::refusal(model: self::PRIMARY, token: 'tok_1'));
        $this->transporter->addResponse(self::message(model: self::FALLBACK));

        $middleware = new RefusalFallbackMiddleware([
            ['model' => self::FALLBACK, 'output_config' => ['effort' => 'high', 'format' => null]],
        ]);

        $this->create($this->client($middleware));

        // no original output_config: the retry gets one holding just the
        // set subfields — null subfields never materialize
        $leg = self::bodyOf($this->transporter->getRequests()[1]);
        $this->assertEquals(['effort' => 'high'], $leg['output_config']);
    }

    public function testOutputConfigUnsettingEverySubfieldDropsTheKey(): void
    {
        $this->transporter->addResponse(self::refusal(model: self::PRIMARY, token: 'tok_1'));
        $this->transporter->addResponse(self::message(model: self::FALLBACK));

        $middleware = new RefusalFallbackMiddleware([
            ['model' => self::FALLBACK, 'output_config' => ['effort' => null]],
        ]);

        $this->create($this->client($middleware), outputConfig: ['effort' => 'low']);

        // the entry unset the original's only subfield: the whole field is
        // dropped from the wire, never sent as an empty object
        $leg = self::bodyOf($this->transporter->getRequests()[1]);
        $this->assertArrayNotHasKey('output_config', $leg);
    }

    public function testOutputConfigOfOnlyNullSubfieldsNeverMaterializes(): void
    {
        $this->transporter->addResponse(self::refusal(model: self::PRIMARY, token: 'tok_1'));
        $this->transporter->addResponse(self::message(model: self::FALLBACK));

        $middleware = new RefusalFallbackMiddleware([
            ['model' => self::FALLBACK, 'output_config' => ['effort' => null]],
        ]);

        $this->create($this->client($middleware));

        // no original output_config and only null subfields in the entry:
        // nothing is created — no empty object reaches the wire
        $leg = self::bodyOf($this->transporter->getRequests()[1]);
        $this->assertArrayNotHasKey('output_config', $leg);
    }

    public function testOutputConfigHopsPatchTheOriginalAndNeverCompound(): void
    {
        $secondFallback = 'claude-sonnet-4-6';
        $this->transporter->addResponse(self::refusal(model: self::PRIMARY, token: 'tok_1'));
        $this->transporter->addResponse(self::refusal(model: self::FALLBACK, token: 'tok_2'));
        $this->transporter->addResponse(self::message(model: $secondFallback));

        $middleware = new RefusalFallbackMiddleware([
            ['model' => self::FALLBACK, 'output_config' => ['effort' => 'high', 'task_budget' => null]],
            ['model' => $secondFallback, 'output_config' => ['format' => null]],
        ]);

        $this->create(
            $this->client($middleware),
            outputConfig: ['effort' => 'low', 'taskBudget' => ['total' => 500, 'type' => 'tokens']],
        );

        $requests = $this->transporter->getRequests();
        $this->assertCount(3, $requests);
        $this->assertEquals(['effort' => 'high'], self::bodyOf($requests[1])['output_config']);

        // hop 2 patches the ORIGINAL output_config: hop 1's effort override
        // and task_budget unset don't leak forward
        $this->assertEquals(
            ['effort' => 'low', 'task_budget' => ['total' => 500, 'type' => 'tokens']],
            self::bodyOf($requests[2])['output_config'],
        );
    }

    public function testDuplicateRegistrationWalksOnce(): void
    {
        // client-level and request-level middleware compose, so the same
        // instance ending up twice in the pipeline nests two walkers; the
        // inner must stand down — one walk, one seam, one ledger.
        $this->transporter->addResponse(self::refusal(model: self::PRIMARY, token: 'tok_1'));
        $this->transporter->addResponse(self::message(self::FALLBACK));

        $mw = new RefusalFallbackMiddleware([['model' => self::FALLBACK]]);
        $client = new Client(
            apiKey: 'my-anthropic-api-key',
            requestOptions: ['transporter' => $this->transporter, 'middleware' => [$mw, $mw]],
        );
        $message = $this->create($client);

        $this->assertCount(2, $this->transporter->getRequests());
        $this->assertSame('fallback', $message->content[0]->toProperties()['type']);
        $this->assertCount(2, $message->content);
    }

    public function testEntryNamingTheRefusedModelIsNeverReAsked(): void
    {
        // The never-re-ask guarantee holds by model, not chain index: the
        // server 400s same-model redemptions, so the entry is skipped and
        // the refusal surfaces verbatim after exactly one request.
        $this->transporter->addResponse(self::refusal(model: self::PRIMARY, token: 'tok_1'));

        $message = $this->create($this->client(new RefusalFallbackMiddleware([['model' => self::PRIMARY]])));

        $this->assertCount(1, $this->transporter->getRequests());
        $this->assertSame('refusal', $message->stopReason);
    }

    public function testErrorsBeforeAnyRequestWhenTheBodyCarriesServerSideFallbacks(): void
    {
        // The server-side chain and the middleware cannot both own a
        // request — error client-side, send nothing.
        try {
            $this->create($this->client(), fallbacks: [['model' => 'claude-haiku-4-5']]);
            $this->fail('Expected AnthropicException to be thrown');
        } catch (AnthropicException $e) {
            $this->assertStringContainsString('fallbacks', $e->getMessage());
        }
        $this->assertCount(0, $this->transporter->getRequests());
    }

    public function testRejectsAnOutOfBoundsPin(): void
    {
        $state = new BetaFallbackState;
        $state->index = 5;

        try {
            $this->create($this->client(new RefusalFallbackMiddleware([['model' => self::FALLBACK]], state: $state)));
            $this->fail('Expected AnthropicException to be thrown');
        } catch (AnthropicException $e) {
            $this->assertStringContainsString('out of bounds', $e->getMessage());
        }
        // erred client-side: nothing reached the wire
        $this->assertCount(0, $this->transporter->getRequests());
    }

    public function testRetriesARejectedTokenOnceWithoutIt(): void
    {
        $this->transporter->addResponse(self::refusal(model: self::PRIMARY, token: 'tok_stale'));
        $this->transporter->addResponse(self::json(['error' => ['type' => 'invalid_request_error', 'message' => 'bad token']], status: 400));
        $this->transporter->addResponse(self::message(model: self::FALLBACK));

        $message = $this->create($this->client());

        $this->assertSame(self::FALLBACK, $message->model);

        $requests = $this->transporter->getRequests();
        $this->assertCount(3, $requests);
        $this->assertSame(self::creditToken('tok_stale'), self::bodyOf($requests[1])['fallback_credit_token']);
        $this->assertArrayNotHasKey('fallback_credit_token', self::bodyOf($requests[2]));
    }

    public function testHistorySeamsStripFromTheWireAndPinNothing(): void
    {
        $this->transporter->addResponse(self::message(model: self::PRIMARY));

        $messages = [
            ['role' => 'user', 'content' => 'hi'],
            ['role' => 'assistant', 'content' => [
                ['type' => 'text', 'text' => 'partial'],
                ['type' => 'fallback', 'from' => ['model' => self::PRIMARY], 'to' => ['model' => self::FALLBACK]],
                ['type' => 'text', 'text' => 'continued'],
            ]],
            ['role' => 'user', 'content' => 'continue'],
        ];

        $this->create($this->client(), messages: $messages);

        $request = $this->transporter->getRequests()[0];
        $body = self::bodyOf($request);

        // explicit-state pinning only: the seam pins nothing
        $this->assertSame(self::PRIMARY, $body['model']);
        // the seam is stripped from the outgoing wire (parse-gated behind
        // the caller-owned server-side beta, which is never sent here)
        $assistant = is_array($body['messages']) ? $body['messages'][1] : null;
        $this->assertIsArray($assistant);
        $this->assertSame(
            [['type' => 'text', 'text' => 'partial'], ['type' => 'text', 'text' => 'continued']],
            $assistant['content'],
        );
        $this->assertStringNotContainsString(self::SERVER_SIDE_BETA, $request->getHeaderLine('anthropic-beta'));
        $this->assertStringContainsString(self::CREDIT_BETA, $request->getHeaderLine('anthropic-beta'));
    }

    public function testLeavesUserContentSeamsAlone(): void
    {
        $this->transporter->addResponse(self::message(model: self::PRIMARY));

        $messages = [
            ['role' => 'user', 'content' => [
                ['type' => 'fallback', 'to' => ['model' => self::FALLBACK]],
                ['type' => 'text', 'text' => 'hi'],
            ]],
        ];

        $this->create($this->client(), messages: $messages);

        $body = self::bodyOf($this->transporter->getRequests()[0]);
        // only assistant turns are stripped; a forged user-content seam is
        // the server's to reject
        $this->assertSame(self::PRIMARY, $body['model']);
        $user = is_array($body['messages']) ? $body['messages'][0] : null;
        $this->assertIsArray($user);
        $content = $user['content'] ?? null;
        $this->assertIsArray($content);
        $this->assertCount(2, $content);
    }

    public function testPassesErrorResponsesThroughWithoutWalkingTheChain(): void
    {
        $this->transporter->addResponse(self::json(['error' => ['type' => 'api_error', 'message' => 'boom']], status: 500));

        $this->expectException(InternalServerException::class);

        try {
            $this->create($this->client(), requestOptions: ['maxRetries' => 0]);
        } finally {
            // only a 200 can be a refusal; an error response is final
            $requests = $this->transporter->getRequests();
            $this->assertCount(1, $requests);
            $this->assertSame(self::PRIMARY, self::bodyOf($requests[0])['model']);
        }
    }

    public function testServedStreamingRequestsAreArmedAndFlowIntact(): void
    {
        $sse = implode('', [
            "event: message_start\n",
            'data: {"type":"message_start","message":{"id":"msg_s","type":"message","role":"assistant","model":"'.self::PRIMARY.'","content":[],"usage":{"input_tokens":1,"output_tokens":0}}}'."\n\n",
            "event: message_delta\n",
            'data: {"type":"message_delta","delta":{"stop_reason":"end_turn"},"usage":{"output_tokens":1}}'."\n\n",
            "event: message_stop\n",
            'data: {"type":"message_stop"}'."\n\n",
        ]);
        $this->transporter->addResponse(
            Psr17FactoryDiscovery::findResponseFactory()
                ->createResponse(200)
                ->withHeader('Content-Type', 'text/event-stream')
                ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($sse))
        );

        $stream = $this->client()->beta->messages->createStream(
            maxTokens: 1024,
            messages: [['role' => 'user', 'content' => 'hi']],
            model: self::PRIMARY,
        );

        $types = [];
        foreach ($stream as $event) {
            $types[] = $event->type;
        }

        // a served stream reaches the consumer event-for-event through the
        // splicer, and the request was armed
        $this->assertSame(['message_start', 'message_delta', 'message_stop'], $types);

        $requests = $this->transporter->getRequests();
        $this->assertCount(1, $requests);

        $body = self::bodyOf($requests[0]);
        $this->assertSame(self::PRIMARY, $body['model']);
        $this->assertTrue($body['stream']);
        $this->assertStringContainsString(self::CREDIT_BETA, $requests[0]->getHeaderLine('anthropic-beta'));
    }

    public function testStaleCallerTokenNotForwardedToRetries(): void
    {
        $this->transporter->addResponse(self::refusal(model: self::PRIMARY, token: 'tok_fresh'));
        $this->transporter->addResponse(self::message(self::FALLBACK));

        $message = $this->create($this->client(), fallbackCreditToken: 'tok_stale_from_caller');

        // the chain walks: leg 1 goes out as the caller spelled it (stale
        // token included, beta armed); the retry carries the FRESH token the
        // refusal minted, never the caller's stale one
        $this->assertSame('end_turn', $message->stopReason);
        $requests = $this->transporter->getRequests();
        $this->assertCount(2, $requests);
        $this->assertSame('tok_stale_from_caller', self::bodyOf($requests[0])['fallback_credit_token']);
        $this->assertStringContainsString(self::CREDIT_BETA, $requests[0]->getHeaderLine('anthropic-beta'));
        $this->assertSame(self::creditToken('tok_fresh'), self::bodyOf($requests[1])['fallback_credit_token']);
    }

    public function testRedeemedHopPrependsTheFallbackSeamBlock(): void
    {
        $this->transporter->addResponse(self::refusal(model: self::PRIMARY, token: 'tok_1'));
        $this->transporter->addResponse(self::message(self::FALLBACK));

        $message = $this->create($this->client());

        // a redeemed hop mirrors the server-side stitched envelope: the seam
        // block rides first, then the serving content
        $this->assertCount(2, $message->content);
        $first = json_decode(
            json_encode(Conversion::dump(get_class($message->content[0]), value: $message->content[0])) ?: 'null',
            associative: true,
        );
        $this->assertSame(
            ['type' => 'fallback', 'from' => ['model' => self::PRIMARY], 'to' => ['model' => self::FALLBACK]],
            $first,
        );
        $this->assertSame('text', $message->content[1]->toProperties()['type']);
    }

    public function testSeamModelKeepsTheCallerSpelling(): void
    {
        // The caller requests under an alias and the refusal answers under
        // a canonical id; the seam carries the caller's spelling — the
        // request alias, exactly as sent.
        $this->transporter->addResponse(self::refusal(model: 'claude-fable-5-20990101', token: 'tok_1'));
        $this->transporter->addResponse(self::message(self::FALLBACK));

        $message = $this->create($this->client());

        $first = json_decode(
            json_encode(Conversion::dump(get_class($message->content[0]), value: $message->content[0])) ?: 'null',
            associative: true,
        );
        $this->assertSame(
            ['type' => 'fallback', 'from' => ['model' => self::PRIMARY], 'to' => ['model' => self::FALLBACK]],
            $first,
        );
    }

    public function testTokenlessRetryPrependsNoSeamBlock(): void
    {
        $this->transporter->addResponse(self::refusal(model: self::PRIMARY, token: null));
        $this->transporter->addResponse(self::message(self::FALLBACK));

        $message = $this->create($this->client());

        // no redemption, no seam — matching the server, which only stitches
        // through the credit-token path
        $this->assertCount(1, $message->content);
        $this->assertSame('text', $message->content[0]->toProperties()['type']);
    }

    public function testTokenDropRecoveryPrependsNoSeamBlock(): void
    {
        $this->transporter->addResponse(self::refusal(model: self::PRIMARY, token: 'tok_rejected'));
        $this->transporter->addResponse(self::json(['type' => 'error'], status: 400));
        $this->transporter->addResponse(self::message(self::FALLBACK));

        $message = $this->create($this->client());

        // the tokened leg 400ed and the tokenless re-send served: the seam is
        // tied to the redemption, so the recovered hop carries none
        $this->assertSame('end_turn', $message->stopReason);
        $this->assertCount(1, $message->content);
        $this->assertSame('text', $message->content[0]->toProperties()['type']);
    }

    public function testSeamOnlyHistoryTurnsAreDroppedEntirely(): void
    {
        $this->transporter->addResponse(self::message(self::PRIMARY));

        $this->create($this->client(), messages: [
            ['role' => 'user', 'content' => 'hi'],
            ['role' => 'assistant', 'content' => [
                ['type' => 'fallback', 'from' => ['model' => self::PRIMARY], 'to' => ['model' => self::FALLBACK]],
            ]],
            ['role' => 'user', 'content' => 'continue'],
        ]);

        // stripping the seam leaves an empty assistant turn, which fails
        // validation when echoed — the turn vanishes from the wire
        $messages = self::bodyOf($this->transporter->getRequests()[0])['messages'];
        $this->assertIsArray($messages);
        $this->assertCount(2, $messages);
        $this->assertSame(['user', 'user'], array_column($messages, 'role'));
    }

    public function testStreamingEchoRstripsTheTrailingWhitespace(): void
    {
        $leg1 = implode('', [
            "event: message_start\n",
            'data: {"type":"message_start","message":{"id":"msg_r","type":"message","role":"assistant","model":"'.self::PRIMARY.'","content":[],"usage":{"input_tokens":1,"output_tokens":0}}}'."\n\n",
            "event: content_block_start\n",
            'data: {"type":"content_block_start","index":0,"content_block":{"type":"text","text":""}}'."\n\n",
            "event: content_block_delta\n",
            'data: {"type":"content_block_delta","index":0,"delta":{"type":"text_delta","text":"partial "}}'."\n\n",
            "event: content_block_stop\n",
            'data: {"type":"content_block_stop","index":0}'."\n\n",
            "event: message_delta\n",
            'data: {"type":"message_delta","delta":{"stop_reason":"refusal","stop_details":{"type":"refusal","fallback_credit_token":"tok_s","fallback_has_prefill_claim":true}},"usage":{"output_tokens":1}}'."\n\n",
            "event: message_stop\n",
            'data: {"type":"message_stop"}'."\n\n",
        ]);
        $leg2 = implode('', [
            "event: message_start\n",
            'data: {"type":"message_start","message":{"id":"msg_f","type":"message","role":"assistant","model":"'.self::FALLBACK.'","content":[],"usage":{"input_tokens":1,"output_tokens":0}}}'."\n\n",
            "event: message_delta\n",
            'data: {"type":"message_delta","delta":{"stop_reason":"end_turn"},"usage":{"output_tokens":1}}'."\n\n",
            "event: message_stop\n",
            'data: {"type":"message_stop"}'."\n\n",
        ]);
        foreach ([$leg1, $leg2] as $sse) {
            $this->transporter->addResponse(
                Psr17FactoryDiscovery::findResponseFactory()
                    ->createResponse(200)
                    ->withHeader('Content-Type', 'text/event-stream')
                    ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($sse))
            );
        }

        $stream = $this->client()->beta->messages->createStream(
            maxTokens: 1024,
            messages: [['role' => 'user', 'content' => 'hi']],
            model: self::PRIMARY,
        );
        foreach ($stream as $event);

        // the claim hash canonicalizes with an rstrip on mint AND redeem, and
        // the API 400s a final assistant message ending in whitespace — the
        // echoed partial must go out trimmed
        $requests = $this->transporter->getRequests();
        $this->assertCount(2, $requests);
        $messages = self::bodyOf($requests[1])['messages'];
        $this->assertIsArray($messages);
        $turn = $messages[1] ?? null;
        $this->assertIsArray($turn);
        $content = $turn['content'] ?? null;
        $this->assertIsArray($content);
        $block = $content[0] ?? null;
        $this->assertIsArray($block);
        $this->assertSame('partial', $block['text'] ?? null);
    }

    public function testSkipsRequestsItDoesNotApplyTo(): void
    {
        $this->transporter->addResponse(self::json(['data' => [], 'has_more' => false, 'first_id' => null, 'last_id' => null]));

        $client = $this->client();
        $client->models->list();

        $requests = $this->transporter->getRequests();
        $this->assertCount(1, $requests);
        $this->assertStringNotContainsString(self::CREDIT_BETA, $requests[0]->getHeaderLine('anthropic-beta'));
    }

    public function testErrorsWhenAFallbackHasNoModel(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new RefusalFallbackMiddleware([['max_tokens' => 2048]]);
    }

    /**
     * @param list<BetaMessageParamShape>|null $messages
     * @param list<BetaFallbackParamShape>|null $fallbacks
     * @param RequestOptionShape|null $requestOptions
     * @param BetaThinkingConfigParamShape|null $thinking
     * @param BetaOutputConfig|BetaOutputConfigShape|null $outputConfig
     */
    private function create(
        Client $client,
        ?array $messages = null,
        ?string $fallbackCreditToken = null,
        ?array $fallbacks = null,
        ?array $requestOptions = null,
        BetaThinkingConfigEnabled|array|BetaThinkingConfigDisabled|BetaThinkingConfigAdaptive|null $thinking = null,
        BetaOutputConfig|array|null $outputConfig = null,
    ): BetaMessage {
        return $client->beta->messages->create(
            maxTokens: 1024,
            messages: $messages ?? [['role' => 'user', 'content' => 'hi']],
            model: self::PRIMARY,
            fallbackCreditToken: $fallbackCreditToken,
            fallbacks: $fallbacks,
            outputConfig: $outputConfig,
            thinking: $thinking,
            requestOptions: $requestOptions,
        );
    }

    private function client(?RefusalFallbackMiddleware $middleware = null): Client
    {
        $middleware ??= new RefusalFallbackMiddleware([['model' => self::FALLBACK]]);

        return new Client(
            apiKey: 'my-anthropic-api-key',
            requestOptions: ['transporter' => $this->transporter, 'middleware' => [$middleware]],
        );
    }

    /** @return array<string,mixed> */
    private static function bodyOf(RequestInterface $request): array
    {
        $body = $request->getBody();
        $body->rewind();

        $decoded = json_decode($body->getContents(), associative: true, flags: JSON_THROW_ON_ERROR);
        if (!is_array($decoded)) {
            throw new \RuntimeException('expected a JSON object request body');
        }

        $out = [];
        foreach ($decoded as $key => $value) {
            $out[strval($key)] = $value;
        }

        return $out;
    }

    private static function message(string $model): ResponseInterface
    {
        return self::json([
            'id' => 'msg_ok',
            'type' => 'message',
            'role' => 'assistant',
            'model' => $model,
            'content' => [['type' => 'text', 'text' => 'hello', 'citations' => null]],
            'stop_reason' => 'end_turn',
            'usage' => ['input_tokens' => 1, 'output_tokens' => 1],
        ]);
    }

    private static function refusal(string $model, ?string $token): ResponseInterface
    {
        return self::json([
            'id' => 'msg_refused',
            'type' => 'message',
            'role' => 'assistant',
            'model' => $model,
            'content' => [],
            'stop_reason' => 'refusal',
            'stop_details' => [
                'type' => 'refusal',
                ...(is_null($token) ? [] : ['fallback_credit_token' => $token]),
            ],
            'usage' => ['input_tokens' => 1, 'output_tokens' => 0],
        ]);
    }

    /** @param array<string,mixed> $body */
    private static function json(array $body, int $status = 200): ResponseInterface
    {
        return Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse($status)
            ->withHeader('Content-Type', 'application/json')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(json_encode($body, flags: Util::JSON_ENCODE_FLAGS) ?: ''))
        ;
    }
}
