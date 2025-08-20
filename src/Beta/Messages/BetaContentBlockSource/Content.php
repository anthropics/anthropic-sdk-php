<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaContentBlockSource;

use Anthropic\Beta\Messages\BetaContentBlockSourceContent;
use Anthropic\Beta\Messages\BetaImageBlockParam;
use Anthropic\Beta\Messages\BetaTextBlockParam;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;

/**
 * @phpstan-type content_alias = string|list<BetaTextBlockParam|BetaImageBlockParam>
 */
final class Content implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,
     * string|Converter|ConverterSource,>
     */
    public static function variants(): array
    {
        return ['string', new ListOf(BetaContentBlockSourceContent::class)];
    }
}
