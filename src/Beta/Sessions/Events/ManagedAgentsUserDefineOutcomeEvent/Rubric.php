<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsUserDefineOutcomeEvent;

use Anthropic\Beta\Sessions\Events\ManagedAgentsFileRubric;
use Anthropic\Beta\Sessions\Events\ManagedAgentsTextRubric;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUserDefineOutcomeEvent\Rubric\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Rubric for grading the quality of an outcome.
 *
 * @phpstan-import-type ManagedAgentsFileRubricShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsFileRubric
 * @phpstan-import-type ManagedAgentsTextRubricShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsTextRubric
 *
 * @phpstan-type RubricVariants = ManagedAgentsFileRubric|ManagedAgentsTextRubric
 * @phpstan-type RubricShape = RubricVariants|ManagedAgentsFileRubricShape|ManagedAgentsTextRubricShape
 */
final class Rubric implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            'file' => ManagedAgentsFileRubric::class,
            'text' => ManagedAgentsTextRubric::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::FILE|'file' ? ManagedAgentsFileRubric : ($type is Type::TEXT|'text' ? ManagedAgentsTextRubric : ManagedAgentsFileRubric|ManagedAgentsTextRubric))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $fileID = null,
        ?string $content = null,
    ): ManagedAgentsFileRubric|ManagedAgentsTextRubric {
        return match ($type) {
            Type::FILE, 'file' => ManagedAgentsFileRubric::with(
                type: 'file',
                fileID: $fileID ?? throw new \ArgumentCountError('$fileID is required'),
            ),
            Type::TEXT, 'text' => ManagedAgentsTextRubric::with(
                type: 'text',
                content: $content ?? throw new \ArgumentCountError('$content is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
