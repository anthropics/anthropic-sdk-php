<?php

declare(strict_types=1);

namespace Tests\Core;

use Anthropic\Client;
use Anthropic\Lib\Attributes\Constrained;
use Anthropic\Lib\Concerns\StructuredOutputModelTrait;
use Anthropic\Lib\Contracts\StructuredOutputModel;
use Anthropic\Lib\Helpers\StructuredOutput;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class EmptySchemaContract implements StructuredOutputModel
{
    use StructuredOutputModelTrait;

    public static function description(): ?string
    {
        return 'An empty contract';
    }
}

class NestedEmptySchemaContract implements StructuredOutputModel
{
    use StructuredOutputModelTrait;

    public EmptySchemaContract $single;
    public ?EmptySchemaContract $optional = null;

    /** @var list<EmptySchemaContract> */
    #[Constrained(itemClass: EmptySchemaContract::class)]
    public array $items;
}

/**
 * @internal
 */
#[CoversClass(StructuredOutput::class)]
final class EmptyStructuredSchemaTest extends TestCase
{
    /** @param class-string<StructuredOutputModel> $class */
    #[Test]
    #[DataProvider('contracts')]
    public function testEmptyPropertiesSerializeAsObjects(string $class): void
    {
        $schema = StructuredOutput::toJsonSchema($class);
        $decoded = json_decode(json_encode($schema, JSON_THROW_ON_ERROR), false, 512, JSON_THROW_ON_ERROR);
        $this->assertInstanceOf(\stdClass::class, $decoded);
        $this->assertContract($decoded, $class);
        $this->assertSame(json_encode($schema), json_encode(StructuredOutput::toJsonSchema($class)));
    }

    /** @return iterable<string, array{class-string<StructuredOutputModel>}> */
    public static function contracts(): iterable
    {
        yield 'empty root' => [EmptySchemaContract::class];

        yield 'nested and array item' => [NestedEmptySchemaContract::class];
    }

    /** @param class-string<StructuredOutputModel> $class */
    #[Test]
    #[DataProvider('requests')]
    public function testWireRequestsPreserveEmptyPropertyMaps(string $class, bool $beta): void
    {
        $transport = new MockClient;
        $factory = Psr17FactoryDiscovery::findResponseFactory();
        $streams = Psr17FactoryDiscovery::findStreamFactory();
        $transport->addResponse($factory->createResponse(200)->withHeader('Content-Type', 'application/json')->withBody($streams->createStream(
            '{"id":"msg_test","type":"message","role":"assistant","model":"claude-sonnet-4-5","content":[],"stop_reason":"end_turn","usage":{"input_tokens":1,"output_tokens":0}}',
        )));
        $client = new Client(apiKey: 'test-key', requestOptions: ['transporter' => $transport]);
        $params = ['format' => ['type' => 'json_schema', 'schema' => StructuredOutput::toJsonSchema($class)]];
        $before = json_encode($params, JSON_THROW_ON_ERROR);

        if ($beta) {
            $message = $client->beta->messages->create(maxTokens: 100, model: 'claude-sonnet-4-5', messages: [['role' => 'user', 'content' => 'Return a matching object']], outputConfig: $params);
        } else {
            $message = $client->messages->create(maxTokens: 100, model: 'claude-sonnet-4-5', messages: [['role' => 'user', 'content' => 'Return a matching object']], outputConfig: $params);
        }
        $this->assertSame('msg_test', $message->id);
        $requests = $transport->getRequests();
        $this->assertCount(1, $requests);
        $body = json_decode((string) $requests[0]->getBody(), false, 512, JSON_THROW_ON_ERROR);
        $this->assertInstanceOf(\stdClass::class, $body);
        $config = $this->objectField($body, 'output_config');
        $format = $this->objectField($config, 'format');
        $this->assertContract($this->objectField($format, 'schema'), $class);
        $this->assertSame('json_schema', $format->type);
        $this->assertSame($before, json_encode($params, JSON_THROW_ON_ERROR));
    }

    /** @return iterable<string, array{class-string<StructuredOutputModel>, bool}> */
    public static function requests(): iterable
    {
        foreach ([EmptySchemaContract::class, NestedEmptySchemaContract::class] as $class) {
            foreach ([false, true] as $beta) {
                yield $class.($beta ? ' beta' : ' standard') => [$class, $beta];
            }
        }
    }

    private function assertEmptyContract(\stdClass $schema): void
    {
        $this->assertSame('object', $schema->type);
        $this->assertInstanceOf(\stdClass::class, $schema->properties);
        $this->assertSame([], get_object_vars($schema->properties));
        $this->assertFalse($schema->additionalProperties);
        $this->assertSame('An empty contract', $schema->description);
    }

    private function assertContract(\stdClass $schema, string $class): void
    {
        if (EmptySchemaContract::class === $class) {
            $this->assertEmptyContract($schema);
        } else {
            $this->assertInstanceOf(\stdClass::class, $schema->properties);
            $items = $this->objectField($schema->properties, 'items');
            foreach ([$schema->properties->single, $schema->properties->optional, $items->items] as $child) {
                $this->assertInstanceOf(\stdClass::class, $child);
                $this->assertEmptyContract($child);
            }
            $this->assertSame(['single', 'items'], $schema->required);
            $this->assertSame('array', $items->type);
        }
    }

    private function objectField(\stdClass $parent, string $name): \stdClass
    {
        $child = $parent->{$name};
        $this->assertInstanceOf(\stdClass::class, $child);

        return $child;
    }
}
