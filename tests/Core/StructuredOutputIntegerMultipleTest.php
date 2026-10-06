<?php

declare(strict_types=1);

namespace Tests\Core;

use Anthropic\Lib\Attributes\Constrained;
use Anthropic\Lib\Concerns\StructuredOutputModelTrait;
use Anthropic\Lib\Contracts\StructuredOutputModel;
use Anthropic\Lib\Helpers\StructuredOutput;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class EvenIntegerOutput implements StructuredOutputModel
{
    use StructuredOutputModelTrait;

    #[Constrained(multipleOf: 2)]
    public int $value;
}

class TripleIntegerOutput implements StructuredOutputModel
{
    use StructuredOutputModelTrait;

    #[Constrained(multipleOf: 3)]
    public int $value;
}

class TenIntegerOutput implements StructuredOutputModel
{
    use StructuredOutputModelTrait;

    #[Constrained(multipleOf: 10)]
    public int $value;
}

class BinaryFractionOutput implements StructuredOutputModel
{
    use StructuredOutputModelTrait;

    #[Constrained(multipleOf: 0.5)]
    public float $value;
}

class ZeroMultipleOutput implements StructuredOutputModel
{
    use StructuredOutputModelTrait;

    #[Constrained(multipleOf: 0)]
    public int $value;
}

/**
 * @internal
 */
#[CoversClass(StructuredOutput::class)]
final class StructuredOutputIntegerMultipleTest extends TestCase
{
    /** @param class-string<StructuredOutputModel> $model */
    #[Test]
    #[DataProvider('integerCases')]
    public function testIntegerDivisibilityUsesExactValues(int $value, string $model, bool $valid): void
    {
        $input = ['value' => $value];
        $actual = StructuredOutput::validateAgainstConstraints($input, $model);
        if ($valid) {
            $this->assertSame([], $actual);
        } else {
            $this->assertArrayHasKey('value', $actual);
            $this->assertStringContainsString((string) $value, $actual['value']);
        }
        $this->assertSame(['value' => $value], $input);
    }

    /** @return iterable<string, array{int, class-string<StructuredOutputModel>, bool}> */
    public static function integerCases(): iterable
    {
        foreach ([2 => EvenIntegerOutput::class, 3 => TripleIntegerOutput::class, 10 => TenIntegerOutput::class] as $divisor => $model) {
            foreach ([0, 1, 6, -6, PHP_INT_MAX, PHP_INT_MAX - 1, PHP_INT_MAX - 2, PHP_INT_MIN, PHP_INT_MIN + 1, PHP_INT_MIN + 2] as $value) {
                yield $divisor.'-'.$value => [$value, $model, 0 === $value % $divisor];
            }
            if (PHP_INT_SIZE >= 8) {
                foreach (range(-8, 8) as $offset) {
                    $value = 9007199254740992 + $offset;

                    yield $divisor.'-boundary-'.$offset => [$value, $model, 0 === $value % $divisor];
                }
            }
        }
    }

    #[Test]
    public function testParsedResponsesPreserveLargeIntegersAndTheirWarnings(): void
    {
        $content = [
            'invalid' => ['type' => 'text', 'text' => json_encode(['value' => PHP_INT_MAX], JSON_THROW_ON_ERROR)],
            'valid' => ['type' => 'text', 'text' => json_encode(['value' => PHP_INT_MAX - 1], JSON_THROW_ON_ERROR)],
        ];
        StructuredOutput::parseResponseContent($content, EvenIntegerOutput::class);
        $invalid = $content['invalid'];
        $valid = $content['valid'];
        $this->assertIsArray($invalid);
        $this->assertIsArray($valid);
        $this->assertArrayHasKey('parsed', $invalid);
        $this->assertArrayHasKey('parsed', $valid);
        $this->assertInstanceOf(EvenIntegerOutput::class, $invalid['parsed']);
        $this->assertInstanceOf(EvenIntegerOutput::class, $valid['parsed']);
        $this->assertSame(PHP_INT_MAX, $invalid['parsed']->value);
        $this->assertSame(PHP_INT_MAX - 1, $valid['parsed']->value);
        $this->assertArrayHasKey('validation_warnings', $invalid);
        $this->assertArrayNotHasKey('validation_warnings', $valid);
    }

    #[Test]
    public function testFloatingPointDivisorsAndMissingFieldsAreUnchanged(): void
    {
        foreach ([0.0, 0.5, 1.5, -1.5] as $value) {
            $this->assertSame([], StructuredOutput::validateAgainstConstraints(['value' => $value], BinaryFractionOutput::class));
        }
        $this->assertArrayHasKey('value', StructuredOutput::validateAgainstConstraints(['value' => 1.25], BinaryFractionOutput::class));
        $this->assertSame([], StructuredOutput::validateAgainstConstraints([], EvenIntegerOutput::class));
        $this->assertArrayHasKey('value', StructuredOutput::validateAgainstConstraints(['value' => 1], ZeroMultipleOutput::class));
        $this->assertSame(['value' => ['multipleOf' => 2]], StructuredOutput::getConstraintsForModel(EvenIntegerOutput::class));
    }
}
