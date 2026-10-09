<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A workflow run is running. Emitted when the run starts to execute, and each time it resumes after being idle. A run that starts idle emits `workflow_run.status_idle` first.
 *
 * @phpstan-type ManagedAgentsWorkflowRunStatusRunningEventShape = array{
 *   id: string,
 *   processedAt: \DateTimeInterface,
 *   type: 'workflow_run.status_running',
 *   workflowRunID: string,
 * }
 */
final class ManagedAgentsWorkflowRunStatusRunningEvent implements BaseModel
{
    /** @use SdkModel<ManagedAgentsWorkflowRunStatusRunningEventShape> */
    use SdkModel;

    /** @var 'workflow_run.status_running' $type */
    #[Required(type: new ConstantOf('workflow_run.status_running'))]
    public string $type = 'workflow_run.status_running';

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
     * `new ManagedAgentsWorkflowRunStatusRunningEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsWorkflowRunStatusRunningEvent::with(
     *   id: ..., processedAt: ..., workflowRunID: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsWorkflowRunStatusRunningEvent())
     *   ->withID(...)
     *   ->withProcessedAt(...)
     *   ->withWorkflowRunID(...)
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
        string $workflowRunID
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['processedAt'] = $processedAt;
        $self['workflowRunID'] = $workflowRunID;

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
     * @param 'workflow_run.status_running' $type
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
}
