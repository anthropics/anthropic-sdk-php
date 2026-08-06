<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Beta\Sessions\BetaManagedAgentsSessionUsageEvent\Type;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionUsageSnapshot;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Periodic snapshot of the session's cumulative usage and tracked list cost.
 *
 * @phpstan-import-type ManagedAgentsSessionUsageSnapshotShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSessionUsageSnapshot
 * @phpstan-import-type BetaManagedAgentsBudgetLimitShape from \Anthropic\Beta\Sessions\BetaManagedAgentsBudgetLimit
 *
 * @phpstan-type BetaManagedAgentsSessionUsageEventShape = array{
 *   id: string,
 *   processedAt: \DateTimeInterface,
 *   type: Type|value-of<Type>,
 *   usage: ManagedAgentsSessionUsageSnapshot|ManagedAgentsSessionUsageSnapshotShape,
 *   budget?: null|BetaManagedAgentsBudgetLimit|BetaManagedAgentsBudgetLimitShape,
 * }
 */
final class BetaManagedAgentsSessionUsageEvent implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsSessionUsageEventShape> */
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

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * Point-in-time snapshot of a session's cumulative usage.
     */
    #[Required]
    public ManagedAgentsSessionUsageSnapshot $usage;

    /**
     * A hard spend ceiling. The session stops issuing new model requests once the tracked list cost reaches `max_list_cost`.
     */
    #[Optional(nullable: true)]
    public ?BetaManagedAgentsBudgetLimit $budget;

    /**
     * `new BetaManagedAgentsSessionUsageEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsSessionUsageEvent::with(
     *   id: ..., processedAt: ..., type: ..., usage: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsSessionUsageEvent)
     *   ->withID(...)
     *   ->withProcessedAt(...)
     *   ->withType(...)
     *   ->withUsage(...)
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
     * @param ManagedAgentsSessionUsageSnapshot|ManagedAgentsSessionUsageSnapshotShape $usage
     * @param BetaManagedAgentsBudgetLimit|BetaManagedAgentsBudgetLimitShape|null $budget
     */
    public static function with(
        string $id,
        \DateTimeInterface $processedAt,
        Type|string $type,
        ManagedAgentsSessionUsageSnapshot|array $usage,
        BetaManagedAgentsBudgetLimit|array|null $budget = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['processedAt'] = $processedAt;
        $self['type'] = $type;
        $self['usage'] = $usage;

        null !== $budget && $self['budget'] = $budget;

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
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Point-in-time snapshot of a session's cumulative usage.
     *
     * @param ManagedAgentsSessionUsageSnapshot|ManagedAgentsSessionUsageSnapshotShape $usage
     */
    public function withUsage(
        ManagedAgentsSessionUsageSnapshot|array $usage
    ): self {
        $self = clone $this;
        $self['usage'] = $usage;

        return $self;
    }

    /**
     * A hard spend ceiling. The session stops issuing new model requests once the tracked list cost reaches `max_list_cost`.
     *
     * @param BetaManagedAgentsBudgetLimit|BetaManagedAgentsBudgetLimitShape|null $budget
     */
    public function withBudget(
        BetaManagedAgentsBudgetLimit|array|null $budget
    ): self {
        $self = clone $this;
        $self['budget'] = $budget;

        return $self;
    }
}
