<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaToolChoice\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * How the model should use the provided tools. The model can use a specific tool, any available tool, decide by itself, or not use tools at all.
 *
 * @phpstan-import-type BetaToolChoiceAutoShape from \Anthropic\Beta\Messages\BetaToolChoiceAuto
 * @phpstan-import-type BetaToolChoiceAnyShape from \Anthropic\Beta\Messages\BetaToolChoiceAny
 * @phpstan-import-type BetaToolChoiceToolShape from \Anthropic\Beta\Messages\BetaToolChoiceTool
 * @phpstan-import-type BetaToolChoiceNoneShape from \Anthropic\Beta\Messages\BetaToolChoiceNone
 *
 * @phpstan-type BetaToolChoiceVariants = BetaToolChoiceAuto|BetaToolChoiceAny|BetaToolChoiceTool|BetaToolChoiceNone
 * @phpstan-type BetaToolChoiceShape = BetaToolChoiceVariants|BetaToolChoiceAutoShape|BetaToolChoiceAnyShape|BetaToolChoiceToolShape|BetaToolChoiceNoneShape
 */
final class BetaToolChoice implements ConverterSource
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
            'auto' => BetaToolChoiceAuto::class,
            'any' => BetaToolChoiceAny::class,
            'tool' => BetaToolChoiceTool::class,
            'none' => BetaToolChoiceNone::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::AUTO|'auto' ? BetaToolChoiceAuto : ($type is Type::ANY|'any' ? BetaToolChoiceAny : ($type is Type::TOOL|'tool' ? BetaToolChoiceTool : ($type is Type::NONE|'none' ? BetaToolChoiceNone : BetaToolChoiceAuto|BetaToolChoiceAny|BetaToolChoiceTool|BetaToolChoiceNone))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?bool $disableParallelToolUse = null,
        ?string $name = null,
    ): BetaToolChoiceAuto|BetaToolChoiceAny|BetaToolChoiceTool|BetaToolChoiceNone {
        return match ($type) {
            Type::AUTO, 'auto' => BetaToolChoiceAuto::with(
                disableParallelToolUse: $disableParallelToolUse
            ),
            Type::ANY, 'any' => BetaToolChoiceAny::with(
                disableParallelToolUse: $disableParallelToolUse
            ),
            Type::TOOL, 'tool' => BetaToolChoiceTool::with(
                name: $name ?? throw new \ArgumentCountError('$name is required'),
                disableParallelToolUse: $disableParallelToolUse,
            ),
            Type::NONE, 'none' => BetaToolChoiceNone::with(),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
