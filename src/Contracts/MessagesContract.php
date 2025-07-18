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
use Anthropic\Models\ToolUnion\TextEditor20250429;
use Anthropic\Models\WebSearchTool20250305;
use Anthropic\Parameters\MessageCountTokensParam;
use Anthropic\Parameters\MessageCreateParam;
use Anthropic\Parameters\MessageCreateParam\ServiceTier;
use Anthropic\RequestOptions;

interface MessagesContract
{
    /**
     * @param MessageCreateParam|array{
     *   maxTokens?: int,
     *   messages?: list<MessageParam>,
     *   model?: UnionMember0::*|string,
     *   metadata?: Metadata,
     *   serviceTier?: ServiceTier::*,
     *   stopSequences?: list<string>,
     *   system?: string|list<TextBlockParam>,
     *   temperature?: float,
     *   thinking?: ThinkingConfigEnabled|ThinkingConfigDisabled,
     *   toolChoice?: ToolChoiceAuto|ToolChoiceAny|ToolChoiceTool|ToolChoiceNone,
     *   tools?: list<
     *     Tool|ToolBash20250124|ToolTextEditor20250124|TextEditor20250429|WebSearchTool20250305
     *   >,
     *   topK?: int,
     *   topP?: float,
     * } $params
     */
    public function create(
        array|MessageCreateParam $params,
        ?RequestOptions $requestOptions = null
    ): Message;

    /**
     * @param MessageCountTokensParam|array{
     *   messages?: list<MessageParam>,
     *   model?: UnionMember0::*|string,
     *   system?: string|list<TextBlockParam>,
     *   thinking?: ThinkingConfigEnabled|ThinkingConfigDisabled,
     *   toolChoice?: ToolChoiceAuto|ToolChoiceAny|ToolChoiceTool|ToolChoiceNone,
     *   tools?: list<
     *     Tool|ToolBash20250124|ToolTextEditor20250124|TextEditor202504291|WebSearchTool20250305
     *   >,
     * } $params
     */
    public function countTokens(
        array|MessageCountTokensParam $params,
        ?RequestOptions $requestOptions = null,
    ): MessageTokensCount;
}
