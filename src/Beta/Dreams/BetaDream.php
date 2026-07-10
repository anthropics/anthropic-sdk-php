<?php

declare(strict_types=1);

namespace Anthropic\Beta\Dreams;

use Anthropic\Beta\Dreams\BetaDream\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * An asynchronous memory-consolidation job that reads a memory store plus a set of session transcripts and writes consolidated memories into a new output memory store. The Dreams API is in research preview: the request and response shapes are volatile and may change without the deprecation period that applies to generally-available endpoints.
 *
 * @phpstan-import-type BetaDreamInputVariants from \Anthropic\Beta\Dreams\BetaDreamInput
 * @phpstan-import-type BetaDreamErrorShape from \Anthropic\Beta\Dreams\BetaDreamError
 * @phpstan-import-type BetaDreamInputShape from \Anthropic\Beta\Dreams\BetaDreamInput
 * @phpstan-import-type BetaDreamModelConfigShape from \Anthropic\Beta\Dreams\BetaDreamModelConfig
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

    /** @var list<BetaDreamInputVariants> $inputs */
    #[Required(list: BetaDreamInput::class)]
    public array $inputs;

    #[Required]
    public ?string $instructions;

    /**
     * Model identifier and configuration applied to every pipeline stage. Same wire shape as the Agents API ModelConfig.
     */
    #[Required]
    public BetaDreamModelConfig $model;

    /** @var list<BetaDreamOutput> $outputs */
    #[Required(list: BetaDreamOutput::class)]
    public array $outputs;

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
        $self['outputs'] = $outputs;
        $self['sessionID'] = $sessionID;
        $self['status'] = $status;
        $self['type'] = $type;
        $self['usage'] = $usage;

        return $self;
    }

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
     * @param list<BetaDreamInputShape> $inputs
     */
    public function withInputs(array $inputs): self
    {
        $self = clone $this;
        $self['inputs'] = $inputs;

        return $self;
    }

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
     * @param list<BetaDreamOutput|BetaDreamOutputShape> $outputs
     */
    public function withOutputs(array $outputs): self
    {
        $self = clone $this;
        $self['outputs'] = $outputs;

        return $self;
    }

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
