<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Emitted when an outcome evaluation cycle begins.
 *
 * @phpstan-type ManagedAgentsSpanOutcomeEvaluationStartEventShape = array{
 *   id: string,
 *   iteration: int,
 *   outcomeID: string,
 *   processedAt: \DateTimeInterface,
 *   type: 'span.outcome_evaluation_start',
 * }
 */
final class ManagedAgentsSpanOutcomeEvaluationStartEvent implements BaseModel
{
    /** @use SdkModel<ManagedAgentsSpanOutcomeEvaluationStartEventShape> */
    use SdkModel;

    /** @var 'span.outcome_evaluation_start' $type */
    #[Required(type: new ConstantOf('span.outcome_evaluation_start'))]
    public string $type = 'span.outcome_evaluation_start';

    /**
     * Unique identifier for this event.
     */
    #[Required]
    public string $id;

    /**
     * 0-indexed revision cycle. 0 is the first evaluation; 1 is the re-evaluation after the first revision; etc.
     */
    #[Required]
    public int $iteration;

    /**
     * The `outc_` ID of the outcome being evaluated.
     */
    #[Required('outcome_id')]
    public string $outcomeID;

    /**
     * Timestamp when outcome evaluation started.
     */
    #[Required('processed_at')]
    public \DateTimeInterface $processedAt;

    /**
     * `new ManagedAgentsSpanOutcomeEvaluationStartEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsSpanOutcomeEvaluationStartEvent::with(
     *   id: ..., iteration: ..., outcomeID: ..., processedAt: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsSpanOutcomeEvaluationStartEvent())
     *   ->withID(...)
     *   ->withIteration(...)
     *   ->withOutcomeID(...)
     *   ->withProcessedAt(...)
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
     */
    public static function with(
        string $id,
        int $iteration,
        string $outcomeID,
        \DateTimeInterface $processedAt,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['iteration'] = $iteration;
        $self['outcomeID'] = $outcomeID;
        $self['processedAt'] = $processedAt;

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
     * 0-indexed revision cycle. 0 is the first evaluation; 1 is the re-evaluation after the first revision; etc.
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
     * Timestamp when outcome evaluation started.
     */
    public function withProcessedAt(\DateTimeInterface $processedAt): self
    {
        $self = clone $this;
        $self['processedAt'] = $processedAt;

        return $self;
    }

    /**
     * @param 'span.outcome_evaluation_start' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
