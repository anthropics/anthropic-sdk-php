<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\BetaToolResultBlockParam\Content;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Models\Beta\BetaImageBlockParam;
use Anthropic\Models\Beta\BetaSearchResultBlockParam;
use Anthropic\Models\Beta\BetaTextBlockParam;

/**
 * @phpstan-type union_member1_alias = BetaTextBlockParam|BetaImageBlockParam|BetaSearchResultBlockParam
 */
final class UnionMember1 implements ConverterSource
{
    use Union;

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
            'text' => BetaTextBlockParam::class,
            'image' => BetaImageBlockParam::class,
            'search_result' => BetaSearchResultBlockParam::class,
        ];
    }
}
