<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionThreadStatusTerminatedEvent\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A session thread has terminated and will accept no further input. Emitted on the thread's own stream and cross-posted to the primary stream for child threads.
 *
 * @phpstan-type ManagedAgentsSessionThreadStatusTerminatedEventShape = array{
 *   id: string,
 *   agentName: string,
 *   processedAt: \DateTimeInterface,
 *   sessionThreadID: string,
 *   type: Type|value-of<Type>,
 * }
 */
final class ManagedAgentsSessionThreadStatusTerminatedEvent implements BaseModel
{
    /** @use SdkModel<ManagedAgentsSessionThreadStatusTerminatedEventShape> */
    use SdkModel;

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
     * A timestamp in RFC 3339 format.
     */
    #[Required('processed_at')]
    public \DateTimeInterface $processedAt;

    /**
     * Public sthr_ ID of the thread that terminated.
     */
    #[Required('session_thread_id')]
    public string $sessionThreadID;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new ManagedAgentsSessionThreadStatusTerminatedEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsSessionThreadStatusTerminatedEvent::with(
     *   id: ..., agentName: ..., processedAt: ..., sessionThreadID: ..., type: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsSessionThreadStatusTerminatedEvent)
     *   ->withID(...)
     *   ->withAgentName(...)
     *   ->withProcessedAt(...)
     *   ->withSessionThreadID(...)
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
        string $id,
        string $agentName,
        \DateTimeInterface $processedAt,
        string $sessionThreadID,
        Type|string $type,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['agentName'] = $agentName;
        $self['processedAt'] = $processedAt;
        $self['sessionThreadID'] = $sessionThreadID;
        $self['type'] = $type;

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
     * A timestamp in RFC 3339 format.
     */
    public function withProcessedAt(\DateTimeInterface $processedAt): self
    {
        $self = clone $this;
        $self['processedAt'] = $processedAt;

        return $self;
    }

    /**
     * Public sthr_ ID of the thread that terminated.
     */
    public function withSessionThreadID(string $sessionThreadID): self
    {
        $self = clone $this;
        $self['sessionThreadID'] = $sessionThreadID;

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
