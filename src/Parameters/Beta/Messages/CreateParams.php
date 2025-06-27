<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Concerns\Params;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;
use Anthropic\Models\Beta\BetaThinkingConfigEnabled;
use Anthropic\Models\Beta\BetaThinkingConfigDisabled;
use Anthropic\Models\Beta\BetaToolChoiceAuto;
use Anthropic\Models\Beta\BetaToolChoiceAny;
use Anthropic\Models\Beta\BetaToolChoiceTool;
use Anthropic\Models\Beta\BetaToolChoiceNone;
use Anthropic\Models\Beta\BetaMessageParam;
use Anthropic\Models\Beta\BetaRequestMCPServerURLDefinition;
use Anthropic\Models\Beta\BetaMetadata;
use Anthropic\Models\Beta\BetaTextBlockParam;
use Anthropic\Models\Beta\BetaTool;
use Anthropic\Models\Beta\BetaToolComputerUse20241022;
use Anthropic\Models\Beta\BetaToolBash20241022;
use Anthropic\Models\Beta\BetaToolTextEditor20241022;
use Anthropic\Models\Beta\BetaToolComputerUse20250124;
use Anthropic\Models\Beta\BetaToolBash20250124;
use Anthropic\Models\Beta\BetaToolTextEditor20250124;
use Anthropic\Models\Beta\BetaToolTextEditor20250429;
use Anthropic\Models\Beta\BetaWebSearchTool20250305;
use Anthropic\Models\Beta\BetaCodeExecutionTool20250522;

class CreateParams implements BaseModel
{
    use Model;
    use Params;

    #[Api('max_tokens')]
    public int $maxTokens;

    /**
     * @var list<BetaMessageParam> $messages
     */
    #[Api(type: new ListOf(BetaMessageParam::class))]
    public array $messages;

    /**
     * @var string|string $model
     */
    #[Api]
    public mixed $model;

    #[Api(optional: true)]
    public ?string $container;

    /**
     * @var list<BetaRequestMCPServerURLDefinition> $mcpServers
     */
    #[Api(
        'mcp_servers',
        type: new ListOf(BetaRequestMCPServerURLDefinition::class),
        optional: true,
    )]
    public array $mcpServers;

    #[Api(optional: true)]
    public BetaMetadata $metadata;

    #[Api('service_tier', optional: true)]
    public string $serviceTier;

    /**
     * @var list<string> $stopSequences
     */
    #[Api('stop_sequences', type: new ListOf('string'), optional: true)]
    public array $stopSequences;

    #[Api(optional: true)]
    public bool $stream;

    /**
     * @var string|list<BetaTextBlockParam> $system
     */
    #[Api(
        type: new UnionOf(['string', new ListOf(BetaTextBlockParam::class)]),
        optional: true,
    )]
    public mixed $system;

    #[Api(optional: true)]
    public float $temperature;

    /**
     * @var BetaThinkingConfigEnabled|BetaThinkingConfigDisabled $thinking
     */
    #[Api(optional: true)]
    public mixed $thinking;

    /**
     * @var BetaToolChoiceAuto|BetaToolChoiceAny|BetaToolChoiceTool|BetaToolChoiceNone $toolChoice
     */
    #[Api('tool_choice', optional: true)]
    public mixed $toolChoice;

    /**
     * @var list<BetaTool|BetaToolComputerUse20241022|BetaToolBash20241022|BetaToolTextEditor20241022|BetaToolComputerUse20250124|BetaToolBash20250124|BetaToolTextEditor20250124|BetaToolTextEditor20250429|BetaWebSearchTool20250305|BetaCodeExecutionTool20250522> $tools
     */
    #[Api(
        type: new ListOf(
            new UnionOf(
                [
                    BetaTool::class,
                    BetaToolComputerUse20241022::class,
                    BetaToolBash20241022::class,
                    BetaToolTextEditor20241022::class,
                    BetaToolComputerUse20250124::class,
                    BetaToolBash20250124::class,
                    BetaToolTextEditor20250124::class,
                    BetaToolTextEditor20250429::class,
                    BetaWebSearchTool20250305::class,
                    BetaCodeExecutionTool20250522::class,
                ],
            ),
        ),
        optional: true,
    )]
    public array $tools;

    #[Api('top_k', optional: true)]
    public int $topK;

    #[Api('top_p', optional: true)]
    public float $topP;

    /**
     * @var list<string|string> $betas
     */
    #[Api(type: new ListOf(new UnionOf(['string', 'string'])), optional: true)]
    public array $betas;
}

CreateParams::_loadMetadata();
