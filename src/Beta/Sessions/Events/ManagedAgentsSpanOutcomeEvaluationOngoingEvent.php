<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsSpanOutcomeEvaluationOngoingEvent\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Periodic heartbeat emitted while an outcome evaluation cycle is in progress. Distinguishes 'evaluation is actively running' from 'evaluation is stuck' between the corresponding `span.outcome_evaluation_start` and `span.outcome_evaluation_end` events.
 *
 * @phpstan-type ManagedAgentsSpanOutcomeEvaluationOngoingEventShape = array{
 *   id: string,
 *   iteration: int,
 *   outcomeID: string,
 *   processedAt: \DateTimeInterface,
 *   type: Type|value-of<Type>,
 * }
 */
final class ManagedAgentsSpanOutcomeEvaluationOngoingEvent implements BaseModel
{
    /** @use SdkModel<ManagedAgentsSpanOutcomeEvaluationOngoingEventShape> */
    use SdkModel;

    /**
     * Unique identifier for this event.
     */
    #[Required]
    public string $id;

    /**
     * 0-indexed revision cycle, matching the corresponding `span.outcome_evaluation_start`.
     */
    #[Required]
    public int $iteration;

    /**
     * The `outc_` ID of the outcome being evaluated.
     */
    #[Required('outcome_id')]
    public string $outcomeID;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('processed_at')]
    public \DateTimeInterface $processedAt;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new ManagedAgentsSpanOutcomeEvaluationOngoingEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsSpanOutcomeEvaluationOngoingEvent::with(
     *   id: ..., iteration: ..., outcomeID: ..., processedAt: ..., type: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsSpanOutcomeEvaluationOngoingEvent)
     *   ->withID(...)
     *   ->withIteration(...)
     *   ->withOutcomeID(...)
     *   ->withProcessedAt(...)
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
     * @param Type|value-of<Type> $type
     */
    public static function with(
        string $id,
        int $iteration,
        string $outcomeID,
        \DateTimeInterface $processedAt,
        Type|string $type,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['iteration'] = $iteration;
        $self['outcomeID'] = $outcomeID;
        $self['processedAt'] = $processedAt;
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
     * 0-indexed revision cycle, matching the corresponding `span.outcome_evaluation_start`.
     */
    public function withIteration(int $iteration): self
    {
        $self = clone $this;
        $self['iteration'] = $iteration;

        return $self;
    }

    /**
     * The `outc_` ID of the outcome being evaluated.
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
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
