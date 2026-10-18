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

class UnicodeLengthModel implements StructuredOutputModel
{
    use StructuredOutputModelTrait;

    #[Constrained(minLength: 2)]
    public string $minimum;

    #[Constrained(maxLength: 1)]
    public string $maximum;
}

/** @internal */
#[CoversClass(StructuredOutput::class)]
final class StructuredOutputUnicodeLengthTest extends TestCase
{
    #[DataProvider('textCases')]
    public function testConstraintsCountUnicodeCharacters(string $text, int $length): void
    {
        $data = ['minimum' => $text, 'maximum' => $text];
        $before = $data;
        $violations = StructuredOutput::validateAgainstConstraints($data, UnicodeLengthModel::class);
        $expected = [];
        if ($length < 2) {
            $expected['minimum'] = "String length {$length} is less than minimum 2";
        }
        if ($length > 1) {
            $expected['maximum'] = "String length {$length} exceeds maximum 1";
        }
        $this->assertSame($expected, $violations);
        $this->assertSame($before, $data);
    }

    #[DataProvider('textCases')]
    public function testParsedResponsesUseTheSameCharacterLengths(string $text, int $length): void
    {
        foreach ([0, JSON_UNESCAPED_UNICODE] as $flags) {
            $json = json_encode(['minimum' => $text, 'maximum' => $text], $flags | JSON_THROW_ON_ERROR);
            $content = ['entry' => ['type' => 'text', 'text' => $json]];
            StructuredOutput::parseResponseContent($content, UnicodeLengthModel::class);

            /** @var array<string, mixed> $block */
            $block = $content['entry'];
            $this->assertInstanceOf(UnicodeLengthModel::class, $block['parsed']);
            $this->assertSame($json, $block['text']);
            $expected = [];
            if ($length < 2) {
                $expected['minimum'] = "String length {$length} is less than minimum 2";
            }
            if ($length > 1) {
                $expected['maximum'] = "String length {$length} exceeds maximum 1";
            }
            $this->assertSame($expected, $block['validation_warnings'] ?? []);
        }
    }

    /** @return iterable<string, array{string, int}> */
    public static function textCases(): iterable
    {
        yield 'empty' => ['', 0];

        yield 'ASCII' => ['x', 1];

        yield 'Latin' => ['é', 1];

        yield 'CJK' => ['界', 1];

        yield 'astral' => ['🚀', 1];

        yield 'two characters' => ['é界', 2];

        yield 'combining mark' => ["e\u{0301}", 2];

        yield 'emoji modifier' => ["\u{1F44D}\u{1F3FD}", 2];

        yield 'newline' => ["\n", 1];

        yield 'NUL' => ["\0", 1];

        yield 'mixed controls' => ["é\n\0", 3];
    }

    public function testInvalidUtf8KeepsExistingByteLengthFallback(): void
    {
        $this->assertSame(
            ['maximum' => 'String length 2 exceeds maximum 1'],
            StructuredOutput::validateAgainstConstraints(
                ['minimum' => "\xFF\xFE", 'maximum' => "\xFF\xFE"],
                UnicodeLengthModel::class,
            ),
        );
    }
}
