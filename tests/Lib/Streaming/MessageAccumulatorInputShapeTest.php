<?php

namespace Tests\Lib\Streaming;

use Anthropic\Beta\Messages\BetaToolUseBlock;
use Anthropic\Client;
use Anthropic\Lib\Streaming\MessageAccumulator;
use Anthropic\Messages\ToolUseBlock;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/** @internal */
#[CoversNothing]
final class MessageAccumulatorInputShapeTest extends TestCase
{
    #[DataProvider('inputShapes')]
    public function testParsedToolInputRetainsJsonContainers(bool $beta, string $json): void
    {
        $accumulator = $beta ? MessageAccumulator::forBetaMessages() : MessageAccumulator::forMessages();
        $events = self::events($json);
        foreach (array_slice($events, 0, 4) as $event) {
            $accumulator->accumulate($event);
        }
        $beforeStop = self::serializedInput($accumulator);
        $this->assertSame($json, $beforeStop);
        $this->assertSame($json, self::serializedInput($accumulator));
        foreach (array_slice($events, 4) as $event) {
            $accumulator->accumulate($event);
        }
        $this->assertSame($json, self::serializedInput($accumulator));
        $this->assertTrue($accumulator->isComplete());
    }

    #[DataProvider('inputShapes')]
    public function testTypedStreamingRoundTripRetainsJsonContainers(bool $beta, string $json): void
    {
        $sse = '';
        foreach (self::events($json) as $event) {
            $type = $event['type'];
            assert(is_string($type));
            $sse .= 'event: '.$type."\ndata: ".json_encode($event, JSON_THROW_ON_ERROR)."\n\n";
        }
        $response = Psr17FactoryDiscovery::findResponseFactory()->createResponse()
            ->withHeader('Content-Type', 'text/event-stream')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($sse))
        ;
        $http = new MockClient;
        $http->setDefaultResponse($response);
        $client = new Client(apiKey: 'test-key', baseUrl: 'http://localhost', requestOptions: ['transporter' => $http]);
        $messages = $beta ? $client->beta->messages : $client->messages;
        $accumulator = $beta ? MessageAccumulator::forBetaMessages() : MessageAccumulator::forMessages();
        foreach ($messages->createStream(1024, [['role' => 'user', 'content' => 'test']], 'test-model') as $event) {
            $accumulator->accumulate($event);
        }
        $this->assertSame($json, self::serializedInput($accumulator));
        $this->assertTrue($accumulator->isComplete());
    }

    /** @return iterable<string,array{bool,string}> */
    public static function inputShapes(): iterable
    {
        foreach ([false, true] as $beta) {
            foreach ([
                'empty object' => '{}',
                'empty containers' => '{"object":{},"array":[]}',
                'nested containers' => '{"values":[{},{"objects":[{}],"array":[]},[]]}',
                'scalar controls' => '{"text":"{}","flag":false,"zero":0,"nothing":null}',
            ] as $name => $json) {
                yield ($beta ? 'beta ' : 'stable ').$name => [$beta, $json];
            }
        }
    }

    public function testIncompleteInputRetainsItsObjectPlaceholder(): void
    {
        $accumulator = MessageAccumulator::forMessages();
        foreach (self::events('{"unfinished":') as $event) {
            $accumulator->accumulate($event);
        }
        $wire = json_decode(json_encode($accumulator->message(), JSON_THROW_ON_ERROR), false, flags: JSON_THROW_ON_ERROR);
        assert($wire instanceof \stdClass && is_array($wire->content));
        $block = $wire->content[0];
        assert($block instanceof \stdClass);
        $this->assertSame('{}', json_encode($block->input, JSON_THROW_ON_ERROR));
    }

    /** @return list<array<string,mixed>> */
    private static function events(string $json): array
    {
        $split = max(1, intdiv(strlen($json), 2));

        return [
            ['type' => 'message_start', 'message' => [
                'id' => 'msg_input_shape', 'type' => 'message', 'role' => 'assistant', 'model' => 'test-model',
                'content' => [], 'stop_reason' => null, 'stop_sequence' => null,
                'usage' => ['input_tokens' => 1, 'output_tokens' => 1],
            ]],
            ['type' => 'content_block_start', 'index' => 0, 'content_block' => [
                'type' => 'tool_use', 'id' => 'toolu_input_shape', 'name' => 'capture', 'input' => (object) [],
            ]],
            ['type' => 'content_block_delta', 'index' => 0, 'delta' => ['type' => 'input_json_delta', 'partial_json' => substr($json, 0, $split)]],
            ['type' => 'content_block_delta', 'index' => 0, 'delta' => ['type' => 'input_json_delta', 'partial_json' => substr($json, $split)]],
            ['type' => 'content_block_stop', 'index' => 0],
            ['type' => 'message_stop'],
        ];
    }

    private static function serializedInput(MessageAccumulator $accumulator): string
    {
        $message = $accumulator->message();
        $content = $message->content;
        self::assertCount(1, $content);
        $tool = $content[0];
        self::assertTrue($tool instanceof ToolUseBlock || $tool instanceof BetaToolUseBlock);
        $input = $tool->input;
        $wire = json_decode(json_encode($message, JSON_THROW_ON_ERROR), false, flags: JSON_THROW_ON_ERROR);
        assert($wire instanceof \stdClass && is_array($wire->content));
        $block = $wire->content[0];
        assert($block instanceof \stdClass);

        $encoded = json_encode($block->input, JSON_THROW_ON_ERROR);
        self::assertSame($encoded, json_encode((object) $input, JSON_THROW_ON_ERROR));

        return $encoded;
    }
}
