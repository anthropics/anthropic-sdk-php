<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Messages\BatchCreateParam\Request;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Models\MessageParam;
use Anthropic\Models\Metadata;
use Anthropic\Models\Model\UnionMember0;
use Anthropic\Models\TextBlockParam;
use Anthropic\Models\ThinkingConfigDisabled;
use Anthropic\Models\ThinkingConfigEnabled;
use Anthropic\Models\ThinkingConfigParam;
use Anthropic\Models\Tool;
use Anthropic\Models\ToolBash20250124;
use Anthropic\Models\ToolChoice;
use Anthropic\Models\ToolChoiceAny;
use Anthropic\Models\ToolChoiceAuto;
use Anthropic\Models\ToolChoiceNone;
use Anthropic\Models\ToolChoiceTool;
use Anthropic\Models\ToolTextEditor20250124;
use Anthropic\Models\ToolUnion;
use Anthropic\Models\ToolUnion\TextEditor20250429;
use Anthropic\Models\WebSearchTool20250305;
use Anthropic\Parameters\Messages\BatchCreateParam\Request\Params\ServiceTier;
use Anthropic\Parameters\Messages\BatchCreateParam\Request\Params\System;

/**
 * @phpstan-type params_alias = array{
 *   maxTokens: int,
 *   messages: list<MessageParam>,
 *   model: UnionMember0::*|string,
 *   metadata?: Metadata,
 *   serviceTier?: ServiceTier::*,
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
 * }
 */
final class Params implements BaseModel
{
    use Model;

    #[Api('max_tokens')]
    public int $maxTokens;

    /** @var list<MessageParam> $messages */
    #[Api(type: new ListOf(MessageParam::class))]
    public array $messages;

    /** @var string|UnionMember0::* $model */
    #[Api]
    public string $model;

    #[Api(optional: true)]
    public ?Metadata $metadata;

    /** @var null|ServiceTier::* $serviceTier */
    #[Api('service_tier', optional: true)]
    public ?string $serviceTier;

    /** @var null|list<string> $stopSequences */
    #[Api('stop_sequences', type: new ListOf('string'), optional: true)]
    public ?array $stopSequences;

    #[Api(optional: true)]
    public ?bool $stream;

    /** @var null|list<TextBlockParam>|string $system */
    #[Api(union: System::class, optional: true)]
    public null|array|string $system;

    #[Api(optional: true)]
    public ?float $temperature;

    #[Api(union: ThinkingConfigParam::class, optional: true)]
    public null|ThinkingConfigDisabled|ThinkingConfigEnabled $thinking;

    #[Api('tool_choice', union: ToolChoice::class, optional: true)]
    public null|ToolChoiceAny|ToolChoiceAuto|ToolChoiceNone|ToolChoiceTool $toolChoice;

    /**
     * @var list<
     *   Tool|ToolBash20250124|ToolTextEditor20250124|TextEditor20250429|WebSearchTool20250305
     * >|null $tools
     */
    #[Api(type: new ListOf(union: ToolUnion::class), optional: true)]
    public ?array $tools;

    #[Api('top_k', optional: true)]
    public ?int $topK;

    #[Api('top_p', optional: true)]
    public ?float $topP;

    /**
     * You must use named parameters to construct this object.
     *
     * @param list<MessageParam>               $messages
     * @param string|UnionMember0::*           $model
     * @param null|ServiceTier::*              $serviceTier
     * @param null|list<string>                $stopSequences
     * @param null|list<TextBlockParam>|string $system
     * @param list<
     *   Tool|ToolBash20250124|ToolTextEditor20250124|TextEditor20250429|WebSearchTool20250305
     * >|null $tools
     */
    final public function __construct(
        int $maxTokens,
        array $messages,
        string $model,
        ?Metadata $metadata = null,
        ?string $serviceTier = null,
        ?array $stopSequences = null,
        ?bool $stream = null,
        null|array|string $system = null,
        ?float $temperature = null,
        null|ThinkingConfigDisabled|ThinkingConfigEnabled $thinking = null,
        null|ToolChoiceAny|ToolChoiceAuto|ToolChoiceNone|ToolChoiceTool $toolChoice = null,
        ?array $tools = null,
        ?int $topK = null,
        ?float $topP = null,
    ) {
        self::introspect();
        $this->unsetOptionalProperties();

        $this->maxTokens = $maxTokens;
        $this->messages = $messages;
        $this->model = $model;

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
    }
}
