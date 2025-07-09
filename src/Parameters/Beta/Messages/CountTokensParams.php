<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Concerns\Params;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;
use Anthropic\Models\Beta\BetaCodeExecutionTool20250522;
use Anthropic\Models\Beta\BetaMessageParam;
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

class CountTokensParams implements BaseModel
{
    use Model;
    use Params;

    /** @var list<BetaMessageParam> $messages */
    #[Api(type: new ListOf(BetaMessageParam::class))]
    public array $messages;

    /** @var string|string $model */
    #[Api]
    public mixed $model;

    /** @var null|list<BetaRequestMCPServerURLDefinition> $mcpServers */
    #[Api(
        'mcp_servers',
        type: new UnionOf(
            [new ListOf(BetaRequestMCPServerURLDefinition::class), 'null']
        ),
        optional: true,
    )]
    public ?array $mcpServers;

    /** @var null|list<BetaTextBlockParam>|string $system */
    #[Api(
        type: new UnionOf(
            ['string', new ListOf(BetaTextBlockParam::class), 'null']
        ),
        optional: true,
    )]
    public mixed $system;

    /** @var BetaThinkingConfigDisabled|BetaThinkingConfigEnabled $thinking */
    #[Api(optional: true)]
    public mixed $thinking;

    /**
     * @var BetaToolChoiceAny|BetaToolChoiceAuto|BetaToolChoiceNone|BetaToolChoiceTool $toolChoice
     */
    #[Api('tool_choice', optional: true)]
    public mixed $toolChoice;

    /**
     * @var null|list<BetaCodeExecutionTool20250522|BetaTool|BetaToolBash20241022|BetaToolBash20250124|BetaToolComputerUse20241022|BetaToolComputerUse20250124|BetaToolTextEditor20241022|BetaToolTextEditor20250124|BetaToolTextEditor20250429|BetaWebSearchTool20250305> $tools
     */
    #[Api(
        type: new UnionOf(
            [
                new ListOf(
                    new UnionOf(
                        [
                            BetaTool::class,
                            BetaToolBash20241022::class,
                            BetaToolBash20250124::class,
                            BetaCodeExecutionTool20250522::class,
                            BetaToolComputerUse20241022::class,
                            BetaToolComputerUse20250124::class,
                            BetaToolTextEditor20241022::class,
                            BetaToolTextEditor20250124::class,
                            BetaToolTextEditor20250429::class,
                            BetaWebSearchTool20250305::class,
                        ],
                    ),
                ),
                'null',
            ],
        ),
        optional: true,
    )]
    public ?array $tools;

    /** @var null|list<string|string> $anthropicBeta */
    #[Api(
        type: new UnionOf([new ListOf(new UnionOf(['string', 'string'])), 'null']),
        optional: true,
    )]
    public ?array $anthropicBeta;
}

CountTokensParams::_loadMetadata();
