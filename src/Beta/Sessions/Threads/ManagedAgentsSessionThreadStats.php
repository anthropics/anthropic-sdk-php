<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Threads;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Timing statistics for a session thread.
 *
 * @phpstan-type ManagedAgentsSessionThreadStatsShape = array{
 *   activeSeconds?: float|null,
 *   durationSeconds?: float|null,
 *   startupSeconds?: float|null,
 * }
 */
final class ManagedAgentsSessionThreadStats implements BaseModel
{
    /** @use SdkModel<ManagedAgentsSessionThreadStatsShape> */
    use SdkModel;

    /**
     * Cumulative time in seconds the thread spent actively running. Excludes idle time.
     */
    #[Optional('active_seconds')]
    public ?float $activeSeconds;

    /**
     * Elapsed time since thread creation in seconds. For archived threads, frozen at the final update.
     */
    #[Optional('duration_seconds')]
    public ?float $durationSeconds;

    /**
     * Time in seconds for the thread to begin running. Zero for child threads, which start immediately.
     */
    #[Optional('startup_seconds')]
    public ?float $startupSeconds;

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
        ?float $activeSeconds = null,
        ?float $durationSeconds = null,
        ?float $startupSeconds = null,
    ): self {
        $self = new self;

        null !== $activeSeconds && $self['activeSeconds'] = $activeSeconds;
        null !== $durationSeconds && $self['durationSeconds'] = $durationSeconds;
        null !== $startupSeconds && $self['startupSeconds'] = $startupSeconds;

        return $self;
    }

    /**
     * Cumulative time in seconds the thread spent actively running. Excludes idle time.
     */
    public function withActiveSeconds(float $activeSeconds): self
    {
        $self = clone $this;
        $self['activeSeconds'] = $activeSeconds;

        return $self;
    }

    /**
     * Elapsed time since thread creation in seconds. For archived threads, frozen at the final update.
     */
    public function withDurationSeconds(float $durationSeconds): self
    {
        $self = clone $this;
        $self['durationSeconds'] = $durationSeconds;

        return $self;
    }

    /**
     * Time in seconds for the thread to begin running. Zero for child threads, which start immediately.
     */
    public function withStartupSeconds(float $startupSeconds): self
    {
        $self = clone $this;
        $self['startupSeconds'] = $startupSeconds;

        return $self;
    }
}
