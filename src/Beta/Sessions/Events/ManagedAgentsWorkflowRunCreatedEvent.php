<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A workflow run was created. A workflow run is background work that the session's agent starts. Emitted once per run, before the run's other `workflow_run.*` events.
 *
 * @phpstan-import-type ManagedAgentsWorkflowRunPhaseShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsWorkflowRunPhase
 *
 * @phpstan-type ManagedAgentsWorkflowRunCreatedEventShape = array{
 *   id: string,
 *   description: string|null,
 *   name: string,
 *   phases: list<ManagedAgentsWorkflowRunPhase|ManagedAgentsWorkflowRunPhaseShape>,
 *   processedAt: \DateTimeInterface,
 *   type: 'workflow_run.created',
 *   workflowRunID: string,
 * }
 */
final class ManagedAgentsWorkflowRunCreatedEvent implements BaseModel
{
    /** @use SdkModel<ManagedAgentsWorkflowRunCreatedEventShape> */
    use SdkModel;

    /** @var 'workflow_run.created' $type */
    #[Required(type: new ConstantOf('workflow_run.created'))]
    public string $type = 'workflow_run.created';

    /**
     * Unique identifier for this event.
     */
    #[Required]
    public string $id;

    /**
     * Description that the agent gave the run, passed on as written, or `null` if it gave none.
     */
    #[Required]
    public ?string $description;

    /**
     * Name that the agent gave the run, passed on as written, or a name that the server assigned.
     */
    #[Required]
    public string $name;

    /**
     * The phases that the run's plan declares, in the plan's order. Can be empty.
     *
     * @var list<ManagedAgentsWorkflowRunPhase> $phases
     */
    #[Required(list: ManagedAgentsWorkflowRunPhase::class)]
    public array $phases;

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
     * `new ManagedAgentsWorkflowRunCreatedEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsWorkflowRunCreatedEvent::with(
     *   id: ...,
     *   description: ...,
     *   name: ...,
     *   phases: ...,
     *   processedAt: ...,
     *   workflowRunID: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsWorkflowRunCreatedEvent())
     *   ->withID(...)
     *   ->withDescription(...)
     *   ->withName(...)
     *   ->withPhases(...)
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
     *
     * @param list<ManagedAgentsWorkflowRunPhase|ManagedAgentsWorkflowRunPhaseShape> $phases
     */
    public static function with(
        string $id,
        ?string $description,
        string $name,
        array $phases,
        \DateTimeInterface $processedAt,
        string $workflowRunID,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['description'] = $description;
        $self['name'] = $name;
        $self['phases'] = $phases;
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
     * Description that the agent gave the run, passed on as written, or `null` if it gave none.
     */
    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Name that the agent gave the run, passed on as written, or a name that the server assigned.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * The phases that the run's plan declares, in the plan's order. Can be empty.
     *
     * @param list<ManagedAgentsWorkflowRunPhase|ManagedAgentsWorkflowRunPhaseShape> $phases
     */
    public function withPhases(array $phases): self
    {
        $self = clone $this;
        $self['phases'] = $phases;

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
     * @param 'workflow_run.created' $type
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
