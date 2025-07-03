<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Beta\Messages\Batches;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Concerns\Params;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;
use Anthropic\Models\Beta\BetaCodeExecutionTool20250522;
use Anthropic\Models\Beta\BetaMessageParam;
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

class CreateParams implements BaseModel
{
    use Model;
    use Params;

    /**
     * @var list<array{
     *
     *     customID?: string,
     *     params?: array{
     *
     *         maxTokens?: int,
     *         messages?: list<BetaMessageParam>,
     *         model?: string|string,
     *         container?: string|null,
     *         mcpServers?: list<BetaRequestMCPServerURLDefinition>,
     *         metadata?: BetaMetadata,
     *         serviceTier?: string,
     *         stopSequences?: list<string>,
     *         stream?: bool,
     *         system?: string|list<BetaTextBlockParam>,
     *         temperature?: float,
     *         thinking?: BetaThinkingConfigEnabled|BetaThinkingConfigDisabled,
     *         toolChoice?: BetaToolChoiceAuto|BetaToolChoiceAny|BetaToolChoiceTool|BetaToolChoiceNone,
     *         tools?: list<BetaTool|BetaToolBash20241022|BetaToolBash20250124|BetaCodeExecutionTool20250522|BetaToolComputerUse20241022|BetaToolComputerUse20250124|BetaToolTextEditor20241022|BetaToolTextEditor20250124|BetaToolTextEditor20250429|BetaWebSearchTool20250305>,
     *         topK?: int,
     *         topP?: float,
     *
     * },
     *
     * }> $requests
     */
    #[Api(type: new ListOf(new ListOf('mixed')))]
    public array $requests;

    /**
     * @var list<string|string> $betas
     */
    #[Api(type: new ListOf(new UnionOf(['string', 'string'])), optional: true)]
    public array $betas;
}

CreateParams::_loadMetadata();
