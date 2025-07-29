<?php

declare(strict_types=1);

namespace Anthropic\Contracts\Beta;

use Anthropic\Models\AnthropicBeta\UnionMember1;
use Anthropic\Models\Beta\BetaCodeExecutionTool20250522;
use Anthropic\Models\Beta\BetaMessage;
use Anthropic\Models\Beta\BetaMessageParam;
use Anthropic\Models\Beta\BetaMessageTokensCount;
use Anthropic\Models\Beta\BetaMetadata;
use Anthropic\Models\Beta\BetaRequestMCPServerURLDefinition;
use Anthropic\Models\Beta\BetaTextBlockParam;
use Anthropic\Models\Beta\BetaThinkingConfigDisabled;
use Anthropic\Models\Beta\BetaThinkingConfigEnabled;
use Anthropic\Models\Beta\BetaTool;
use Anthropic\Models\Beta\BetaToolBash20241022;
use Anthropic\Models\Beta\BetaToolBash20250124;
use Anthropic\Models\Beta\BetaToolChoiceAny;
use Anthropic\Models\Beta\BetaToolChoiceAuto;
use Anthropic\Models\Beta\BetaToolChoiceNone;
use Anthropic\Models\Beta\BetaToolChoiceTool;
use Anthropic\Models\Beta\BetaToolComputerUse20241022;
use Anthropic\Models\Beta\BetaToolComputerUse20250124;
use Anthropic\Models\Beta\BetaToolTextEditor20241022;
use Anthropic\Models\Beta\BetaToolTextEditor20250124;
use Anthropic\Models\Beta\BetaToolTextEditor20250429;
use Anthropic\Models\Beta\BetaToolTextEditor20250728;
use Anthropic\Models\Beta\BetaWebSearchTool20250305;
use Anthropic\Models\Model\UnionMember0;
use Anthropic\Parameters\Beta\MessageCountTokensParam;
use Anthropic\Parameters\Beta\MessageCreateParam;
use Anthropic\Parameters\Beta\MessageCreateParam\ServiceTier;
use Anthropic\RequestOptions;

interface MessagesContract
{
    /**
     * @param array{
     *   maxTokens: int,
     *   messages: list<BetaMessageParam>,
     *   model: string|UnionMember0::*,
     *   container?: null|string,
     *   mcpServers?: list<BetaRequestMCPServerURLDefinition>,
     *   metadata?: BetaMetadata,
     *   serviceTier?: ServiceTier::*,
     *   stopSequences?: list<string>,
     *   system?: list<BetaTextBlockParam>|string,
     *   temperature?: float,
     *   thinking?: BetaThinkingConfigDisabled|BetaThinkingConfigEnabled,
     *   toolChoice?: BetaToolChoiceAny|BetaToolChoiceAuto|BetaToolChoiceNone|BetaToolChoiceTool,
     *   tools?: list<BetaCodeExecutionTool20250522|BetaTool|BetaToolBash20241022|BetaToolBash20250124|BetaToolComputerUse20241022|BetaToolComputerUse20250124|BetaToolTextEditor20241022|BetaToolTextEditor20250124|BetaToolTextEditor20250429|BetaToolTextEditor20250728|BetaWebSearchTool20250305>,
     *   topK?: int,
     *   topP?: float,
     *   anthropicBeta?: list<string|UnionMember1::*>,
     * }|MessageCreateParam $params
     */
    public function create(
        array|MessageCreateParam $params,
        ?RequestOptions $requestOptions = null
    ): BetaMessage;

    /**
     * @param array{
     *   messages: list<BetaMessageParam>,
     *   model: string|UnionMember0::*,
     *   mcpServers?: list<BetaRequestMCPServerURLDefinition>,
     *   system?: list<BetaTextBlockParam>|string,
     *   thinking?: BetaThinkingConfigDisabled|BetaThinkingConfigEnabled,
     *   toolChoice?: BetaToolChoiceAny|BetaToolChoiceAuto|BetaToolChoiceNone|BetaToolChoiceTool,
     *   tools?: list<BetaCodeExecutionTool20250522|BetaTool|BetaToolBash20241022|BetaToolBash20250124|BetaToolComputerUse20241022|BetaToolComputerUse20250124|BetaToolTextEditor20241022|BetaToolTextEditor20250124|BetaToolTextEditor20250429|BetaToolTextEditor20250728|BetaWebSearchTool20250305>,
     *   anthropicBeta?: list<string|UnionMember1::*>,
     * }|MessageCountTokensParam $params
     */
    public function countTokens(
        array|MessageCountTokensParam $params,
        ?RequestOptions $requestOptions = null,
    ): BetaMessageTokensCount;
}
