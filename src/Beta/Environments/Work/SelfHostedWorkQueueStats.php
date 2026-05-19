<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments\Work;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Statistics about the work queue for an environment.
 *
 * Uses Redis Stream consumer group metrics for O(1) queries.
 *
 * @phpstan-type SelfHostedWorkQueueStatsShape = array{
 *   depth: int,
 *   oldestQueuedAt: string|null,
 *   pending: int,
 *   type: 'work_queue_stats',
 *   workersPolling: int|null,
 * }
 */
final class SelfHostedWorkQueueStats implements BaseModel
{
    /** @use SdkModel<SelfHostedWorkQueueStatsShape> */
    use SdkModel;

    /**
     * The type of object.
     *
     * @var 'work_queue_stats' $type
     */
    #[Required]
    public string $type = 'work_queue_stats';

    /**
     * Number of work items waiting to be picked up (lag from consumer group).
     */
    #[Required]
    public int $depth;

    /**
     * RFC 3339 timestamp of oldest item in the work stream (includes both queued and pending items), null if stream empty.
     */
    #[Required('oldest_queued_at')]
    public ?string $oldestQueuedAt;

    /**
     * Number of work items being processed (polled but not acknowledged).
     */
    #[Required]
    public int $pending;

    /**
     * Number of workers that have polled for work in the last 30 seconds. Requires worker_id to be sent with poll requests.
     */
    #[Required('workers_polling')]
    public ?int $workersPolling;

    /**
     * `new SelfHostedWorkQueueStats()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SelfHostedWorkQueueStats::with(
     *   depth: ..., oldestQueuedAt: ..., pending: ..., workersPolling: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SelfHostedWorkQueueStats)
     *   ->withDepth(...)
     *   ->withOldestQueuedAt(...)
     *   ->withPending(...)
     *   ->withWorkersPolling(...)
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
        int $depth,
        ?string $oldestQueuedAt,
        ?int $workersPolling,
        int $pending = 0
    ): self {
        $self = new self;

        $self['depth'] = $depth;
        $self['oldestQueuedAt'] = $oldestQueuedAt;
        $self['pending'] = $pending;
        $self['workersPolling'] = $workersPolling;

        return $self;
    }

    /**
     * Number of work items waiting to be picked up (lag from consumer group).
     */
    public function withDepth(int $depth): self
    {
        $self = clone $this;
        $self['depth'] = $depth;

        return $self;
    }

    /**
     * RFC 3339 timestamp of oldest item in the work stream (includes both queued and pending items), null if stream empty.
     */
    public function withOldestQueuedAt(?string $oldestQueuedAt): self
    {
        $self = clone $this;
        $self['oldestQueuedAt'] = $oldestQueuedAt;

        return $self;
    }

    /**
     * Number of work items being processed (polled but not acknowledged).
     */
    public function withPending(int $pending): self
    {
        $self = clone $this;
        $self['pending'] = $pending;

        return $self;
    }

    /**
     * The type of object.
     *
     * @param 'work_queue_stats' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Number of workers that have polled for work in the last 30 seconds. Requires worker_id to be sent with poll requests.
     */
    public function withWorkersPolling(?int $workersPolling): self
    {
        $self = clone $this;
        $self['workersPolling'] = $workersPolling;

        return $self;
    }
}
