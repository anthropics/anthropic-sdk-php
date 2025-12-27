<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaMCPToolResultBlock;

use Anthropic\Beta\Messages\BetaTextBlock;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;

/**
 * @phpstan-import-type BetaTextBlockShape from \Anthropic\Beta\Messages\BetaTextBlock
 *
 * @phpstan-type ContentShape = string|list<BetaTextBlockShape>
 */
final class Content implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return ['string', new ListOf(BetaTextBlock::class)];
    }
}
