<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaMessageParam;

use Anthropic\Beta\Messages\BetaCodeExecutionToolResultBlockParam;
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
use Anthropic\Beta\Messages\BetaThinkingBlockParam;
use Anthropic\Beta\Messages\BetaToolResultBlockParam;
use Anthropic\Beta\Messages\BetaToolUseBlockParam;
use Anthropic\Beta\Messages\BetaWebSearchToolResultBlockParam;
use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;

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
