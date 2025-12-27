<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * How the model should use the provided tools. The model can use a specific tool, any available tool, decide by itself, or not use tools at all.
 *
 * @phpstan-import-type ToolChoiceAutoShape from \Anthropic\Messages\ToolChoiceAuto
 * @phpstan-import-type ToolChoiceAnyShape from \Anthropic\Messages\ToolChoiceAny
 * @phpstan-import-type ToolChoiceToolShape from \Anthropic\Messages\ToolChoiceTool
 * @phpstan-import-type ToolChoiceNoneShape from \Anthropic\Messages\ToolChoiceNone
 *
 * @phpstan-type ToolChoiceShape = ToolChoiceAutoShape|ToolChoiceAnyShape|ToolChoiceToolShape|ToolChoiceNoneShape
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
}
