<?php

declare(strict_types=1);

namespace Anthropic\Messages\WebFetchToolResultBlock;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Messages\WebFetchBlock;
use Anthropic\Messages\WebFetchToolResultErrorBlock;

/**
 * @phpstan-import-type WebFetchToolResultErrorBlockShape from \Anthropic\Messages\WebFetchToolResultErrorBlock
 * @phpstan-import-type WebFetchBlockShape from \Anthropic\Messages\WebFetchBlock
 *
 * @phpstan-type ContentVariants = WebFetchToolResultErrorBlock|WebFetchBlock
 * @phpstan-type ContentShape = ContentVariants|WebFetchToolResultErrorBlockShape|WebFetchBlockShape
 */
final class Content implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [WebFetchToolResultErrorBlock::class, WebFetchBlock::class];
    }
}
