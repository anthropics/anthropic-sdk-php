<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A workflow run ended. Emitted once per run, as the last of the run's `workflow_run.*` events.
 *
 * @phpstan-import-type ManagedAgentsWorkflowRunResultShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsWorkflowRunResult
 * @phpstan-import-type ManagedAgentsWorkflowRunResultVariants from \Anthropic\Beta\Sessions\Events\ManagedAgentsWorkflowRunResult
 *
 * @phpstan-type ManagedAgentsWorkflowRunStatusEndedEventShape = array{
 *   id: string,
 *   processedAt: \DateTimeInterface,
 *   result: ManagedAgentsWorkflowRunResultShape,
 *   type: 'workflow_run.status_ended',
 *   workflowRunID: string,
 * }
 */
final class ManagedAgentsWorkflowRunStatusEndedEvent implements BaseModel
{
    /** @use SdkModel<ManagedAgentsWorkflowRunStatusEndedEventShape> */
    use SdkModel;

    /** @var 'workflow_run.status_ended' $type */
    #[Required(type: new ConstantOf('workflow_run.status_ended'))]
    public string $type = 'workflow_run.status_ended';

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
     * How the run ended.
     *
     * @var ManagedAgentsWorkflowRunResultVariants $result
     */
    #[Required(union: ManagedAgentsWorkflowRunResult::class)]
    public ManagedAgentsWorkflowRunResultCompleted|ManagedAgentsWorkflowRunResultError|ManagedAgentsWorkflowRunResultStopped $result;

    /**
     * Identifier of the run. The same value is on all of the run's `workflow_run.*` events.
     */
    #[Required('workflow_run_id')]
    public string $workflowRunID;

    /**
     * `new ManagedAgentsWorkflowRunStatusEndedEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsWorkflowRunStatusEndedEvent::with(
     *   id: ..., processedAt: ..., result: ..., workflowRunID: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsWorkflowRunStatusEndedEvent())
     *   ->withID(...)
     *   ->withProcessedAt(...)
     *   ->withResult(...)
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
     *
     * @param ManagedAgentsWorkflowRunResultShape $result
     */
    public static function with(
        string $id,
        \DateTimeInterface $processedAt,
        ManagedAgentsWorkflowRunResultCompleted|array|ManagedAgentsWorkflowRunResultError|ManagedAgentsWorkflowRunResultStopped $result,
        string $workflowRunID,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['processedAt'] = $processedAt;
        $self['result'] = $result;
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
     * How the run ended.
     *
     * @param ManagedAgentsWorkflowRunResultShape $result
     */
    public function withResult(
        ManagedAgentsWorkflowRunResultCompleted|array|ManagedAgentsWorkflowRunResultError|ManagedAgentsWorkflowRunResultStopped $result,
    ): self {
        $self = clone $this;
        $self['result'] = $result;

        return $self;
    }

    /**
     * @param 'workflow_run.status_ended' $type
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
