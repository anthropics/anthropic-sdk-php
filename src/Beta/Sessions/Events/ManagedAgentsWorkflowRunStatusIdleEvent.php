<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A workflow run is idle. Emitted each time the run goes idle, whatever the cause. If the run ends while idle, no `workflow_run.status_running` comes between this event and its `workflow_run.status_ended`.
 *
 * @phpstan-type ManagedAgentsWorkflowRunStatusIdleEventShape = array{
 *   id: string,
 *   processedAt: \DateTimeInterface,
 *   type: 'workflow_run.status_idle',
 *   workflowRunID: string,
 * }
 */
final class ManagedAgentsWorkflowRunStatusIdleEvent implements BaseModel
{
    /** @use SdkModel<ManagedAgentsWorkflowRunStatusIdleEventShape> */
    use SdkModel;

    /** @var 'workflow_run.status_idle' $type */
    #[Required(type: new ConstantOf('workflow_run.status_idle'))]
    public string $type = 'workflow_run.status_idle';

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
     * `new ManagedAgentsWorkflowRunStatusIdleEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsWorkflowRunStatusIdleEvent::with(
     *   id: ..., processedAt: ..., workflowRunID: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsWorkflowRunStatusIdleEvent())
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
     * @param 'workflow_run.status_idle' $type
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
