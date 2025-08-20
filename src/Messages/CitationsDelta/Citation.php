<?php

declare(strict_types=1);

namespace Anthropic\Messages\CitationsDelta;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Messages\CitationCharLocation;
use Anthropic\Messages\CitationContentBlockLocation;
use Anthropic\Messages\CitationPageLocation;
use Anthropic\Messages\CitationsSearchResultLocation;
use Anthropic\Messages\CitationsWebSearchResultLocation;

/**
 * @phpstan-type citation_alias = CitationCharLocation|CitationPageLocation|CitationContentBlockLocation|CitationsWebSearchResultLocation|CitationsSearchResultLocation
 */
final class Citation implements ConverterSource
{
    use SdkUnion;

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
            'char_location' => CitationCharLocation::class,
            'page_location' => CitationPageLocation::class,
            'content_block_location' => CitationContentBlockLocation::class,
            'web_search_result_location' => CitationsWebSearchResultLocation::class,
            'search_result_location' => CitationsSearchResultLocation::class,
        ];
    }
}
