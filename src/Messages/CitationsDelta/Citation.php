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
 * @phpstan-import-type CitationCharLocationShape from \Anthropic\Messages\CitationCharLocation
 * @phpstan-import-type CitationPageLocationShape from \Anthropic\Messages\CitationPageLocation
 * @phpstan-import-type CitationContentBlockLocationShape from \Anthropic\Messages\CitationContentBlockLocation
 * @phpstan-import-type CitationsWebSearchResultLocationShape from \Anthropic\Messages\CitationsWebSearchResultLocation
 * @phpstan-import-type CitationsSearchResultLocationShape from \Anthropic\Messages\CitationsSearchResultLocation
 *
 * @phpstan-type CitationShape = CitationCharLocationShape|CitationPageLocationShape|CitationContentBlockLocationShape|CitationsWebSearchResultLocationShape|CitationsSearchResultLocationShape
 */
final class Citation implements ConverterSource
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
            'char_location' => CitationCharLocation::class,
            'page_location' => CitationPageLocation::class,
            'content_block_location' => CitationContentBlockLocation::class,
            'web_search_result_location' => CitationsWebSearchResultLocation::class,
            'search_result_location' => CitationsSearchResultLocation::class,
        ];
    }
}
