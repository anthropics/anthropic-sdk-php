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

final class CountTokensParams implements BaseModel
{
    use Model;
    use Params;

    /** @var list<BetaMessageParam> $messages */
    #[Api(type: new ListOf(BetaMessageParam::class))]
    public array $messages;

    #[Api]
    public string $model;

    /** @var null|list<BetaRequestMCPServerURLDefinition> $mcpServers */
    #[Api(
        'mcp_servers',
        type: new ListOf(BetaRequestMCPServerURLDefinition::class),
        optional: true,
    )]
    public ?array $mcpServers;

    /** @var null|list<BetaTextBlockParam>|string $system */
    #[Api(
        type: new UnionOf(['string', new ListOf(BetaTextBlockParam::class)]),
        optional: true,
    )]
    public null|array|string $system;

    #[Api(optional: true)]
    public null|BetaThinkingConfigDisabled|BetaThinkingConfigEnabled $thinking;

    #[Api('tool_choice', optional: true)]
    public null|BetaToolChoiceAny|BetaToolChoiceAuto|BetaToolChoiceNone|BetaToolChoiceTool $toolChoice;

    /**
     * @var list<
     *   BetaTool|BetaToolBash20241022|BetaToolBash20250124|BetaCodeExecutionTool20250522|BetaToolComputerUse20241022|BetaToolComputerUse20250124|BetaToolTextEditor20241022|BetaToolTextEditor20250124|BetaToolTextEditor20250429|BetaWebSearchTool20250305
     * >|null $tools
     */
    #[Api(
        type: new ListOf(
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
        optional: true,
    )]
    public ?array $tools;

    /** @var null|list<string> $anthropicBeta */
    #[Api(type: new ListOf(new UnionOf(['string', 'string'])), optional: true)]
    public ?array $anthropicBeta;

    /**
     * You must use named parameters to construct this object.
     *
     * @param list<BetaMessageParam>                       $messages
     * @param null|list<BetaRequestMCPServerURLDefinition> $mcpServers
     * @param null|list<BetaTextBlockParam>|string         $system
     * @param list<
     *   BetaTool|BetaToolBash20241022|BetaToolBash20250124|BetaCodeExecutionTool20250522|BetaToolComputerUse20241022|BetaToolComputerUse20250124|BetaToolTextEditor20241022|BetaToolTextEditor20250124|BetaToolTextEditor20250429|BetaWebSearchTool20250305
     * >|null $tools
     * @param null|list<string> $anthropicBeta
     */
    final public function __construct(
        array $messages,
        string $model,
        ?array $mcpServers = null,
        null|array|string $system = null,
        null|BetaThinkingConfigDisabled|BetaThinkingConfigEnabled $thinking = null,
        null|BetaToolChoiceAny|BetaToolChoiceAuto|BetaToolChoiceNone|BetaToolChoiceTool $toolChoice = null,
        ?array $tools = null,
        ?array $anthropicBeta = null,
    ) {
        $this->messages = $messages;
        $this->model = $model;
        $this->mcpServers = $mcpServers;
        $this->system = $system;
        $this->thinking = $thinking;
        $this->toolChoice = $toolChoice;
        $this->tools = $tools;
        $this->anthropicBeta = $anthropicBeta;
    }
}

CountTokensParams::_loadMetadata();
