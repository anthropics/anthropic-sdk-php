<?php

namespace Tests\Lib\Streaming;

use Anthropic\Beta\Messages\BetaClearThinking20251015EditResponse;
use Anthropic\Beta\Messages\BetaContainer;
use Anthropic\Beta\Messages\BetaContextManagementResponse;
use Anthropic\Beta\Messages\BetaMessageDeltaUsage;
use Anthropic\Beta\Messages\BetaOutputTokensDetails;
use Anthropic\Beta\Messages\BetaRawMessageDeltaEvent;
use Anthropic\Beta\Messages\BetaRawMessageDeltaEvent\Delta;
use Anthropic\Client;
use Anthropic\Lib\Streaming\MessageAccumulator;
use Anthropic\Messages\RawContentBlockDeltaEvent;
use Anthropic\Messages\RawContentBlockStartEvent;
use Anthropic\Messages\RawMessageStartEvent;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Replays the shared cross-SDK accumulator snapshot fixtures
 * (`fixtures/{ga,beta}/<case>.{txt,json}`, byte-identical across the SDK
 * repos): each `.txt` is a verbatim captured streaming HTTP response, each
 * `.json` the message it must accumulate to, asserted as a deep subset.
 *
 * @internal
 *
 * @coversNothing
 */
class MessageAccumulatorTest extends TestCase
{
    #[DataProvider('gaFixtures')]
    public function testAccumulatesGaFixture(string $case): void
    {
        $client = self::client(self::fixtureResponse('ga', case: $case));

        $accumulator = MessageAccumulator::forMessages();
        $stream = $client->messages->createStream(1024, [['role' => 'user', 'content' => 'hi']], 'claude-sonnet-4-5');
        foreach ($stream as $event) {
            $accumulator->accumulate($event);
        }

        $this->assertTrue($accumulator->isComplete());
        self::assertDeepSubset(
            self::expected('ga', case: $case),
            actual: $accumulator->message()->jsonSerialize(),
        );
    }

    /** @return iterable<string,array{string}> */
    public static function gaFixtures(): iterable
    {
        return self::fixtures('ga');
    }

    #[DataProvider('betaFixtures')]
    public function testAccumulatesBetaFixture(string $case): void
    {
        $client = self::client(self::fixtureResponse('beta', case: $case));

        $accumulator = MessageAccumulator::forBetaMessages();
        $stream = $client->beta->messages->createStream(1024, [['role' => 'user', 'content' => 'hi']], 'claude-sonnet-4-5');
        foreach ($stream as $event) {
            $accumulator->accumulate($event);
        }

        $this->assertTrue($accumulator->isComplete());
        self::assertDeepSubset(
            self::expected('beta', case: $case),
            actual: $accumulator->message()->jsonSerialize(),
        );
    }

    /** @return iterable<string,array{string}> */
    public static function betaFixtures(): iterable
    {
        return self::fixtures('beta');
    }

    public function testMidStreamSnapshotKeepsToolInputPlaceholder(): void
    {
        $accumulator = MessageAccumulator::forMessages()
            ->accumulate(['type' => 'message_start', 'message' => self::startMessage()])
            ->accumulate(['type' => 'content_block_start', 'index' => 0, 'content_block' => ['type' => 'tool_use', 'id' => 'toolu_1', 'name' => 'get_weather', 'input' => (object) []]])
            ->accumulate(['type' => 'content_block_delta', 'index' => 0, 'delta' => ['type' => 'input_json_delta', 'partial_json' => '{"loca']])
        ;

        $this->assertFalse($accumulator->isComplete());
        $this->assertSame([], (array) self::blockField($accumulator->message()->jsonSerialize(), index: 0, field: 'input'));

        // once the chunks complete, the input decodes
        $accumulator
            ->accumulate(['type' => 'content_block_delta', 'index' => 0, 'delta' => ['type' => 'input_json_delta', 'partial_json' => 'tion": "Paris"}']])
            ->accumulate(['type' => 'content_block_stop', 'index' => 0])
        ;
        $this->assertSame(['location' => 'Paris'], (array) self::blockField($accumulator->message()->jsonSerialize(), index: 0, field: 'input'));
    }

