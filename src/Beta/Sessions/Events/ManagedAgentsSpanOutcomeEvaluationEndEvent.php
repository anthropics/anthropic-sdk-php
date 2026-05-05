<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsSpanOutcomeEvaluationEndEvent\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Emitted when an outcome evaluation cycle completes. Carries the verdict and aggregate token usage. A verdict of `needs_revision` means another evaluation cycle follows; `satisfied`, `max_iterations_reached`, `failed`, or `interrupted` are terminal — no further evaluation cycles follow.
 *
 * @phpstan-import-type ManagedAgentsSpanModelUsageShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSpanModelUsage
 *
 * @phpstan-type ManagedAgentsSpanOutcomeEvaluationEndEventShape = array{
 *   id: string,
 *   explanation: string,
 *   iteration: int,
 *   outcomeEvaluationStartID: string,
 *   outcomeID: string,
 *   processedAt: \DateTimeInterface,
 *   result: string,
 *   type: Type|value-of<Type>,
 *   usage: ManagedAgentsSpanModelUsage|ManagedAgentsSpanModelUsageShape,
 * }
 */
final class ManagedAgentsSpanOutcomeEvaluationEndEvent implements BaseModel
{
    /** @use SdkModel<ManagedAgentsSpanOutcomeEvaluationEndEventShape> */
    use SdkModel;

    /**
     * Unique identifier for this event.
     */
    #[Required]
    public string $id;

    /**
     * Human-readable explanation of the verdict. For `needs_revision`, describes which criteria failed and why.
     */
    #[Required]
    public string $explanation;

    /**
     * 0-indexed revision cycle, matching the corresponding `span.outcome_evaluation_start`.
     */
    #[Required]
    public int $iteration;

    /**
     * The id of the corresponding `span.outcome_evaluation_start` event.
     */
    #[Required('outcome_evaluation_start_id')]
    public string $outcomeEvaluationStartID;

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

    /**
     * Evaluation verdict. 'satisfied': criteria met, session goes idle. 'needs_revision': criteria not met, another revision cycle follows. 'max_iterations_reached': evaluation budget exhausted with criteria still unmet — one final acknowledgment turn follows before the session goes idle, but no further evaluation runs. 'failed': grader determined the rubric does not apply to the deliverables. 'interrupted': user sent an interrupt while evaluation was in progress.
     */
    #[Required]
    public string $result;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * Token usage for a single model request.
     */
    #[Required]
    public ManagedAgentsSpanModelUsage $usage;

    /**
     * `new ManagedAgentsSpanOutcomeEvaluationEndEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsSpanOutcomeEvaluationEndEvent::with(
     *   id: ...,
     *   explanation: ...,
     *   iteration: ...,
     *   outcomeEvaluationStartID: ...,
     *   outcomeID: ...,
     *   processedAt: ...,
     *   result: ...,
     *   type: ...,
     *   usage: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsSpanOutcomeEvaluationEndEvent)
     *   ->withID(...)
     *   ->withExplanation(...)
     *   ->withIteration(...)
     *   ->withOutcomeEvaluationStartID(...)
     *   ->withOutcomeID(...)
     *   ->withProcessedAt(...)
     *   ->withResult(...)
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
     * @param Type|value-of<Type> $type
     * @param ManagedAgentsSpanModelUsage|ManagedAgentsSpanModelUsageShape $usage
     */
    public static function with(
        string $id,
        string $explanation,
        int $iteration,
        string $outcomeEvaluationStartID,
        string $outcomeID,
        \DateTimeInterface $processedAt,
        string $result,
        Type|string $type,
        ManagedAgentsSpanModelUsage|array $usage,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['explanation'] = $explanation;
        $self['iteration'] = $iteration;
        $self['outcomeEvaluationStartID'] = $outcomeEvaluationStartID;
        $self['outcomeID'] = $outcomeID;
        $self['processedAt'] = $processedAt;
        $self['result'] = $result;
        $self['type'] = $type;
        $self['usage'] = $usage;

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
     * Human-readable explanation of the verdict. For `needs_revision`, describes which criteria failed and why.
     */
    public function withExplanation(string $explanation): self
    {
        $self = clone $this;
        $self['explanation'] = $explanation;

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
     * The id of the corresponding `span.outcome_evaluation_start` event.
     */
    public function withOutcomeEvaluationStartID(
        string $outcomeEvaluationStartID
    ): self {
        $self = clone $this;
        $self['outcomeEvaluationStartID'] = $outcomeEvaluationStartID;

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
     * Evaluation verdict. 'satisfied': criteria met, session goes idle. 'needs_revision': criteria not met, another revision cycle follows. 'max_iterations_reached': evaluation budget exhausted with criteria still unmet — one final acknowledgment turn follows before the session goes idle, but no further evaluation runs. 'failed': grader determined the rubric does not apply to the deliverables. 'interrupted': user sent an interrupt while evaluation was in progress.
     */
    public function withResult(string $result): self
    {
        $self = clone $this;
        $self['result'] = $result;

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
     * Token usage for a single model request.
     *
     * @param ManagedAgentsSpanModelUsage|ManagedAgentsSpanModelUsageShape $usage
     */
    public function withUsage(ManagedAgentsSpanModelUsage|array $usage): self
    {
        $self = clone $this;
        $self['usage'] = $usage;

        return $self;
    }
}
