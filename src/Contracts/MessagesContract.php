<?php

declare(strict_types=1);

namespace Anthropic\Contracts;

use Anthropic\Messages\Message;
use Anthropic\Messages\MessageCountTokensParams;
use Anthropic\Messages\MessageCreateParams;
use Anthropic\Messages\MessageCreateParams\ServiceTier;
use Anthropic\Messages\MessageParam;
use Anthropic\Messages\MessageTokensCount;
use Anthropic\Messages\Metadata;
use Anthropic\Messages\Model;
use Anthropic\Messages\TextBlockParam;
use Anthropic\Messages\ThinkingConfigDisabled;
use Anthropic\Messages\ThinkingConfigEnabled;
use Anthropic\Messages\Tool;
use Anthropic\Messages\ToolBash20250124;
use Anthropic\Messages\ToolChoiceAny;
use Anthropic\Messages\ToolChoiceAuto;
use Anthropic\Messages\ToolChoiceNone;
use Anthropic\Messages\ToolChoiceTool;
use Anthropic\Messages\ToolTextEditor20250124;
use Anthropic\Messages\ToolTextEditor20250429;
use Anthropic\Messages\ToolTextEditor20250728;
use Anthropic\Messages\WebSearchTool20250305;
use Anthropic\RequestOptions;

interface MessagesContract
{
    /**
     * @param array{
     *   maxTokens: int,
     *   messages: list<MessageParam>,
     *   model: Model::*|string,
     *   metadata?: Metadata,
     *   serviceTier?: ServiceTier::*,
     *   stopSequences?: list<string>,
     *   system?: list<TextBlockParam>|string,
     *   temperature?: float,
     *   thinking?: ThinkingConfigDisabled|ThinkingConfigEnabled,
     *   toolChoice?: ToolChoiceAny|ToolChoiceAuto|ToolChoiceNone|ToolChoiceTool,
     *   tools?: list<Tool|ToolBash20250124|ToolTextEditor20250124|ToolTextEditor20250429|ToolTextEditor20250728|WebSearchTool20250305>,
     *   topK?: int,
     *   topP?: float,
     * }|MessageCreateParams $params
     */
    public function create(
        array|MessageCreateParams $params,
        ?RequestOptions $requestOptions = null,
    ): Message;

    /**
     * @param array{
     *   messages: list<MessageParam>,
     *   model: Model::*|string,
     *   system?: list<TextBlockParam>|string,
     *   thinking?: ThinkingConfigDisabled|ThinkingConfigEnabled,
     *   toolChoice?: ToolChoiceAny|ToolChoiceAuto|ToolChoiceNone|ToolChoiceTool,
     *   tools?: list<Tool|ToolBash20250124|ToolTextEditor20250124|ToolTextEditor20250429|ToolTextEditor20250728|WebSearchTool20250305>,
     * }|MessageCountTokensParams $params
     */
    public function countTokens(
        array|MessageCountTokensParams $params,
        ?RequestOptions $requestOptions = null,
    ): MessageTokensCount;
}
