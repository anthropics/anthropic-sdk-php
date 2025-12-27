<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaRequestMCPToolResultBlockParam;

use Anthropic\Beta\Messages\BetaTextBlockParam;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;

/**
 * @phpstan-import-type BetaTextBlockParamShape from \Anthropic\Beta\Messages\BetaTextBlockParam
 *
 * @phpstan-type ContentShape = string|list<BetaTextBlockParamShape>
 */
final class Content implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return ['string', new ListOf(BetaTextBlockParam::class)];
    }
}
