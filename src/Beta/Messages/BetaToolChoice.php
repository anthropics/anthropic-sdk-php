<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * How the model should use the provided tools. The model can use a specific tool, any available tool, decide by itself, or not use tools at all.
 *
 * @phpstan-type beta_tool_choice_alias = BetaToolChoiceAuto|BetaToolChoiceAny|BetaToolChoiceTool|BetaToolChoiceNone
 */
final class BetaToolChoice implements ConverterSource
{
    use Union;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return array<string,
     * Converter|ConverterSource|string,>|list<Converter|ConverterSource|string>
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
}
