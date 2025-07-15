<?php

declare(strict_types=1);

namespace Anthropic\Contracts;

use Anthropic\Models\Message;
use Anthropic\Models\MessageCountTokensTool\TextEditor20250429 as TextEditor202504291;
use Anthropic\Models\MessageParam;
use Anthropic\Models\MessageTokensCount;
use Anthropic\Models\Metadata;
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
use Anthropic\RequestOptions;

interface MessagesContract
{
    /**
     * @param array{
     *   maxTokens?: int,
     *   messages?: list<MessageParam>,
     *   model?: string|string,
     *   metadata?: Metadata,
     *   serviceTier?: string,
     *   stopSequences?: list<string>,
     *   stream?: bool,
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
        array $params,
        ?RequestOptions $requestOptions = null
    ): Message;

    /**
     * @param array{
     *   messages?: list<MessageParam>,
     *   model?: string|string,
     *   system?: string|list<TextBlockParam>,
     *   thinking?: ThinkingConfigEnabled|ThinkingConfigDisabled,
     *   toolChoice?: ToolChoiceAuto|ToolChoiceAny|ToolChoiceTool|ToolChoiceNone,
     *   tools?: list<
     *     Tool|ToolBash20250124|ToolTextEditor20250124|TextEditor202504291|WebSearchTool20250305
     *   >,
     * } $params
     */
    public function countTokens(
        array $params,
        ?RequestOptions $requestOptions = null
    ): MessageTokensCount;
}
