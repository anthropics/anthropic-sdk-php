<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

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
 * @phpstan-type BetaToolChoiceShape = BetaToolChoiceAutoShape|BetaToolChoiceAnyShape|BetaToolChoiceToolShape|BetaToolChoiceNoneShape
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
}
