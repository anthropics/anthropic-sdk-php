<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaTextBlockParamShape from \Anthropic\Beta\Messages\BetaTextBlockParam
 * @phpstan-import-type BetaImageBlockParamShape from \Anthropic\Beta\Messages\BetaImageBlockParam
 *
 * @phpstan-type BetaContentBlockSourceContentShape = BetaTextBlockParamShape|BetaImageBlockParamShape
 */
final class BetaContentBlockSourceContent implements ConverterSource
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
            'text' => BetaTextBlockParam::class, 'image' => BetaImageBlockParam::class,
        ];
    }
}
