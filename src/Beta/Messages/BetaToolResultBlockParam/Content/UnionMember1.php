<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaToolResultBlockParam\Content;

use Anthropic\Beta\Messages\BetaImageBlockParam;
use Anthropic\Beta\Messages\BetaRequestDocumentBlock;
use Anthropic\Beta\Messages\BetaSearchResultBlockParam;
use Anthropic\Beta\Messages\BetaTextBlockParam;
use Anthropic\Beta\Messages\BetaToolReferenceBlockParam;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Tool reference block that can be included in tool_result content.
 *
 * @phpstan-import-type BetaTextBlockParamShape from \Anthropic\Beta\Messages\BetaTextBlockParam
 * @phpstan-import-type BetaImageBlockParamShape from \Anthropic\Beta\Messages\BetaImageBlockParam
 * @phpstan-import-type BetaSearchResultBlockParamShape from \Anthropic\Beta\Messages\BetaSearchResultBlockParam
 * @phpstan-import-type BetaRequestDocumentBlockShape from \Anthropic\Beta\Messages\BetaRequestDocumentBlock
 * @phpstan-import-type BetaToolReferenceBlockParamShape from \Anthropic\Beta\Messages\BetaToolReferenceBlockParam
 *
 * @phpstan-type UnionMember1Shape = BetaTextBlockParamShape|BetaImageBlockParamShape|BetaSearchResultBlockParamShape|BetaRequestDocumentBlockShape|BetaToolReferenceBlockParamShape
 */
final class UnionMember1 implements ConverterSource
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
            'text' => BetaTextBlockParam::class,
            'image' => BetaImageBlockParam::class,
            'search_result' => BetaSearchResultBlockParam::class,
            'document' => BetaRequestDocumentBlock::class,
            'tool_reference' => BetaToolReferenceBlockParam::class,
        ];
    }
}
