<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Contracts\Converter;
use Anthropic\Core\Contracts\StaticConverter;

final class BetaTextCitationParam implements StaticConverter
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
            'char_location' => BetaCitationCharLocationParam::class,
            'page_location' => BetaCitationPageLocationParam::class,
            'content_block_location' => BetaCitationContentBlockLocationParam::class,
            'web_search_result_location' => BetaCitationWebSearchResultLocationParam::class,
            'search_result_location' => BetaCitationSearchResultLocationParam::class,
        ];
    }
}