    public function testFallbackSeamBlockRelabelsTheModel(): void
    {
        // the accumulated model is the SERVED model: a fallback seam block's
        // to.model wins over message_start's, last seam wins overall
        $accumulator = MessageAccumulator::forBetaMessages()
            ->accumulate(['type' => 'message_start', 'message' => self::startMessage()])
            ->accumulate(['type' => 'content_block_start', 'index' => 0, 'content_block' => [
                'type' => 'fallback', 'from' => ['model' => 'claude-sonnet-4-5'], 'to' => ['model' => 'claude-opus-4-8'],
            ]])
            ->accumulate(['type' => 'content_block_stop', 'index' => 0])
        ;

        $wire = (array) $accumulator->message()->jsonSerialize();
        $this->assertSame('claude-opus-4-8', $wire['model'] ?? null);
    }

    public function testIncompleteToolInputBufferKeepsThePlaceholder(): void
    {
        // a block cut open mid-input_json_delta (e.g. by a refusal) can
        // complete with an undecodable buffer; the start placeholder stays
        $accumulator = MessageAccumulator::forMessages()
            ->accumulate(['type' => 'message_start', 'message' => self::startMessage()])
            ->accumulate(['type' => 'content_block_start', 'index' => 0, 'content_block' => ['type' => 'tool_use', 'id' => 'toolu_1', 'name' => 'get_weather', 'input' => (object) []]])
            ->accumulate(['type' => 'content_block_delta', 'index' => 0, 'delta' => ['type' => 'input_json_delta', 'partial_json' => '{"nums": [1, 2']])
            ->accumulate(['type' => 'content_block_stop', 'index' => 0])
        ;

        $this->assertSame([], (array) self::blockField($accumulator->message()->jsonSerialize(), index: 0, field: 'input'));
    }

    public function testMessageDeltaAppliesContainerAndEveryUsageField(): void
    {
        $accumulator = MessageAccumulator::forMessages()
            ->accumulate(['type' => 'message_start', 'message' => self::startMessage()])
            ->accumulate(['type' => 'message_delta', 'delta' => [
                'stop_reason' => 'end_turn',
                'stop_sequence' => null,
                'stop_details' => null,
                'container' => ['id' => 'container_abc', 'expires_at' => '2026-01-01T00:00:00Z'],
            ], 'usage' => [
                'input_tokens' => 100,
                'output_tokens' => 25,
                'cache_creation_input_tokens' => 5,
                'cache_read_input_tokens' => 80,
                'server_tool_use' => ['web_search_requests' => 2, 'web_fetch_requests' => 0],
                'output_tokens_details' => ['thinking_tokens' => 7],
            ]])
            ->accumulate(['type' => 'message_stop'])
        ;

        $this->assertSame('end_turn', self::wire($accumulator, at: 'stop_reason'));
        $this->assertSame('container_abc', self::wire($accumulator, at: 'container.id'));
        $this->assertSame(100, self::wire($accumulator, at: 'usage.input_tokens'));
        $this->assertSame(25, self::wire($accumulator, at: 'usage.output_tokens'));
        $this->assertSame(5, self::wire($accumulator, at: 'usage.cache_creation_input_tokens'));
        $this->assertSame(80, self::wire($accumulator, at: 'usage.cache_read_input_tokens'));
        $this->assertSame(2, self::wire($accumulator, at: 'usage.server_tool_use.web_search_requests'));
        $this->assertSame(7, self::wire($accumulator, at: 'usage.output_tokens_details.thinking_tokens'));
    }

