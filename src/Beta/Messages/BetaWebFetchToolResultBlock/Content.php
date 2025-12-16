<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaWebFetchToolResultBlock;

use Anthropic\Beta\Messages\BetaWebFetchBlock;
use Anthropic\Beta\Messages\BetaWebFetchToolResultErrorBlock;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaWebFetchToolResultErrorBlockShape from \Anthropic\Beta\Messages\BetaWebFetchToolResultErrorBlock
 * @phpstan-import-type BetaWebFetchBlockShape from \Anthropic\Beta\Messages\BetaWebFetchBlock
 *
 * @phpstan-type ContentShape = BetaWebFetchToolResultErrorBlockShape|BetaWebFetchBlockShape
 */
final class Content implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [BetaWebFetchToolResultErrorBlock::class, BetaWebFetchBlock::class];
    }
}
