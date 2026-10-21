<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Indicates the agent is making forward progress via extended thinking. A progress signal, not a content carrier.
 *
 * @phpstan-type ManagedAgentsAgentThinkingEventShape = array{
 *   id: string, processedAt: \DateTimeInterface, type: 'agent.thinking'
 * }
 */
final class ManagedAgentsAgentThinkingEvent implements BaseModel
{
    /** @use SdkModel<ManagedAgentsAgentThinkingEventShape> */
    use SdkModel;

    /** @var 'agent.thinking' $type */
    #[Required(type: new ConstantOf('agent.thinking'))]
    public string $type = 'agent.thinking';

    /**
     * Unique identifier for this event.
     */
    #[Required]
    public string $id;

    /**
     * Timestamp when this thinking was produced.
     */
    #[Required('processed_at')]
    public \DateTimeInterface $processedAt;

    /**
     * `new ManagedAgentsAgentThinkingEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsAgentThinkingEvent::with(id: ..., processedAt: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsAgentThinkingEvent())->withID(...)->withProcessedAt(...)
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
        \DateTimeInterface $processedAt
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['processedAt'] = $processedAt;

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
     * Timestamp when this thinking was produced.
     */
    public function withProcessedAt(\DateTimeInterface $processedAt): self
    {
        $self = clone $this;
        $self['processedAt'] = $processedAt;

        return $self;
    }

    /**
     * @param 'agent.thinking' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
