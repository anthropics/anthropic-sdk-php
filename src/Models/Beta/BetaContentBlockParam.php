<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Contracts\Converter;
use Anthropic\Core\Contracts\StaticConverter;

final class BetaContentBlockParam implements StaticConverter
{
    use Union;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|StaticConverter>|array<
     *   string, string|Converter|StaticConverter
     * >
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
