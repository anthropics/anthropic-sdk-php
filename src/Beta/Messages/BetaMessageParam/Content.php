<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaMessageParam;

use Anthropic\Beta\Messages\BetaBashCodeExecutionToolResultBlockParam;
use Anthropic\Beta\Messages\BetaCodeExecutionToolResultBlockParam;
use Anthropic\Beta\Messages\BetaCompactionBlockParam;
use Anthropic\Beta\Messages\BetaContainerUploadBlockParam;
use Anthropic\Beta\Messages\BetaContentBlockParam;
use Anthropic\Beta\Messages\BetaImageBlockParam;
use Anthropic\Beta\Messages\BetaMCPToolUseBlockParam;
use Anthropic\Beta\Messages\BetaRedactedThinkingBlockParam;
use Anthropic\Beta\Messages\BetaRequestDocumentBlock;
use Anthropic\Beta\Messages\BetaRequestMCPToolResultBlockParam;
use Anthropic\Beta\Messages\BetaSearchResultBlockParam;
use Anthropic\Beta\Messages\BetaServerToolUseBlockParam;
use Anthropic\Beta\Messages\BetaTextBlockParam;
use Anthropic\Beta\Messages\BetaTextEditorCodeExecutionToolResultBlockParam;
use Anthropic\Beta\Messages\BetaThinkingBlockParam;
use Anthropic\Beta\Messages\BetaToolResultBlockParam;
use Anthropic\Beta\Messages\BetaToolSearchToolResultBlockParam;
use Anthropic\Beta\Messages\BetaToolUseBlockParam;
use Anthropic\Beta\Messages\BetaWebFetchToolResultBlockParam;
use Anthropic\Beta\Messages\BetaWebSearchToolResultBlockParam;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;

/**
 * @phpstan-import-type BetaContentBlockParamShape from \Anthropic\Beta\Messages\BetaContentBlockParam
 *
 * @phpstan-type ContentVariants = string|list<BetaTextBlockParam|BetaImageBlockParam|BetaRequestDocumentBlock|BetaSearchResultBlockParam|BetaThinkingBlockParam|BetaRedactedThinkingBlockParam|BetaToolUseBlockParam|BetaToolResultBlockParam|BetaServerToolUseBlockParam|BetaWebSearchToolResultBlockParam|BetaWebFetchToolResultBlockParam|BetaCodeExecutionToolResultBlockParam|BetaBashCodeExecutionToolResultBlockParam|BetaTextEditorCodeExecutionToolResultBlockParam|BetaToolSearchToolResultBlockParam|BetaMCPToolUseBlockParam|BetaRequestMCPToolResultBlockParam|BetaContainerUploadBlockParam|BetaCompactionBlockParam>
 * @phpstan-type ContentShape = ContentVariants|list<BetaContentBlockParamShape>
 */
final class Content implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return ['string', new ListOf(BetaContentBlockParam::class)];
    }
}
