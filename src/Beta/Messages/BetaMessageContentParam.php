<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;

/**
 * @phpstan-import-type BetaContentBlockParamShape from \Anthropic\Beta\Messages\BetaContentBlockParam
 *
 * @phpstan-type BetaMessageContentParamVariants = string|list<BetaTextBlockParam|BetaImageBlockParam|BetaRequestDocumentBlock|BetaSearchResultBlockParam|BetaThinkingBlockParam|BetaRedactedThinkingBlockParam|BetaToolUseBlockParam|BetaToolResultBlockParam|BetaServerToolUseBlockParam|BetaWebSearchToolResultBlockParam|BetaWebFetchToolResultBlockParam|BetaAdvisorToolResultBlockParam|BetaCodeExecutionToolResultBlockParam|BetaBashCodeExecutionToolResultBlockParam|BetaTextEditorCodeExecutionToolResultBlockParam|BetaToolSearchToolResultBlockParam|BetaMCPToolUseBlockParam|BetaRequestMCPToolResultBlockParam|BetaContainerUploadBlockParam|BetaCompactionBlockParam|BetaRequestToolAdditionBlock|BetaRequestToolRemovalBlock|BetaMCPToolListingBlockParam|BetaFallbackBlockParam>
 * @phpstan-type BetaMessageContentParamShape = BetaMessageContentParamVariants|list<BetaContentBlockParamShape>
 */
final class BetaMessageContentParam implements ConverterSource
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
