<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionStatusIdleEvent\StopReason;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionStatusIdleEvent\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Indicates the agent has paused and is awaiting user input.
 *
 * @phpstan-import-type StopReasonVariants from \Anthropic\Beta\Sessions\Events\ManagedAgentsSessionStatusIdleEvent\StopReason
 * @phpstan-import-type StopReasonShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSessionStatusIdleEvent\StopReason
 *
 * @phpstan-type ManagedAgentsSessionStatusIdleEventShape = array{
 *   id: string,
 *   processedAt: \DateTimeInterface,
 *   stopReason: StopReasonShape,
 *   type: Type|value-of<Type>,
 * }
 */
final class ManagedAgentsSessionStatusIdleEvent implements BaseModel
{
    /** @use SdkModel<ManagedAgentsSessionStatusIdleEventShape> */
    use SdkModel;

    /**
     * Unique identifier for this event.
     */
    #[Required]
    public string $id;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('processed_at')]
    public \DateTimeInterface $processedAt;

    /**
     * The agent completed its turn naturally and is ready for the next user message.
     *
     * @var StopReasonVariants $stopReason
     */
    #[Required('stop_reason', union: StopReason::class)]
    public ManagedAgentsSessionEndTurn|ManagedAgentsSessionRequiresAction|ManagedAgentsSessionRetriesExhausted $stopReason;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new ManagedAgentsSessionStatusIdleEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsSessionStatusIdleEvent::with(
     *   id: ..., processedAt: ..., stopReason: ..., type: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsSessionStatusIdleEvent)
     *   ->withID(...)
     *   ->withProcessedAt(...)
     *   ->withStopReason(...)
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
     * @param StopReasonShape $stopReason
     * @param Type|value-of<Type> $type
     */
    public static function with(
        string $id,
        \DateTimeInterface $processedAt,
        ManagedAgentsSessionEndTurn|array|ManagedAgentsSessionRequiresAction|ManagedAgentsSessionRetriesExhausted $stopReason,
        Type|string $type,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['processedAt'] = $processedAt;
        $self['stopReason'] = $stopReason;
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
     * A timestamp in RFC 3339 format.
     */
    public function withProcessedAt(\DateTimeInterface $processedAt): self
    {
        $self = clone $this;
        $self['processedAt'] = $processedAt;

        return $self;
    }

    /**
     * The agent completed its turn naturally and is ready for the next user message.
     *
     * @param StopReasonShape $stopReason
     */
    public function withStopReason(
        ManagedAgentsSessionEndTurn|array|ManagedAgentsSessionRequiresAction|ManagedAgentsSessionRetriesExhausted $stopReason,
    ): self {
        $self = clone $this;
        $self['stopReason'] = $stopReason;

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
