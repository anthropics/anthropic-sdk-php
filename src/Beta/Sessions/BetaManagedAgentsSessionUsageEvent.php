<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionUsageSnapshot;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Periodic snapshot of the session's cumulative usage and tracked list cost.
 *
 * @phpstan-import-type ManagedAgentsSessionUsageSnapshotShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSessionUsageSnapshot
 * @phpstan-import-type BetaManagedAgentsBudgetLimitShape from \Anthropic\Beta\Sessions\BetaManagedAgentsBudgetLimit
 *
 * @phpstan-type BetaManagedAgentsSessionUsageEventShape = array{
 *   id: string,
 *   processedAt: \DateTimeInterface,
 *   type: 'session.usage',
 *   usage: ManagedAgentsSessionUsageSnapshot|ManagedAgentsSessionUsageSnapshotShape,
 *   budget?: null|BetaManagedAgentsBudgetLimit|BetaManagedAgentsBudgetLimitShape,
 * }
 */
final class BetaManagedAgentsSessionUsageEvent implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsSessionUsageEventShape> */
    use SdkModel;

    /** @var 'session.usage' $type */
    #[Required(type: new ConstantOf('session.usage'))]
    public string $type = 'session.usage';

    /**
     * Unique identifier for this event.
     */
    #[Required]
    public string $id;

    /**
     * Timestamp when the snapshot was taken.
     */
    #[Required('processed_at')]
    public \DateTimeInterface $processedAt;

    /**
     * The session's cumulative usage at the snapshot time.
     */
    #[Required]
    public ManagedAgentsSessionUsageSnapshot $usage;

    /**
     * The session's configured budget at the snapshot time, or null when the session has no budget.
     */
    #[Optional(nullable: true)]
    public ?BetaManagedAgentsBudgetLimit $budget;

    /**
     * `new BetaManagedAgentsSessionUsageEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsSessionUsageEvent::with(id: ..., processedAt: ..., usage: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsSessionUsageEvent())
     *   ->withID(...)
     *   ->withProcessedAt(...)
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
     * @param ManagedAgentsSessionUsageSnapshot|ManagedAgentsSessionUsageSnapshotShape $usage
     * @param BetaManagedAgentsBudgetLimit|BetaManagedAgentsBudgetLimitShape|null $budget
     */
    public static function with(
        string $id,
        \DateTimeInterface $processedAt,
        ManagedAgentsSessionUsageSnapshot|array $usage,
        BetaManagedAgentsBudgetLimit|array|null $budget = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['processedAt'] = $processedAt;
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
     * Timestamp when the snapshot was taken.
     */
    public function withProcessedAt(\DateTimeInterface $processedAt): self
    {
        $self = clone $this;
        $self['processedAt'] = $processedAt;

        return $self;
    }

    /**
     * @param 'session.usage' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * The session's cumulative usage at the snapshot time.
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
     * The session's configured budget at the snapshot time, or null when the session has no budget.
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