    public function testMessageDeltaKeepsStartUsageForOmittedFields(): void
    {
        // the API omits the optional usage keys when they do not apply, so
        // what message_start reported must survive
        $start = [...self::startMessage(), 'usage' => [
            'input_tokens' => 10,
            'output_tokens' => 1,
            'cache_creation_input_tokens' => 4,
            'cache_read_input_tokens' => 2,
            'cache_creation' => ['ephemeral_5m_input_tokens' => 4, 'ephemeral_1h_input_tokens' => 0],
            'service_tier' => 'standard',
        ]];

        $accumulator = MessageAccumulator::forMessages()
            ->accumulate(['type' => 'message_start', 'message' => $start])
            ->accumulate(['type' => 'message_delta', 'delta' => [
                'stop_reason' => 'end_turn', 'stop_sequence' => null, 'stop_details' => null,
            ], 'usage' => ['output_tokens' => 42]])
            ->accumulate(['type' => 'message_stop'])
        ;

        $this->assertSame(42, self::wire($accumulator, at: 'usage.output_tokens'));
        $this->assertSame(10, self::wire($accumulator, at: 'usage.input_tokens'));
        $this->assertSame(4, self::wire($accumulator, at: 'usage.cache_creation_input_tokens'));
        $this->assertSame(2, self::wire($accumulator, at: 'usage.cache_read_input_tokens'));
        $this->assertSame('standard', self::wire($accumulator, at: 'usage.service_tier'));
        $this->assertSame(4, self::wire($accumulator, at: 'usage.cache_creation.ephemeral_5m_input_tokens'));
    }

    public function testBetaMessageDeltaAppliesEventLevelContextManagement(): void
    {
        // context_management is a sibling of delta/usage on the event, and
        // is never reported at message_start
        $accumulator = MessageAccumulator::forBetaMessages()
            ->accumulate(['type' => 'message_start', 'message' => self::startMessage()])
            ->accumulate(['type' => 'message_delta', 'delta' => [
                'stop_reason' => 'end_turn',
                'stop_sequence' => null,
                'stop_details' => null,
                'container' => ['id' => 'container_beta', 'expires_at' => '2026-01-01T00:00:00Z'],
            ], 'context_management' => ['applied_edits' => [
                ['type' => 'clear_tool_uses_20250919', 'cleared_input_tokens' => 100, 'cleared_tool_uses' => 2],
            ]], 'usage' => ['output_tokens' => 9]])
            ->accumulate(['type' => 'message_stop'])
        ;

        $this->assertSame('container_beta', self::wire($accumulator, at: 'container.id'));
        $this->assertSame(
            'clear_tool_uses_20250919',
            self::wire($accumulator, at: 'context_management.applied_edits.0.type'),
        );
        $this->assertSame(2, self::wire($accumulator, at: 'context_management.applied_edits.0.cleared_tool_uses'));
        $this->assertSame(100, self::wire($accumulator, at: 'context_management.applied_edits.0.cleared_input_tokens'));
    }

    public function testBetaMessageDeltaReadsTypedEventModels(): void
    {
        $accumulator = MessageAccumulator::forBetaMessages()
            ->accumulate(['type' => 'message_start', 'message' => self::startMessage()])
            ->accumulate(BetaRawMessageDeltaEvent::with(
                contextManagement: BetaContextManagementResponse::with(appliedEdits: [
                    BetaClearThinking20251015EditResponse::with(clearedInputTokens: 12, clearedThinkingTurns: 1),
                ]),
                delta: Delta::with(
                    container: BetaContainer::with(
                        id: 'container_typed',
                        expiresAt: new \DateTimeImmutable('2026-01-01T00:00:00Z'),
                        skills: null,
                    ),
                    stopDetails: null,
                    stopReason: 'end_turn',
                    stopSequence: null,
                ),
                usage: BetaMessageDeltaUsage::with(
                    cacheCreationInputTokens: null,
                    cacheReadInputTokens: null,
                    fallbackCredit: null,
                    inputTokens: null,
                    iterations: null,
                    outputTokens: 3,
                    outputTokensDetails: BetaOutputTokensDetails::with(thinkingTokens: 1),
                    serverToolUse: null,
                ),
            ))
        ;

        $this->assertSame('container_typed', self::wire($accumulator, at: 'container.id'));
        $this->assertSame(
            12,
            self::wire($accumulator, at: 'context_management.applied_edits.0.cleared_input_tokens'),
        );
        $this->assertSame(1, self::wire($accumulator, at: 'usage.output_tokens_details.thinking_tokens'));
    }

