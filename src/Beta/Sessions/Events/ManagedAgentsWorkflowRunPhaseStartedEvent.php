<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A workflow run's plan entered a phase.
 *
 * @phpstan-type ManagedAgentsWorkflowRunPhaseStartedEventShape = array{
 *   id: string,
 *   processedAt: \DateTimeInterface,
 *   type: 'workflow_run.phase_started',
 *   workflowRunID: string,
 *   workflowRunPhaseID: string,
 * }
 */
final class ManagedAgentsWorkflowRunPhaseStartedEvent implements BaseModel
{
    /** @use SdkModel<ManagedAgentsWorkflowRunPhaseStartedEventShape> */
    use SdkModel;

    /** @var 'workflow_run.phase_started' $type */
    #[Required(type: new ConstantOf('workflow_run.phase_started'))]
    public string $type = 'workflow_run.phase_started';

    /**
     * Unique identifier for this event.
     */
    #[Required]
    public string $id;

    /**
     * Timestamp when this event was processed.
     */
    #[Required('processed_at')]
    public \DateTimeInterface $processedAt;

    /**
     * Identifier of the run. The same value is on all of the run's `workflow_run.*` events.
     */
    #[Required('workflow_run_id')]
    public string $workflowRunID;

    /**
     * Identifier of the phase, as in `phases` on the run's `workflow_run.created` event.
     */
    #[Required('workflow_run_phase_id')]
    public string $workflowRunPhaseID;

    /**
     * `new ManagedAgentsWorkflowRunPhaseStartedEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsWorkflowRunPhaseStartedEvent::with(
     *   id: ..., processedAt: ..., workflowRunID: ..., workflowRunPhaseID: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsWorkflowRunPhaseStartedEvent())
     *   ->withID(...)
     *   ->withProcessedAt(...)
     *   ->withWorkflowRunID(...)
     *   ->withWorkflowRunPhaseID(...)
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
        \DateTimeInterface $processedAt,
        string $workflowRunID,
        string $workflowRunPhaseID,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['processedAt'] = $processedAt;
        $self['workflowRunID'] = $workflowRunID;
        $self['workflowRunPhaseID'] = $workflowRunPhaseID;

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
     * Timestamp when this event was processed.
     */
    public function withProcessedAt(\DateTimeInterface $processedAt): self
    {
        $self = clone $this;
        $self['processedAt'] = $processedAt;

        return $self;
    }

    /**
     * @param 'workflow_run.phase_started' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Identifier of the run. The same value is on all of the run's `workflow_run.*` events.
     */
    public function withWorkflowRunID(string $workflowRunID): self
    {
        $self = clone $this;
        $self['workflowRunID'] = $workflowRunID;

        return $self;
    }

    /**
     * Identifier of the phase, as in `phases` on the run's `workflow_run.created` event.
     */
    public function withWorkflowRunPhaseID(string $workflowRunPhaseID): self
    {
        $self = clone $this;
        $self['workflowRunPhaseID'] = $workflowRunPhaseID;

        return $self;
    }
}
