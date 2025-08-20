<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-type beta_text_citation_param_alias = BetaCitationCharLocationParam|BetaCitationPageLocationParam|BetaCitationContentBlockLocationParam|BetaCitationWebSearchResultLocationParam|BetaCitationSearchResultLocationParam
 */
final class BetaTextCitationParam implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<string,
     * string|Converter|ConverterSource,>
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
