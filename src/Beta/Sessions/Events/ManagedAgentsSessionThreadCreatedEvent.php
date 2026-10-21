<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Emitted when a child thread is created. Written to the parent thread's output stream so clients observing the session see child creation.
 *
 * @phpstan-type ManagedAgentsSessionThreadCreatedEventShape = array{
 *   id: string,
 *   agentName: string,
 *   processedAt: \DateTimeInterface,
 *   sessionThreadID: string,
 *   type: 'session.thread_created',
 *   workflowRunID: string|null,
 * }
 */
final class ManagedAgentsSessionThreadCreatedEvent implements BaseModel
{
    /** @use SdkModel<ManagedAgentsSessionThreadCreatedEventShape> */
    use SdkModel;

    /** @var 'session.thread_created' $type */
    #[Required(type: new ConstantOf('session.thread_created'))]
    public string $type = 'session.thread_created';

    /**
     * Unique identifier for this event.
     */
    #[Required]
    public string $id;

    /**
     * Name of the callable agent the thread runs.
     */
    #[Required('agent_name')]
    public string $agentName;

    /**
     * Timestamp when the thread was created.
     */
    #[Required('processed_at')]
    public \DateTimeInterface $processedAt;

    /**
     * Public `sthr_` ID of the newly created thread.
     */
    #[Required('session_thread_id')]
    public string $sessionThreadID;

    /**
     * Identifier of the workflow run that created the thread, or `null` for any other thread.
     */
    #[Required('workflow_run_id')]
    public ?string $workflowRunID;

    /**
     * `new ManagedAgentsSessionThreadCreatedEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsSessionThreadCreatedEvent::with(
     *   id: ...,
     *   agentName: ...,
     *   processedAt: ...,
     *   sessionThreadID: ...,
     *   workflowRunID: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsSessionThreadCreatedEvent())
     *   ->withID(...)
     *   ->withAgentName(...)
     *   ->withProcessedAt(...)
     *   ->withSessionThreadID(...)
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
        string $agentName,
        \DateTimeInterface $processedAt,
        string $sessionThreadID,
        ?string $workflowRunID,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['agentName'] = $agentName;
        $self['processedAt'] = $processedAt;
        $self['sessionThreadID'] = $sessionThreadID;
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
     * Name of the callable agent the thread runs.
     */
    public function withAgentName(string $agentName): self
    {
        $self = clone $this;
        $self['agentName'] = $agentName;

        return $self;
    }

    /**
     * Timestamp when the thread was created.
     */
    public function withProcessedAt(\DateTimeInterface $processedAt): self
    {
        $self = clone $this;
        $self['processedAt'] = $processedAt;

        return $self;
    }

    /**
     * Public `sthr_` ID of the newly created thread.
     */
    public function withSessionThreadID(string $sessionThreadID): self
    {
        $self = clone $this;
        $self['sessionThreadID'] = $sessionThreadID;

        return $self;
    }

    /**
     * @param 'session.thread_created' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Identifier of the workflow run that created the thread, or `null` for any other thread.
     */
    public function withWorkflowRunID(?string $workflowRunID): self
    {
        $self = clone $this;
        $self['workflowRunID'] = $workflowRunID;

        return $self;
    }
}