    public function testMessageDeltaStopDetailsOverwriteUnconditionally(): void
    {
        // stop_details is always keyed on the delta and a null is the
        // message's final value, like its stop_reason/stop_sequence siblings
        $accumulator = MessageAccumulator::forMessages()
            ->accumulate(['type' => 'message_start', 'message' => [
                ...self::startMessage(),
                'stop_details' => ['type' => 'refusal', 'category' => 'cyber', 'explanation' => 'refused'],
            ]])
            ->accumulate(['type' => 'message_delta', 'delta' => [
                'stop_reason' => 'end_turn', 'stop_sequence' => null, 'stop_details' => null,
            ], 'usage' => ['output_tokens' => 2]])
        ;

        $this->assertNull(self::wire($accumulator, at: 'stop_details'));
    }

    public function testAcceptsTypedEventModels(): void
    {
        $accumulator = MessageAccumulator::forMessages();
        // @phpstan-ignore-next-line argument.type
        $accumulator->accumulate(RawMessageStartEvent::with(message: self::startMessage()));
        $accumulator->accumulate(RawContentBlockStartEvent::with(contentBlock: ['type' => 'text', 'text' => '', 'citations' => null], index: 0));
        $accumulator->accumulate(RawContentBlockDeltaEvent::with(delta: ['type' => 'text_delta', 'text' => 'typed'], index: 0));

        $this->assertSame('typed', self::blockField($accumulator->message()->jsonSerialize(), index: 0, field: 'text'));
    }

    public function testThrowsOnEventBeforeMessageStart(): void
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('before "message_start"');

