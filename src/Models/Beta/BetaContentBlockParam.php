<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Regular text content.
 *
 * @phpstan-type beta_content_block_param_alias = BetaTextBlockParam|BetaImageBlockParam|BetaRequestDocumentBlock|BetaSearchResultBlockParam|BetaThinkingBlockParam|BetaRedactedThinkingBlockParam|BetaToolUseBlockParam|BetaToolResultBlockParam|BetaServerToolUseBlockParam|BetaWebSearchToolResultBlockParam|BetaCodeExecutionToolResultBlockParam|BetaMCPToolUseBlockParam|BetaRequestMCPToolResultBlockParam|BetaContainerUploadBlockParam
 */
final class BetaContentBlockParam implements ConverterSource
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
            'document' => BetaRequestDocumentBlock::class,
            'search_result' => BetaSearchResultBlockParam::class,
            'thinking' => BetaThinkingBlockParam::class,
            'redacted_thinking' => BetaRedactedThinkingBlockParam::class,
            'tool_use' => BetaToolUseBlockParam::class,
            'tool_result' => BetaToolResultBlockParam::class,
            'server_tool_use' => BetaServerToolUseBlockParam::class,
            'web_search_tool_result' => BetaWebSearchToolResultBlockParam::class,
            'code_execution_tool_result' => BetaCodeExecutionToolResultBlockParam::class,
            'mcp_tool_use' => BetaMCPToolUseBlockParam::class,
            'mcp_tool_result' => BetaRequestMCPToolResultBlockParam::class,
            'container_upload' => BetaContainerUploadBlockParam::class,
        ];
    }
}
