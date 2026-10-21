<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsUserDefineOutcomeEvent\Rubric;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Echo of a `user.define_outcome` input event. Carries the server-generated `outcome_id` that subsequent `span.outcome_evaluation_*` events reference.
 *
 * @phpstan-import-type RubricShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserDefineOutcomeEvent\Rubric
 * @phpstan-import-type RubricVariants from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserDefineOutcomeEvent\Rubric
 *
 * @phpstan-type ManagedAgentsUserDefineOutcomeEventShape = array{
 *   id: string,
 *   description: string,
 *   maxIterations: int|null,
 *   outcomeID: string,
 *   processedAt: \DateTimeInterface,
 *   rubric: RubricShape,
 *   type: 'user.define_outcome',
 * }
 */
final class ManagedAgentsUserDefineOutcomeEvent implements BaseModel
{
    /** @use SdkModel<ManagedAgentsUserDefineOutcomeEventShape> */
    use SdkModel;

    /** @var 'user.define_outcome' $type */
    #[Required(type: new ConstantOf('user.define_outcome'))]
    public string $type = 'user.define_outcome';

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
     * Timestamp when the outcome was accepted.
     */
    #[Required('processed_at')]
    public \DateTimeInterface $processedAt;

    /**
     * How to grade the outcome. File rubrics are currently resolved to their text content; clients should handle both variants.
     *
     * @var RubricVariants $rubric
     */
    #[Required(union: Rubric::class)]
    public ManagedAgentsFileRubric|ManagedAgentsTextRubric $rubric;

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
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsUserDefineOutcomeEvent())
     *   ->withID(...)
     *   ->withDescription(...)
     *   ->withMaxIterations(...)
     *   ->withOutcomeID(...)
     *   ->withProcessedAt(...)
     *   ->withRubric(...)
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
     */
    public static function with(
        string $id,
        string $description,
        ?int $maxIterations,
        string $outcomeID,
        \DateTimeInterface $processedAt,
        ManagedAgentsFileRubric|array|ManagedAgentsTextRubric $rubric,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['description'] = $description;
        $self['maxIterations'] = $maxIterations;
        $self['outcomeID'] = $outcomeID;
        $self['processedAt'] = $processedAt;
        $self['rubric'] = $rubric;

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
     * Timestamp when the outcome was accepted.
     */
    public function withProcessedAt(\DateTimeInterface $processedAt): self
    {
        $self = clone $this;
        $self['processedAt'] = $processedAt;

        return $self;
    }

    /**
     * How to grade the outcome. File rubrics are currently resolved to their text content; clients should handle both variants.
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
     * @param 'user.define_outcome' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
