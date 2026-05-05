<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Beta\Sessions\BetaManagedAgentsOutcomeEvaluationResource\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Evaluation state for a single outcome defined via a define_outcome event.
 *
 * @phpstan-type BetaManagedAgentsOutcomeEvaluationResourceShape = array{
 *   completedAt: \DateTimeInterface|null,
 *   description: string,
 *   explanation: string|null,
 *   iteration: int,
 *   outcomeID: string,
 *   result: string,
 *   type: Type|value-of<Type>,
 * }
 */
final class BetaManagedAgentsOutcomeEvaluationResource implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsOutcomeEvaluationResourceShape> */
    use SdkModel;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('completed_at')]
    public ?\DateTimeInterface $completedAt;

    /**
     * What the agent should produce.
     */
    #[Required]
    public string $description;

    /**
     * Grader's verdict text from the most recent evaluation. For satisfied, explains why criteria are met; for needs_revision (intermediate), what's missing; for failed, why unrecoverable.
     */
    #[Required]
    public ?string $explanation;

    /**
     * 0-indexed revision cycle the outcome is currently on.
     */
    #[Required]
    public int $iteration;

    /**
     * Server-generated outc_ ID for this outcome.
     */
    #[Required('outcome_id')]
    public string $outcomeID;

    /**
     * Current evaluation state. 'pending' before the agent begins work; 'running' while producing or revising; 'evaluating' while the grader scores; 'satisfied'/'max_iterations_reached'/'failed'/'interrupted' are terminal.
     */
    #[Required]
    public string $result;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new BetaManagedAgentsOutcomeEvaluationResource()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsOutcomeEvaluationResource::with(
     *   completedAt: ...,
     *   description: ...,
     *   explanation: ...,
     *   iteration: ...,
     *   outcomeID: ...,
     *   result: ...,
     *   type: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsOutcomeEvaluationResource)
     *   ->withCompletedAt(...)
     *   ->withDescription(...)
     *   ->withExplanation(...)
     *   ->withIteration(...)
     *   ->withOutcomeID(...)
     *   ->withResult(...)
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
        ?\DateTimeInterface $completedAt,
        string $description,
        ?string $explanation,
        int $iteration,
        string $outcomeID,
        string $result,
        Type|string $type,
    ): self {
        $self = new self;

        $self['completedAt'] = $completedAt;
        $self['description'] = $description;
        $self['explanation'] = $explanation;
        $self['iteration'] = $iteration;
        $self['outcomeID'] = $outcomeID;
        $self['result'] = $result;
        $self['type'] = $type;

        return $self;
    }

    /**
     * A timestamp in RFC 3339 format.
     */
    public function withCompletedAt(?\DateTimeInterface $completedAt): self
    {
        $self = clone $this;
        $self['completedAt'] = $completedAt;

        return $self;
    }

    /**
     * What the agent should produce.
     */
    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Grader's verdict text from the most recent evaluation. For satisfied, explains why criteria are met; for needs_revision (intermediate), what's missing; for failed, why unrecoverable.
     */
    public function withExplanation(?string $explanation): self
    {
        $self = clone $this;
        $self['explanation'] = $explanation;

        return $self;
    }

    /**
     * 0-indexed revision cycle the outcome is currently on.
     */
    public function withIteration(int $iteration): self
    {
        $self = clone $this;
        $self['iteration'] = $iteration;

        return $self;
    }

    /**
     * Server-generated outc_ ID for this outcome.
     */
    public function withOutcomeID(string $outcomeID): self
    {
        $self = clone $this;
        $self['outcomeID'] = $outcomeID;

        return $self;
    }

    /**
     * Current evaluation state. 'pending' before the agent begins work; 'running' while producing or revising; 'evaluating' while the grader scores; 'satisfied'/'max_iterations_reached'/'failed'/'interrupted' are terminal.
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
}
