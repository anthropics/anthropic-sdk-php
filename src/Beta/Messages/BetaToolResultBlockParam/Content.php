<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaToolResultBlockParam;

use Anthropic\Beta\Messages\BetaImageBlockParam;
use Anthropic\Beta\Messages\BetaRequestDocumentBlock;
use Anthropic\Beta\Messages\BetaSearchResultBlockParam;
use Anthropic\Beta\Messages\BetaTextBlockParam;
use Anthropic\Beta\Messages\BetaToolReferenceBlockParam;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;

/**
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Messages\BetaToolResultBlockParam\Content\Content as ContentShape1
 *
 * @phpstan-type ContentVariants = string|list<BetaTextBlockParam|BetaImageBlockParam|BetaSearchResultBlockParam|BetaRequestDocumentBlock|BetaToolReferenceBlockParam>
 * @phpstan-type ContentShape = ContentVariants|list<ContentShape1>
 */
final class Content implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            'string',
            new ListOf(
                Content\Content::class
            ),
        ];
    }
}
