<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Messages\ToolChoice\Type;

/**
 * How the model should use the provided tools. The model can use a specific tool, any available tool, decide by itself, or not use tools at all.
 *
 * @phpstan-import-type ToolChoiceAutoShape from \Anthropic\Messages\ToolChoiceAuto
 * @phpstan-import-type ToolChoiceAnyShape from \Anthropic\Messages\ToolChoiceAny
 * @phpstan-import-type ToolChoiceToolShape from \Anthropic\Messages\ToolChoiceTool
 * @phpstan-import-type ToolChoiceNoneShape from \Anthropic\Messages\ToolChoiceNone
 *
 * @phpstan-type ToolChoiceVariants = ToolChoiceAuto|ToolChoiceAny|ToolChoiceTool|ToolChoiceNone
 * @phpstan-type ToolChoiceShape = ToolChoiceVariants|ToolChoiceAutoShape|ToolChoiceAnyShape|ToolChoiceToolShape|ToolChoiceNoneShape
 */
final class ToolChoice implements ConverterSource
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
            'auto' => ToolChoiceAuto::class,
            'any' => ToolChoiceAny::class,
            'tool' => ToolChoiceTool::class,
            'none' => ToolChoiceNone::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::AUTO|'auto' ? ToolChoiceAuto : ($type is Type::ANY|'any' ? ToolChoiceAny : ($type is Type::TOOL|'tool' ? ToolChoiceTool : ($type is Type::NONE|'none' ? ToolChoiceNone : ToolChoiceAuto|ToolChoiceAny|ToolChoiceTool|ToolChoiceNone))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?bool $disableParallelToolUse = null,
        ?string $name = null,
    ): ToolChoiceAuto|ToolChoiceAny|ToolChoiceTool|ToolChoiceNone {
        return match ($type) {
            Type::AUTO, 'auto' => ToolChoiceAuto::with(
                disableParallelToolUse: $disableParallelToolUse
            ),
            Type::ANY, 'any' => ToolChoiceAny::with(
                disableParallelToolUse: $disableParallelToolUse
            ),
            Type::TOOL, 'tool' => ToolChoiceTool::with(
                name: $name ?? throw new \ArgumentCountError('$name is required'),
                disableParallelToolUse: $disableParallelToolUse,
            ),
            Type::NONE, 'none' => ToolChoiceNone::with(),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
