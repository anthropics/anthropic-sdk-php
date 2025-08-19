<?php

declare(strict_types=1);

namespace Anthropic\Contracts\Beta;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Messages\BetaCodeExecutionTool20250522;
use Anthropic\Beta\Messages\BetaMessage;
use Anthropic\Beta\Messages\BetaMessageParam;
use Anthropic\Beta\Messages\BetaMessageTokensCount;
use Anthropic\Beta\Messages\BetaMetadata;
use Anthropic\Beta\Messages\BetaRequestMCPServerURLDefinition;
use Anthropic\Beta\Messages\BetaTextBlockParam;
use Anthropic\Beta\Messages\BetaThinkingConfigDisabled;
use Anthropic\Beta\Messages\BetaThinkingConfigEnabled;
use Anthropic\Beta\Messages\BetaTool;
use Anthropic\Beta\Messages\BetaToolBash20241022;
use Anthropic\Beta\Messages\BetaToolBash20250124;
use Anthropic\Beta\Messages\BetaToolChoiceAny;
use Anthropic\Beta\Messages\BetaToolChoiceAuto;
use Anthropic\Beta\Messages\BetaToolChoiceNone;
use Anthropic\Beta\Messages\BetaToolChoiceTool;
use Anthropic\Beta\Messages\BetaToolComputerUse20241022;
use Anthropic\Beta\Messages\BetaToolComputerUse20250124;
use Anthropic\Beta\Messages\BetaToolTextEditor20241022;
use Anthropic\Beta\Messages\BetaToolTextEditor20250124;
use Anthropic\Beta\Messages\BetaToolTextEditor20250429;
use Anthropic\Beta\Messages\BetaToolTextEditor20250728;
use Anthropic\Beta\Messages\BetaWebSearchTool20250305;
use Anthropic\Beta\Messages\MessageCountTokensParams;
use Anthropic\Beta\Messages\MessageCreateParams;
use Anthropic\Beta\Messages\MessageCreateParams\ServiceTier;
use Anthropic\Messages\Model;
use Anthropic\RequestOptions;

interface MessagesContract
{
    /**
     * @param array{
     *   maxTokens: int,
     *   messages: list<BetaMessageParam>,
     *   model: Model::*|string,
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
     *   anthropicBeta?: list<AnthropicBeta::*|string>,
     * }|MessageCreateParams $params
     */
    public function create(
        array|MessageCreateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BetaMessage;

    /**
     * @param array{
     *   messages: list<BetaMessageParam>,
     *   model: Model::*|string,
     *   mcpServers?: list<BetaRequestMCPServerURLDefinition>,
     *   system?: list<BetaTextBlockParam>|string,
     *   thinking?: BetaThinkingConfigDisabled|BetaThinkingConfigEnabled,
     *   toolChoice?: BetaToolChoiceAny|BetaToolChoiceAuto|BetaToolChoiceNone|BetaToolChoiceTool,
     *   tools?: list<BetaCodeExecutionTool20250522|BetaTool|BetaToolBash20241022|BetaToolBash20250124|BetaToolComputerUse20241022|BetaToolComputerUse20250124|BetaToolTextEditor20241022|BetaToolTextEditor20250124|BetaToolTextEditor20250429|BetaToolTextEditor20250728|BetaWebSearchTool20250305>,
     *   anthropicBeta?: list<AnthropicBeta::*|string>,
     * }|MessageCountTokensParams $params
     */
    public function countTokens(
        array|MessageCountTokensParams $params,
        ?RequestOptions $requestOptions = null,
    ): BetaMessageTokensCount;
}
