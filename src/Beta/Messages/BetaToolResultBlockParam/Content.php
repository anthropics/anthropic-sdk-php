<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaToolResultBlockParam;

use Anthropic\Beta\Messages\BetaToolResultBlockParam\Content\UnionMember1;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;

/**
 * @phpstan-import-type UnionMember1Shape from \Anthropic\Beta\Messages\BetaToolResultBlockParam\Content\UnionMember1
 *
 * @phpstan-type ContentShape = string|list<UnionMember1Shape>
 */
final class Content implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return ['string', new ListOf(UnionMember1::class)];
    }
}
