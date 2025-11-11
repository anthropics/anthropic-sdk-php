<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaWebFetchToolResultBlock;

use Anthropic\Beta\Messages\BetaWebFetchBlock;
use Anthropic\Beta\Messages\BetaWebFetchToolResultErrorBlock;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

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
