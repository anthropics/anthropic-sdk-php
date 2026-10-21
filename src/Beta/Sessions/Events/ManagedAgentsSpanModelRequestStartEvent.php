<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Emitted when a model request is initiated by the agent.
 *
 * @phpstan-type ManagedAgentsSpanModelRequestStartEventShape = array{
 *   id: string, processedAt: \DateTimeInterface, type: 'span.model_request_start'
 * }
 */
final class ManagedAgentsSpanModelRequestStartEvent implements BaseModel
{
    /** @use SdkModel<ManagedAgentsSpanModelRequestStartEventShape> */
    use SdkModel;

    /** @var 'span.model_request_start' $type */
    #[Required(type: new ConstantOf('span.model_request_start'))]
    public string $type = 'span.model_request_start';

    /**
     * Unique identifier for this event.
     */
    #[Required]
    public string $id;

    /**
     * Timestamp when the model request started.
     */
    #[Required('processed_at')]
    public \DateTimeInterface $processedAt;

    /**
     * `new ManagedAgentsSpanModelRequestStartEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsSpanModelRequestStartEvent::with(id: ..., processedAt: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsSpanModelRequestStartEvent())
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
     * Timestamp when the model request started.
     */
    public function withProcessedAt(\DateTimeInterface $processedAt): self
    {
        $self = clone $this;
        $self['processedAt'] = $processedAt;

        return $self;
    }

    /**
     * @param 'span.model_request_start' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
