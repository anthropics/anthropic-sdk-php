<?php

declare(strict_types=1);

namespace Anthropic\Contracts;

use Anthropic\Models\Message;
use Anthropic\Models\MessageCountTokensTool\TextEditor20250429 as TextEditor202504291;
use Anthropic\Models\MessageParam;
use Anthropic\Models\MessageTokensCount;
use Anthropic\Models\Metadata;
use Anthropic\Models\Model\UnionMember0;
use Anthropic\Models\TextBlockParam;
use Anthropic\Models\ThinkingConfigDisabled;
use Anthropic\Models\ThinkingConfigEnabled;
use Anthropic\Models\Tool;
use Anthropic\Models\ToolBash20250124;
use Anthropic\Models\ToolChoiceAny;
use Anthropic\Models\ToolChoiceAuto;
use Anthropic\Models\ToolChoiceNone;
use Anthropic\Models\ToolChoiceTool;
use Anthropic\Models\ToolTextEditor20250124;
use Anthropic\Models\ToolTextEditor20250728;
use Anthropic\Models\ToolUnion\TextEditor20250429;
use Anthropic\Models\WebSearchTool20250305;
use Anthropic\Parameters\MessageCountTokensParam;
use Anthropic\Parameters\MessageCreateParam;
use Anthropic\Parameters\MessageCreateParam\ServiceTier;
use Anthropic\RequestOptions;

interface MessagesContract
{
    /**
     * @param array{
     *   maxTokens: int,
     *   messages: list<MessageParam>,
     *   model: string|UnionMember0::*,
     *   metadata?: Metadata,
     *   serviceTier?: ServiceTier::*,
     *   stopSequences?: list<string>,
     *   system?: list<TextBlockParam>|string,
     *   temperature?: float,
     *   thinking?: ThinkingConfigDisabled|ThinkingConfigEnabled,
     *   toolChoice?: ToolChoiceAny|ToolChoiceAuto|ToolChoiceNone|ToolChoiceTool,
     *   tools?: list<TextEditor20250429|Tool|ToolBash20250124|ToolTextEditor20250124|ToolTextEditor20250728|WebSearchTool20250305>,
     *   topK?: int,
     *   topP?: float,
     * }|MessageCreateParam $params
     */
    public function create(
        array|MessageCreateParam $params,
        ?RequestOptions $requestOptions = null
    ): Message;

    /**
     * @param array{
     *   messages: list<MessageParam>,
     *   model: string|UnionMember0::*,
     *   system?: list<TextBlockParam>|string,
     *   thinking?: ThinkingConfigDisabled|ThinkingConfigEnabled,
     *   toolChoice?: ToolChoiceAny|ToolChoiceAuto|ToolChoiceNone|ToolChoiceTool,
     *   tools?: list<TextEditor202504291|Tool|ToolBash20250124|ToolTextEditor20250124|ToolTextEditor20250728|WebSearchTool20250305>,
     * }|MessageCountTokensParam $params
     */
    public function countTokens(
        array|MessageCountTokensParam $params,
        ?RequestOptions $requestOptions = null,
    ): MessageTokensCount;
}
