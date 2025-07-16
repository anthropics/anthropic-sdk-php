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
use Anthropic\Models\Beta\BetaWebSearchTool20250305;
use Anthropic\Models\Model\UnionMember0;
use Anthropic\Parameters\Beta\Messages\CountTokensParams;
use Anthropic\Parameters\Beta\Messages\CreateParams;
use Anthropic\Parameters\Beta\Messages\CreateParams\ServiceTier;
use Anthropic\Parameters\Beta\Messages\CreateParams\Stream;
use Anthropic\RequestOptions;

interface MessagesContract
{
    /**
     * @param CreateParams|array{
     *   maxTokens?: int,
     *   messages?: list<BetaMessageParam>,
     *   model?: UnionMember0::*|string,
     *   container?: string|null,
     *   mcpServers?: list<BetaRequestMCPServerURLDefinition>,
     *   metadata?: BetaMetadata,
     *   serviceTier?: ServiceTier::*,
     *   stopSequences?: list<string>,
     *   stream?: Stream::*,
     *   system?: string|list<BetaTextBlockParam>,
     *   temperature?: float,
     *   thinking?: BetaThinkingConfigEnabled|BetaThinkingConfigDisabled,
     *   toolChoice?: BetaToolChoiceAuto|BetaToolChoiceAny|BetaToolChoiceTool|BetaToolChoiceNone,
     *   tools?: list<
     *     BetaTool|BetaToolBash20241022|BetaToolBash20250124|BetaCodeExecutionTool20250522|BetaToolComputerUse20241022|BetaToolComputerUse20250124|BetaToolTextEditor20241022|BetaToolTextEditor20250124|BetaToolTextEditor20250429|BetaWebSearchTool20250305
     *   >,
     *   topK?: int,
     *   topP?: float,
     *   anthropicBeta?: list<string|UnionMember1::*>,
     * } $params
     */
    public function create(
        array|CreateParams $params,
        ?RequestOptions $requestOptions = null
    ): BetaMessage;

    /**
     * @param CountTokensParams|array{
     *   messages?: list<BetaMessageParam>,
     *   model?: UnionMember0::*|string,
     *   mcpServers?: list<BetaRequestMCPServerURLDefinition>,
     *   system?: string|list<BetaTextBlockParam>,
     *   thinking?: BetaThinkingConfigEnabled|BetaThinkingConfigDisabled,
     *   toolChoice?: BetaToolChoiceAuto|BetaToolChoiceAny|BetaToolChoiceTool|BetaToolChoiceNone,
     *   tools?: list<
     *     BetaTool|BetaToolBash20241022|BetaToolBash20250124|BetaCodeExecutionTool20250522|BetaToolComputerUse20241022|BetaToolComputerUse20250124|BetaToolTextEditor20241022|BetaToolTextEditor20250124|BetaToolTextEditor20250429|BetaWebSearchTool20250305
     *   >,
     *   anthropicBeta?: list<string|UnionMember1::*>,
     * } $params
     */
    public function countTokens(
        array|CountTokensParams $params,
        ?RequestOptions $requestOptions = null
    ): BetaMessageTokensCount;
}
