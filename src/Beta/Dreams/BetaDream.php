<?php

declare(strict_types=1);

namespace Anthropic\Beta\Dreams;

use Anthropic\Beta\Dreams\BetaDream\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * An asynchronous memory-consolidation job that reads a memory store plus a set of session transcripts and writes consolidated memories into an output memory store — a new store by default, or an existing store chosen via output_behavior. The Dreams API is in research preview: the request and response shapes are volatile and may change without the deprecation period that applies to generally-available endpoints.
 *
 * @phpstan-import-type BetaDreamInputVariants from \Anthropic\Beta\Dreams\BetaDreamInput
 * @phpstan-import-type BetaOutputBehaviorVariants from \Anthropic\Beta\Dreams\BetaOutputBehavior
 * @phpstan-import-type BetaDreamErrorShape from \Anthropic\Beta\Dreams\BetaDreamError
 * @phpstan-import-type BetaDreamInputShape from \Anthropic\Beta\Dreams\BetaDreamInput
 * @phpstan-import-type BetaDreamModelConfigShape from \Anthropic\Beta\Dreams\BetaDreamModelConfig
 * @phpstan-import-type BetaOutputBehaviorShape from \Anthropic\Beta\Dreams\BetaOutputBehavior
 * @phpstan-import-type BetaDreamOutputShape from \Anthropic\Beta\Dreams\BetaDreamOutput
 * @phpstan-import-type BetaDreamUsageShape from \Anthropic\Beta\Dreams\BetaDreamUsage
 *
 * @phpstan-type BetaDreamShape = array{
 *   id: string,
 *   archivedAt: \DateTimeInterface|null,
 *   createdAt: \DateTimeInterface,
 *   endedAt: \DateTimeInterface|null,
 *   error: null|BetaDreamError|BetaDreamErrorShape,
 *   inputs: list<BetaDreamInputShape>,
 *   instructions: string|null,
 *   model: BetaDreamModelConfig|BetaDreamModelConfigShape,
 *   outputBehavior: BetaOutputBehaviorShape,
 *   outputs: list<BetaDreamOutput|BetaDreamOutputShape>,
 *   sessionID: string|null,
 *   status: BetaDreamStatus|value-of<BetaDreamStatus>,
 *   type: Type|value-of<Type>,
 *   usage: BetaDreamUsage|BetaDreamUsageShape,
 * }
 */
final class BetaDream implements BaseModel
{
    /** @use SdkModel<BetaDreamShape> */
    use SdkModel;

