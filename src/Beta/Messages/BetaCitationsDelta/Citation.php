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
