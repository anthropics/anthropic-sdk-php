<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;

/**
 * @phpstan-import-type WebSearchToolResultErrorShape from \Anthropic\Messages\WebSearchToolResultError
 * @phpstan-import-type WebSearchResultBlockShape from \Anthropic\Messages\WebSearchResultBlock
 *
 * @phpstan-type WebSearchToolResultBlockContentShape = WebSearchToolResultErrorShape|list<WebSearchResultBlockShape>
 */
final class WebSearchToolResultBlockContent implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            WebSearchToolResultError::class, new ListOf(WebSearchResultBlock::class),
        ];
    }
}
