<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsUserDefineOutcomeEvent\Rubric;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUserDefineOutcomeEvent\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Echo of a `user.define_outcome` input event. Carries the server-generated `outcome_id` that subsequent `span.outcome_evaluation_*` events reference.
 *
 * @phpstan-import-type RubricVariants from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserDefineOutcomeEvent\Rubric
 * @phpstan-import-type RubricShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserDefineOutcomeEvent\Rubric
 *
 * @phpstan-type ManagedAgentsUserDefineOutcomeEventShape = array{
 *   id: string,
 *   description: string,
 *   maxIterations: int|null,
 *   outcomeID: string,
 *   processedAt: \DateTimeInterface,
 *   rubric: RubricShape,
 *   type: Type|value-of<Type>,
 * }
 */
final class ManagedAgentsUserDefineOutcomeEvent implements BaseModel
{
    /** @use SdkModel<ManagedAgentsUserDefineOutcomeEventShape> */
    use SdkModel;

    /**
     * Unique identifier for this event.
     */
    #[Required]
    public string $id;

    /**
     * What the agent should produce. Copied from the input event.
     */
    #[Required]
    public string $description;

    /**
     * Evaluate-then-revise cycles before giving up. Default 3, max 20.
     */
    #[Required('max_iterations')]
    public ?int $maxIterations;

    /**
     * Server-generated `outc_` ID for this outcome. Referenced by `span.outcome_evaluation_*` events and the session's `outcome_evaluations` list.
     */
    #[Required('outcome_id')]
    public string $outcomeID;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('processed_at')]
    public \DateTimeInterface $processedAt;

    /**
     * Rubric for grading the quality of an outcome.
     *
     * @var RubricVariants $rubric
     */
    #[Required(union: Rubric::class)]
    public ManagedAgentsFileRubric|ManagedAgentsTextRubric $rubric;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new ManagedAgentsUserDefineOutcomeEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsUserDefineOutcomeEvent::with(
     *   id: ...,
     *   description: ...,
     *   maxIterations: ...,
     *   outcomeID: ...,
     *   processedAt: ...,
     *   rubric: ...,
     *   type: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsUserDefineOutcomeEvent)
     *   ->withID(...)
     *   ->withDescription(...)
     *   ->withMaxIterations(...)
     *   ->withOutcomeID(...)
     *   ->withProcessedAt(...)
     *   ->withRubric(...)
     *   ->withType(...)
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
     * @param RubricShape $rubric
     * @param Type|value-of<Type> $type
     */
    public static function with(
        string $id,
        string $description,
        ?int $maxIterations,
        string $outcomeID,
        \DateTimeInterface $processedAt,
        ManagedAgentsFileRubric|array|ManagedAgentsTextRubric $rubric,
        Type|string $type,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['description'] = $description;
        $self['maxIterations'] = $maxIterations;
        $self['outcomeID'] = $outcomeID;
        $self['processedAt'] = $processedAt;
        $self['rubric'] = $rubric;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Unique identifier for this event.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * What the agent should produce. Copied from the input event.
     */
    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Evaluate-then-revise cycles before giving up. Default 3, max 20.
     */
    public function withMaxIterations(?int $maxIterations): self
    {
        $self = clone $this;
        $self['maxIterations'] = $maxIterations;

        return $self;
    }

    /**
     * Server-generated `outc_` ID for this outcome. Referenced by `span.outcome_evaluation_*` events and the session's `outcome_evaluations` list.
     */
    public function withOutcomeID(string $outcomeID): self
    {
        $self = clone $this;
        $self['outcomeID'] = $outcomeID;

        return $self;
    }

    /**
     * A timestamp in RFC 3339 format.
     */
    public function withProcessedAt(\DateTimeInterface $processedAt): self
    {
        $self = clone $this;
        $self['processedAt'] = $processedAt;

        return $self;
    }

    /**
     * Rubric for grading the quality of an outcome.
     *
     * @param RubricShape $rubric
     */
    public function withRubric(
        ManagedAgentsFileRubric|array|ManagedAgentsTextRubric $rubric
    ): self {
        $self = clone $this;
        $self['rubric'] = $rubric;

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
}
