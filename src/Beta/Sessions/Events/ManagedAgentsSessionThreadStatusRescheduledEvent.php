<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A session thread hit a transient error and is retrying automatically. Emitted on the thread's own stream and cross-posted to the primary stream for child threads.
 *
 * @phpstan-type ManagedAgentsSessionThreadStatusRescheduledEventShape = array{
 *   id: string,
 *   agentName: string,
 *   processedAt: \DateTimeInterface,
 *   sessionThreadID: string,
 *   type: 'session.thread_status_rescheduled',
 * }
 */
final class ManagedAgentsSessionThreadStatusRescheduledEvent implements BaseModel
{
    /** @use SdkModel<ManagedAgentsSessionThreadStatusRescheduledEventShape> */
    use SdkModel;

    /** @var 'session.thread_status_rescheduled' $type */
    #[Required(type: new ConstantOf('session.thread_status_rescheduled'))]
    public string $type = 'session.thread_status_rescheduled';

    /**
     * Unique identifier for this event.
     */
    #[Required]
    public string $id;

    /**
     * Name of the agent the thread runs.
     */
    #[Required('agent_name')]
    public string $agentName;

    /**
     * Timestamp of the status transition.
     */
    #[Required('processed_at')]
    public \DateTimeInterface $processedAt;

    /**
     * Public sthr_ ID of the thread that is retrying.
     */
    #[Required('session_thread_id')]
    public string $sessionThreadID;

    /**
     * `new ManagedAgentsSessionThreadStatusRescheduledEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsSessionThreadStatusRescheduledEvent::with(
     *   id: ..., agentName: ..., processedAt: ..., sessionThreadID: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsSessionThreadStatusRescheduledEvent())
     *   ->withID(...)
     *   ->withAgentName(...)
     *   ->withProcessedAt(...)
     *   ->withSessionThreadID(...)
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
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['agentName'] = $agentName;
        $self['processedAt'] = $processedAt;
        $self['sessionThreadID'] = $sessionThreadID;

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
     * Name of the agent the thread runs.
     */
    public function withAgentName(string $agentName): self
    {
        $self = clone $this;
        $self['agentName'] = $agentName;

        return $self;
    }

    /**
     * Timestamp of the status transition.
     */
    public function withProcessedAt(\DateTimeInterface $processedAt): self
    {
        $self = clone $this;
        $self['processedAt'] = $processedAt;

        return $self;
    }

    /**
     * Public sthr_ ID of the thread that is retrying.
     */
    public function withSessionThreadID(string $sessionThreadID): self
    {
        $self = clone $this;
        $self['sessionThreadID'] = $sessionThreadID;

        return $self;
    }

    /**
     * @param 'session.thread_status_rescheduled' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
