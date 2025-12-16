<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaCitationsDelta;

use Anthropic\Beta\Messages\BetaCitationCharLocation;
use Anthropic\Beta\Messages\BetaCitationContentBlockLocation;
use Anthropic\Beta\Messages\BetaCitationPageLocation;
use Anthropic\Beta\Messages\BetaCitationSearchResultLocation;
use Anthropic\Beta\Messages\BetaCitationsWebSearchResultLocation;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaCitationCharLocationShape from \Anthropic\Beta\Messages\BetaCitationCharLocation
 * @phpstan-import-type BetaCitationPageLocationShape from \Anthropic\Beta\Messages\BetaCitationPageLocation
 * @phpstan-import-type BetaCitationContentBlockLocationShape from \Anthropic\Beta\Messages\BetaCitationContentBlockLocation
 * @phpstan-import-type BetaCitationsWebSearchResultLocationShape from \Anthropic\Beta\Messages\BetaCitationsWebSearchResultLocation
 * @phpstan-import-type BetaCitationSearchResultLocationShape from \Anthropic\Beta\Messages\BetaCitationSearchResultLocation
 *
 * @phpstan-type CitationShape = BetaCitationCharLocationShape|BetaCitationPageLocationShape|BetaCitationContentBlockLocationShape|BetaCitationsWebSearchResultLocationShape|BetaCitationSearchResultLocationShape
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
            'char_location' => BetaCitationCharLocation::class,
            'page_location' => BetaCitationPageLocation::class,
            'content_block_location' => BetaCitationContentBlockLocation::class,
            'web_search_result_location' => BetaCitationsWebSearchResultLocation::class,
            'search_result_location' => BetaCitationSearchResultLocation::class,
        ];
    }
}
