<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Indicates the session is actively running and the agent is working.
 *
 * @phpstan-type ManagedAgentsSessionStatusRunningEventShape = array{
 *   id: string, processedAt: \DateTimeInterface, type: 'session.status_running'
 * }
 */
final class ManagedAgentsSessionStatusRunningEvent implements BaseModel
{
    /** @use SdkModel<ManagedAgentsSessionStatusRunningEventShape> */
    use SdkModel;

    /** @var 'session.status_running' $type */
    #[Required(type: new ConstantOf('session.status_running'))]
    public string $type = 'session.status_running';

    /**
     * Unique identifier for this event.
     */
    #[Required]
    public string $id;

    /**
     * Timestamp of status change.
     */
    #[Required('processed_at')]
    public \DateTimeInterface $processedAt;

    /**
     * `new ManagedAgentsSessionStatusRunningEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsSessionStatusRunningEvent::with(id: ..., processedAt: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsSessionStatusRunningEvent())
     *   ->withID(...)
     *   ->withProcessedAt(...)
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
     * Timestamp of status change.
     */
    public function withProcessedAt(\DateTimeInterface $processedAt): self
    {
        $self = clone $this;
        $self['processedAt'] = $processedAt;

        return $self;
    }

    /**
     * @param 'session.status_running' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
