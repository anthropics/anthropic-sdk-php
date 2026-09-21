<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsUserDefineOutcomeEventParams;

use Anthropic\Beta\Sessions\Events\ManagedAgentsFileRubricParams;
use Anthropic\Beta\Sessions\Events\ManagedAgentsTextRubricParams;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUserDefineOutcomeEventParams\Rubric\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Rubric for grading the quality of an outcome.
 *
 * @phpstan-import-type ManagedAgentsFileRubricParamsShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsFileRubricParams
 * @phpstan-import-type ManagedAgentsTextRubricParamsShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsTextRubricParams
 *
 * @phpstan-type RubricVariants = ManagedAgentsFileRubricParams|ManagedAgentsTextRubricParams
 * @phpstan-type RubricShape = RubricVariants|ManagedAgentsFileRubricParamsShape|ManagedAgentsTextRubricParamsShape
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
            'file' => ManagedAgentsFileRubricParams::class,
            'text' => ManagedAgentsTextRubricParams::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::FILE|'file' ? ManagedAgentsFileRubricParams : ($type is Type::TEXT|'text' ? ManagedAgentsTextRubricParams : ManagedAgentsFileRubricParams|ManagedAgentsTextRubricParams))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $fileID = null,
        ?string $content = null,
    ): ManagedAgentsFileRubricParams|ManagedAgentsTextRubricParams {
        return match ($type) {
            Type::FILE, 'file' => ManagedAgentsFileRubricParams::with(
                type: 'file',
                fileID: $fileID ?? throw new \ArgumentCountError('$fileID is required'),
            ),
            Type::TEXT, 'text' => ManagedAgentsTextRubricParams::with(
                type: 'text',
                content: $content ?? throw new \ArgumentCountError('$content is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