        MessageAccumulator::forMessages()->accumulate(['type' => 'content_block_stop', 'index' => 0]);
    }

    public function testThrowsOnSecondMessageStart(): void
    {
        $accumulator = MessageAccumulator::forMessages()
            ->accumulate(['type' => 'message_start', 'message' => self::startMessage()])
        ;

        $this->expectException(\LogicException::class);

        $accumulator->accumulate(['type' => 'message_start', 'message' => self::startMessage()]);
    }

    public function testThrowsOnContentBlockStartSkippingAnIndex(): void
    {
        $accumulator = MessageAccumulator::forMessages()
            ->accumulate(['type' => 'message_start', 'message' => self::startMessage()])
        ;

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('expected index 0');

        $accumulator->accumulate(['type' => 'content_block_start', 'index' => 1, 'content_block' => ['type' => 'text', 'text' => '']]);
    }

    public function testThrowsOnDeltaForMissingBlock(): void
    {
        $accumulator = MessageAccumulator::forMessages()
            ->accumulate(['type' => 'message_start', 'message' => self::startMessage()])
        ;

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('only 0 content blocks');

        $accumulator->accumulate(['type' => 'content_block_delta', 'index' => 0, 'delta' => ['type' => 'text_delta', 'text' => 'x']]);
    }

    // ── harness ──────────────────────────────────────────────────────

    /** @return iterable<string,array{string}> */
    private static function fixtures(string $tier): iterable
    {
        foreach (glob(self::fixturesDir()."/{$tier}/*.txt") ?: [] as $path) {
            $case = basename($path, suffix: '.txt');

            yield $case => [$case];
        }
    }

    private static function fixturesDir(): string
    {
        return dirname(__DIR__, 3).'/fixtures';
    }

    private static function client(ResponseInterface $response): Client
    {
        $transporter = new MockClient;
        $transporter->setDefaultResponse($response);

        return new Client(apiKey: 'my-anthropic-api-key', requestOptions: ['transporter' => $transporter]);
    }

    /**
     * Parses a verbatim captured HTTP response — status line, header lines,
     * blank line, body — into a PSR-7 response.
     */
    private static function fixtureResponse(string $tier, string $case): ResponseInterface
    {
        $raw = file_get_contents(self::fixturesDir()."/{$tier}/{$case}.txt");
        assert(is_string($raw));
        $raw = str_replace("\r\n", "\n", $raw);

        [$head, $body] = explode("\n\n", $raw, limit: 2);
        $headLines = explode("\n", $head);
        $statusLine = array_shift($headLines);
        $m = [];
        if (1 !== preg_match('/^HTTP\/[\d.]+ (\d{3})/', $statusLine, matches: $m)) {
            throw new \RuntimeException("fixture {$tier}/{$case}.txt has no HTTP status line");
        }

        $response = Psr17FactoryDiscovery::findResponseFactory()->createResponse((int) $m[1]);
        foreach ($headLines as $line) {
            [$name, $value] = explode(':', $line, limit: 2);
            $response = $response->withAddedHeader(trim($name), trim($value));
        }

        return $response->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($body));
    }

    /** @return array<string,mixed> */
    private static function expected(string $tier, string $case): array
    {
        $decoded = json_decode(
            file_get_contents(self::fixturesDir()."/{$tier}/{$case}.json") ?: '',
            associative: true,
            flags: JSON_THROW_ON_ERROR,
        );
        assert(is_array($decoded));

        $out = [];
        foreach ($decoded as $key => $value) {
            $out[strval($key)] = $value;
        }

        return $out;
    }

    /**
     * The fixtures' assertion contract: every expected key must exist and
     * match recursively (extra actual keys are ignored), arrays match length
     * and element-wise, and an expected `null` is a wildcard — it matches
     * null, an absent key, or a zero value.
     */
    private static function assertDeepSubset(mixed $expected, mixed $actual, string $path = '$'): void
    {
        if (is_null($expected)) {
            return;
        }

        if ($expected instanceof \JsonSerializable) {
            $expected = $expected->jsonSerialize();
        }
        if ($actual instanceof \JsonSerializable) {
            $actual = $actual->jsonSerialize();
        }
        $expected = is_object($expected) ? get_object_vars($expected) : $expected;
        $actual = is_object($actual) ? get_object_vars($actual) : $actual;

        if (is_array($expected)) {
            self::assertIsArray($actual, "{$path}: expected an array/object");

            if (array_is_list($expected)) {
                self::assertCount(count($expected), $actual, "{$path}: array length mismatch");
                foreach (array_values($actual) as $i => $item) {
                    self::assertDeepSubset($expected[$i], actual: $item, path: "{$path}[{$i}]");
                }

                return;
            }

            foreach ($expected as $key => $value) {
                if (is_null($value)) {
                    continue; // wildcard: absent key, null, or zero value all match
                }
                self::assertArrayHasKey($key, $actual, "{$path}.{$key}: missing key");
                self::assertDeepSubset($value, actual: $actual[$key], path: "{$path}.{$key}");
            }

            return;
        }

        self::assertSame($expected, $actual, "{$path}: value mismatch");
    }

    /**
     * Reads a dotted path (`usage.output_tokens_details.thinking_tokens`)
     * out of the accumulated message, serialized to plain wire shape.
     */
    private static function wire(MessageAccumulator $accumulator, string $at): mixed
    {
        $value = json_decode(
            json_encode($accumulator->message(), flags: JSON_THROW_ON_ERROR),
            associative: true,
            flags: JSON_THROW_ON_ERROR,
        );

        foreach (explode('.', $at) as $segment) {
            if (!is_array($value)) {
                return null;
            }
            $key = ctype_digit($segment) ? (int) $segment : $segment;
            $value = $value[$key] ?? null;
        }

        return $value;
    }

    /** Reads `content[$index][$field]` out of a serialized message. */
    private static function blockField(mixed $message, int $index, string $field): mixed
    {
        assert(is_array($message) && is_array($message['content'] ?? null));
        $block = $message['content'][$index] ?? null;
        $block = is_object($block) ? get_object_vars($block) : $block;
        assert(is_array($block));

        return $block[$field] ?? null;
    }

    /** @return array<string,mixed> */
    private static function startMessage(): array
    {
        return [
            'id' => 'msg_test',
            'type' => 'message',
            'role' => 'assistant',
            'model' => 'claude-sonnet-4-5',
            'content' => [],
            'stop_reason' => null,
            'stop_sequence' => null,
            'usage' => ['input_tokens' => 1, 'output_tokens' => 0],
        ];
    }
}
