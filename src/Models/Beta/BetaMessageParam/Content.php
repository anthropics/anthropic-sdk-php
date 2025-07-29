<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\BetaMessageParam;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Models\Beta\BetaCodeExecutionToolResultBlockParam;
use Anthropic\Models\Beta\BetaContainerUploadBlockParam;
use Anthropic\Models\Beta\BetaContentBlockParam;
use Anthropic\Models\Beta\BetaImageBlockParam;
use Anthropic\Models\Beta\BetaMCPToolUseBlockParam;
use Anthropic\Models\Beta\BetaRedactedThinkingBlockParam;
use Anthropic\Models\Beta\BetaRequestDocumentBlock;
use Anthropic\Models\Beta\BetaRequestMCPToolResultBlockParam;
use Anthropic\Models\Beta\BetaSearchResultBlockParam;
use Anthropic\Models\Beta\BetaServerToolUseBlockParam;
use Anthropic\Models\Beta\BetaTextBlockParam;
use Anthropic\Models\Beta\BetaThinkingBlockParam;
use Anthropic\Models\Beta\BetaToolResultBlockParam;
use Anthropic\Models\Beta\BetaToolUseBlockParam;
use Anthropic\Models\Beta\BetaWebSearchToolResultBlockParam;

/**
 * @phpstan-type content_alias = string|list<BetaTextBlockParam|BetaImageBlockParam|BetaRequestDocumentBlock|BetaSearchResultBlockParam|BetaThinkingBlockParam|BetaRedactedThinkingBlockParam|BetaToolUseBlockParam|BetaToolResultBlockParam|BetaServerToolUseBlockParam|BetaWebSearchToolResultBlockParam|BetaCodeExecutionToolResultBlockParam|BetaMCPToolUseBlockParam|BetaRequestMCPToolResultBlockParam|BetaContainerUploadBlockParam>
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
        return ['string', new ListOf(BetaContentBlockParam::class)];
    }
}