    /**
     * The unique ID of the dream (`drm_...`).
     */
    #[Required]
    public string $id;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('archived_at')]
    public ?\DateTimeInterface $archivedAt;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('ended_at')]
    public ?\DateTimeInterface $endedAt;

    /**
     * Failure detail for a Dream whose `status` is `failed`.
     */
    #[Required]
    public ?BetaDreamError $error;

    /**
     * The sources that the dream reads, from the request that created it.
     *
     * @var list<BetaDreamInputVariants> $inputs
     */
    #[Required(list: BetaDreamInput::class)]
    public array $inputs;

    /**
     * The guidance given when the dream was created, or `null` if none was given.
     */
    #[Required]
    public ?string $instructions;

    /**
     * Model identifier and configuration applied to every pipeline stage. Same wire shape as the Agents API ModelConfig.
     */
    #[Required]
    public BetaDreamModelConfig $model;

    /**
     * Which memory store a dream writes its result to. Defaults to `create_new` when left out of a create request.
     *
     * @var BetaOutputBehaviorVariants $outputBehavior
     */
    #[Required('output_behavior', union: BetaOutputBehavior::class)]
    public BetaOutputBehaviorCreateNew|BetaOutputBehaviorUpdateExisting $outputBehavior;

    /**
     * The memory store that holds the dream's result, as a one-item array, or an empty array until the dream records that memory store.
     *
     * The array is empty while the dream is `pending` and for a short time after it starts `running`. It can stay empty if the dream fails or is canceled before then. The memory store holds the complete result only once `status` is `completed`.
     *
     * See the [Dreams guide](https://platform.claude.com/docs/en/managed-agents/dreams#use-the-output) for how to review and use the result.
     *
     * @var list<BetaDreamOutput> $outputs
     */
    #[Required(list: BetaDreamOutput::class)]
    public array $outputs;

    /**
     * The ID of the session that runs the dream (`sesn_...`), or `null` if that session hasn't started.
     *
     * Stream that session's events to follow what the dream reads and writes.
     *
     * See the [Dreams guide](https://platform.claude.com/docs/en/managed-agents/dreams#watch-the-pipeline-run) for how to watch a running dream.
     */
    #[Required('session_id')]
    public ?string $sessionID;

    /**
     * Lifecycle status of a Dream.
     *
     * @var value-of<BetaDreamStatus> $status
     */
    #[Required(enum: BetaDreamStatus::class)]
    public string $status;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * Cumulative token usage for the dream across every pipeline stage.
     */
    #[Required]
    public BetaDreamUsage $usage;

    /**
     * `new BetaDream()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaDream::with(
     *   id: ...,
     *   archivedAt: ...,
     *   createdAt: ...,
     *   endedAt: ...,
     *   error: ...,
     *   inputs: ...,
     *   instructions: ...,
     *   model: ...,
     *   outputBehavior: ...,
     *   outputs: ...,
     *   sessionID: ...,
     *   status: ...,
     *   type: ...,
     *   usage: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaDream)
     *   ->withID(...)
     *   ->withArchivedAt(...)
     *   ->withCreatedAt(...)
     *   ->withEndedAt(...)
     *   ->withError(...)
     *   ->withInputs(...)
     *   ->withInstructions(...)
     *   ->withModel(...)
     *   ->withOutputBehavior(...)
     *   ->withOutputs(...)
     *   ->withSessionID(...)
     *   ->withStatus(...)
     *   ->withType(...)
     *   ->withUsage(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param BetaDreamError|BetaDreamErrorShape|null $error
     * @param list<BetaDreamInputShape> $inputs
     * @param BetaDreamModelConfig|BetaDreamModelConfigShape $model
     * @param BetaOutputBehaviorShape $outputBehavior
     * @param list<BetaDreamOutput|BetaDreamOutputShape> $outputs
     * @param BetaDreamStatus|value-of<BetaDreamStatus> $status
     * @param Type|value-of<Type> $type
     * @param BetaDreamUsage|BetaDreamUsageShape $usage
     */
    public static function with(
        string $id,
        ?\DateTimeInterface $archivedAt,
        \DateTimeInterface $createdAt,
        ?\DateTimeInterface $endedAt,
        BetaDreamError|array|null $error,
        array $inputs,
        ?string $instructions,
        BetaDreamModelConfig|array $model,
        BetaOutputBehaviorCreateNew|array|BetaOutputBehaviorUpdateExisting $outputBehavior,
        array $outputs,
        ?string $sessionID,
        BetaDreamStatus|string $status,
        Type|string $type,
        BetaDreamUsage|array $usage,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['archivedAt'] = $archivedAt;
        $self['createdAt'] = $createdAt;
        $self['endedAt'] = $endedAt;
        $self['error'] = $error;
        $self['inputs'] = $inputs;
        $self['instructions'] = $instructions;
        $self['model'] = $model;
        $self['outputBehavior'] = $outputBehavior;
        $self['outputs'] = $outputs;
        $self['sessionID'] = $sessionID;
        $self['status'] = $status;
        $self['type'] = $type;
        $self['usage'] = $usage;

        return $self;
    }

    /**
     * The unique ID of the dream (`drm_...`).
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * A timestamp in RFC 3339 format.
     */
    public function withArchivedAt(?\DateTimeInterface $archivedAt): self
    {
        $self = clone $this;
        $self['archivedAt'] = $archivedAt;

        return $self;
    }

    /**
     * A timestamp in RFC 3339 format.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * A timestamp in RFC 3339 format.
     */
    public function withEndedAt(?\DateTimeInterface $endedAt): self
    {
        $self = clone $this;
        $self['endedAt'] = $endedAt;

        return $self;
    }

    /**
     * Failure detail for a Dream whose `status` is `failed`.
     *
     * @param BetaDreamError|BetaDreamErrorShape|null $error
     */
    public function withError(BetaDreamError|array|null $error): self
    {
        $self = clone $this;
        $self['error'] = $error;

        return $self;
    }

    /**
     * The sources that the dream reads, from the request that created it.
     *
     * @param list<BetaDreamInputShape> $inputs
     */
    public function withInputs(array $inputs): self
    {
        $self = clone $this;
        $self['inputs'] = $inputs;

        return $self;
    }

    /**
     * The guidance given when the dream was created, or `null` if none was given.
     */
    public function withInstructions(?string $instructions): self
    {
        $self = clone $this;
        $self['instructions'] = $instructions;

        return $self;
    }

    /**
     * Model identifier and configuration applied to every pipeline stage. Same wire shape as the Agents API ModelConfig.
     *
     * @param BetaDreamModelConfig|BetaDreamModelConfigShape $model
     */
    public function withModel(BetaDreamModelConfig|array $model): self
    {
        $self = clone $this;
        $self['model'] = $model;

        return $self;
    }

    /**
     * Which memory store a dream writes its result to. Defaults to `create_new` when left out of a create request.
     *
     * @param BetaOutputBehaviorShape $outputBehavior
     */
    public function withOutputBehavior(
        BetaOutputBehaviorCreateNew|array|BetaOutputBehaviorUpdateExisting $outputBehavior,
    ): self {
        $self = clone $this;
        $self['outputBehavior'] = $outputBehavior;

        return $self;
    }

    /**
     * The memory store that holds the dream's result, as a one-item array, or an empty array until the dream records that memory store.
     *
     * The array is empty while the dream is `pending` and for a short time after it starts `running`. It can stay empty if the dream fails or is canceled before then. The memory store holds the complete result only once `status` is `completed`.
     *
     * See the [Dreams guide](https://platform.claude.com/docs/en/managed-agents/dreams#use-the-output) for how to review and use the result.
     *
     * @param list<BetaDreamOutput|BetaDreamOutputShape> $outputs
     */
    public function withOutputs(array $outputs): self
    {
        $self = clone $this;
        $self['outputs'] = $outputs;

        return $self;
    }

    /**
     * The ID of the session that runs the dream (`sesn_...`), or `null` if that session hasn't started.
     *
     * Stream that session's events to follow what the dream reads and writes.
     *
     * See the [Dreams guide](https://platform.claude.com/docs/en/managed-agents/dreams#watch-the-pipeline-run) for how to watch a running dream.
     */
    public function withSessionID(?string $sessionID): self
    {
        $self = clone $this;
        $self['sessionID'] = $sessionID;

        return $self;
    }

    /**
     * Lifecycle status of a Dream.
     *
     * @param BetaDreamStatus|value-of<BetaDreamStatus> $status
     */
    public function withStatus(BetaDreamStatus|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Cumulative token usage for the dream across every pipeline stage.
     *
     * @param BetaDreamUsage|BetaDreamUsageShape $usage
     */
    public function withUsage(BetaDreamUsage|array $usage): self
    {
        $self = clone $this;
        $self['usage'] = $usage;

        return $self;
    }
}
