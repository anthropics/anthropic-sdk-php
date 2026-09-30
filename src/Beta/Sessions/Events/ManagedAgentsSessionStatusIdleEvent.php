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
 * @phpstan-import-type ManagedAgentsSessionRefusalStopDetailsShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSessionRefusalStopDetails
 * @phpstan-import-type StopReasonShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSessionStatusIdleEvent\StopReason
 *
 * @phpstan-type ManagedAgentsSessionStatusIdleEventShape = array{
 *   id: string,
 *   processedAt: \DateTimeInterface,
 *   stopDetails: null|ManagedAgentsSessionRefusalStopDetails|ManagedAgentsSessionRefusalStopDetailsShape,
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
     * Timestamp of status change.
     */
    #[Required('processed_at')]
    public \DateTimeInterface $processedAt;

    /**
     * Structured information about why the session stopped. `null` when there is nothing more to report.
     */
    #[Required('stop_details')]
    public ?ManagedAgentsSessionRefusalStopDetails $stopDetails;

    /** @var StopReasonVariants $stopReason */
    #[Required('stop_reason', union: StopReason::class)]
    public ManagedAgentsSessionEndTurn|ManagedAgentsSessionRequiresAction|ManagedAgentsSessionRetriesExhausted|ManagedAgentsSessionBudgetReached|ManagedAgentsSessionRefusal $stopReason;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new ManagedAgentsSessionStatusIdleEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsSessionStatusIdleEvent::with(
     *   id: ..., processedAt: ..., stopDetails: ..., stopReason: ..., type: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsSessionStatusIdleEvent)
     *   ->withID(...)
     *   ->withProcessedAt(...)
     *   ->withStopDetails(...)
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
     * @param ManagedAgentsSessionRefusalStopDetails|ManagedAgentsSessionRefusalStopDetailsShape|null $stopDetails
     * @param StopReasonShape $stopReason
     * @param Type|value-of<Type> $type
     */
    public static function with(
        string $id,
        \DateTimeInterface $processedAt,
        ManagedAgentsSessionRefusalStopDetails|array|null $stopDetails,
        ManagedAgentsSessionEndTurn|array|ManagedAgentsSessionRequiresAction|ManagedAgentsSessionRetriesExhausted|ManagedAgentsSessionBudgetReached|ManagedAgentsSessionRefusal $stopReason,
        Type|string $type,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['processedAt'] = $processedAt;
        $self['stopDetails'] = $stopDetails;
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
     * Timestamp of status change.
     */
    public function withProcessedAt(\DateTimeInterface $processedAt): self
    {
        $self = clone $this;
        $self['processedAt'] = $processedAt;

        return $self;
    }

    /**
     * Structured information about why the session stopped. `null` when there is nothing more to report.
     *
     * @param ManagedAgentsSessionRefusalStopDetails|ManagedAgentsSessionRefusalStopDetailsShape|null $stopDetails
     */
    public function withStopDetails(
        ManagedAgentsSessionRefusalStopDetails|array|null $stopDetails
    ): self {
        $self = clone $this;
        $self['stopDetails'] = $stopDetails;

        return $self;
    }

    /**
     * @param StopReasonShape $stopReason
     */
    public function withStopReason(
        ManagedAgentsSessionEndTurn|array|ManagedAgentsSessionRequiresAction|ManagedAgentsSessionRetriesExhausted|ManagedAgentsSessionBudgetReached|ManagedAgentsSessionRefusal $stopReason,
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
