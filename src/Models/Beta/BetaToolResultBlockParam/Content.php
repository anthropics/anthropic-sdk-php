<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\BetaToolResultBlockParam;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Models\Beta\BetaImageBlockParam;
use Anthropic\Models\Beta\BetaSearchResultBlockParam;
use Anthropic\Models\Beta\BetaTextBlockParam;
use Anthropic\Models\Beta\BetaToolResultBlockParam\Content\UnionMember1;

/**
 * @phpstan-type content_alias = string|list<BetaTextBlockParam|BetaImageBlockParam|BetaSearchResultBlockParam>
 */
final class Content implements ConverterSource
{
    use Union;

    /**
     * @return array<string,
     * Converter|ConverterSource|string,>|list<Converter|ConverterSource|string>
     */
    public static function variants(): array
    {
        return ['string', new ListOf(UnionMember1::class)];
    }
}
