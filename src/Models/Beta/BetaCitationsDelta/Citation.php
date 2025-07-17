<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\BetaCitationsDelta;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Contracts\Converter;
use Anthropic\Core\Contracts\StaticConverter;
use Anthropic\Models\Beta\BetaCitationCharLocation;
use Anthropic\Models\Beta\BetaCitationContentBlockLocation;
use Anthropic\Models\Beta\BetaCitationPageLocation;
use Anthropic\Models\Beta\BetaCitationSearchResultLocation;
use Anthropic\Models\Beta\BetaCitationsWebSearchResultLocation;

final class Citation implements StaticConverter
{
    use Union;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|StaticConverter>|array<
     *   string, string|Converter|StaticConverter
     * >
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
