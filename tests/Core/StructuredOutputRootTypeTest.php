<?php

declare(strict_types=1);

namespace Tests\Core;

use Anthropic\Lib\Attributes\Constrained;
use Anthropic\Lib\Concerns\StructuredOutputModelTrait;
use Anthropic\Lib\Contracts\StructuredOutputModel;
use Anthropic\Lib\Helpers\StructuredOutput;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class RootTypeModel implements StructuredOutputModel
{
    use StructuredOutputModelTrait;

    #[Constrained(minLength: 3)]
    public ?string $name = null;

    /** @var list<mixed> */
    public array $items = [];
}

/**
 * @internal
 */
#[CoversClass(StructuredOutput::class)]
final class StructuredOutputRootTypeTest extends TestCase
{
    #[DataProvider('arrayRoots')]
    public function testArraysProduceParseErrorsInsteadOfEmptyModels(string $json): void
    {
        $content = ['output' => ['type' => 'text', 'text' => $json]];
        StructuredOutput::parseResponseContent($content, RootTypeModel::class);
        self::assertIsArray($content['output']);
        self::assertIsArray($content['output']['parsed']);
        self::assertSame('Expected JSON object, got array', $content['output']['parsed']['error']);
        self::assertSame($json, $content['output']['text']);
    }

    /** @return iterable<string, array{string}> */
    public static function arrayRoots(): iterable
    {
        yield 'empty' => ['[]'];

        yield 'scalars' => ['[1, 2]'];

        yield 'objects' => ['[{"name":"Ada"}]'];

        yield 'whitespace' => [" \r\n\t[ ] \n"];
    }

    #[DataProvider('objectRoots')]
    public function testObjectsRemainAcceptedIncludingEmptyAndNumericKeys(string $json): void
    {
        $content = ['output' => ['type' => 'text', 'text' => $json]];
        StructuredOutput::parseResponseContent($content, RootTypeModel::class);
        self::assertIsArray($content['output']);
        self::assertInstanceOf(RootTypeModel::class, $content['output']['parsed']);
        if (str_contains($json, 'Ada')) {
            self::assertSame('Ada', $content['output']['parsed']->name);
            self::assertSame([1, 2], $content['output']['parsed']->items);
        }
    }

    /** @return iterable<string, array{string}> */
    public static function objectRoots(): iterable
    {
        yield 'empty' => ['{}'];

        yield 'numeric properties' => ['{"0":"ignored"}'];

        yield 'whitespace' => [" \r\n\t{\"name\":\"Ada\",\"items\":[1,2]} \n"];
    }

    public function testMixedBlocksKeepValidModelsAndValidationWarnings(): void
    {
        $content = [
            'invalid' => ['type' => 'text', 'text' => '[]'],
            'valid' => ['type' => 'text', 'text' => '{"name":"Al","items":[]}'],
            'other' => ['type' => 'thinking', 'thinking' => 'unchanged'],
        ];
        StructuredOutput::parseResponseContent($content, RootTypeModel::class);
        self::assertIsArray($content['invalid']);
        self::assertIsArray($content['invalid']['parsed']);
        self::assertArrayHasKey('error', $content['invalid']['parsed']);
        self::assertIsArray($content['valid']);
        self::assertInstanceOf(RootTypeModel::class, $content['valid']['parsed']);
        self::assertSame('Al', $content['valid']['parsed']->name);
        self::assertArrayHasKey('validation_warnings', $content['valid']);
        self::assertSame(['type' => 'thinking', 'thinking' => 'unchanged'], $content['other']);
    }

    public function testNoModelLeavesTheOriginalContentUnchanged(): void
    {
        $content = ['output' => ['type' => 'text', 'text' => '[]']];
        $original = $content;
        StructuredOutput::parseResponseContent($content, null);
        self::assertSame($original, $content);
    }
}
