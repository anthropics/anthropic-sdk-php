<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Concerns\Params;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;
use Anthropic\Models\AnthropicBeta\UnionMember1;
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
use Anthropic\Models\Model\UnionMember0;
use Anthropic\Parameters\Beta\MessageCreateParam\ServiceTier;
use Anthropic\Parameters\Beta\MessageCreateParam\Stream;

final class MessageCreateParam implements BaseModel
{
    use Model;
    use Params;

    #[Api('max_tokens')]
    public int $maxTokens;

    /** @var list<BetaMessageParam> $messages */
    #[Api(type: new ListOf(BetaMessageParam::class))]
    public array $messages;

    /** @var string|UnionMember0::* $model */
    #[Api]
    public string $model;

    #[Api(optional: true)]
    public ?string $container;

    /** @var null|list<BetaRequestMCPServerURLDefinition> $mcpServers */
    #[Api(
        'mcp_servers',
        type: new ListOf(BetaRequestMCPServerURLDefinition::class),
        optional: true,
    )]
    public ?array $mcpServers;

    #[Api(optional: true)]
    public ?BetaMetadata $metadata;

    /** @var null|ServiceTier::* $serviceTier */
    #[Api('service_tier', optional: true)]
    public ?string $serviceTier;

    /** @var null|list<string> $stopSequences */
    #[Api('stop_sequences', type: new ListOf('string'), optional: true)]
    public ?array $stopSequences;

    /** @var null|Stream::* $stream */
    #[Api(optional: true)]
    public ?bool $stream;

    /** @var null|list<BetaTextBlockParam>|string $system */
    #[Api(
        union: new UnionOf(['string', new ListOf(BetaTextBlockParam::class)]),
        optional: true,
    )]
    public null|array|string $system;

    #[Api(optional: true)]
    public ?float $temperature;

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
            union: new UnionOf(
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

    #[Api('top_k', optional: true)]
    public ?int $topK;

    #[Api('top_p', optional: true)]
    public ?float $topP;

    /** @var null|list<string|UnionMember1::*> $anthropicBeta */
    #[Api(
        type: new ListOf(union: new UnionOf(['string', UnionMember1::class])),
        optional: true,
    )]
    public ?array $anthropicBeta;

    /**
     * You must use named parameters to construct this object.
     *
     * @param list<BetaMessageParam>                       $messages
     * @param string|UnionMember0::*                       $model
     * @param null|list<BetaRequestMCPServerURLDefinition> $mcpServers
     * @param null|ServiceTier::*                          $serviceTier
     * @param null|list<string>                            $stopSequences
     * @param null|Stream::*                               $stream
     * @param null|list<BetaTextBlockParam>|string         $system
     * @param list<
     *   BetaTool|BetaToolBash20241022|BetaToolBash20250124|BetaCodeExecutionTool20250522|BetaToolComputerUse20241022|BetaToolComputerUse20250124|BetaToolTextEditor20241022|BetaToolTextEditor20250124|BetaToolTextEditor20250429|BetaWebSearchTool20250305
     * >|null $tools
     * @param null|list<string|UnionMember1::*> $anthropicBeta
     */
    final public function __construct(
        int $maxTokens,
        array $messages,
        string $model,
        ?bool $stream,
        ?string $container = null,
        ?array $mcpServers = null,
        ?BetaMetadata $metadata = null,
        ?string $serviceTier = null,
        ?array $stopSequences = null,
        null|array|string $system = null,
        ?float $temperature = null,
        null|BetaThinkingConfigDisabled|BetaThinkingConfigEnabled $thinking = null,
        null|BetaToolChoiceAny|BetaToolChoiceAuto|BetaToolChoiceNone|BetaToolChoiceTool $toolChoice = null,
        ?array $tools = null,
        ?int $topK = null,
        ?float $topP = null,
        ?array $anthropicBeta = null,
    ) {
        self::introspect();
        $this->unsetOptionalProperties();

        $this->maxTokens = $maxTokens;
        $this->messages = $messages;
        $this->model = $model;

        null !== $container && $this->container = $container;
        null !== $mcpServers && $this->mcpServers = $mcpServers;
        null !== $metadata && $this->metadata = $metadata;
        null !== $serviceTier && $this->serviceTier = $serviceTier;
        null !== $stopSequences && $this->stopSequences = $stopSequences;
        null !== $stream && $this->stream = $stream;
        null !== $system && $this->system = $system;
        null !== $temperature && $this->temperature = $temperature;
        null !== $thinking && $this->thinking = $thinking;
        null !== $toolChoice && $this->toolChoice = $toolChoice;
        null !== $tools && $this->tools = $tools;
        null !== $topK && $this->topK = $topK;
        null !== $topP && $this->topP = $topP;
        null !== $anthropicBeta && $this->anthropicBeta = $anthropicBeta;
    }
}
