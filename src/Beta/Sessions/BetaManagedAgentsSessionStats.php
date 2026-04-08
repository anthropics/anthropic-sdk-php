<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Timing statistics for a session.
 *
 * @phpstan-type BetaManagedAgentsSessionStatsShape = array{
 *   activeSeconds?: float|null, durationSeconds?: float|null
 * }
 */
final class BetaManagedAgentsSessionStats implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsSessionStatsShape> */
    use SdkModel;

    /**
     * Cumulative time in seconds the session spent in running status. Excludes idle time.
     */
    #[Optional('active_seconds')]
    public ?float $activeSeconds;

    /**
     * Elapsed time since session creation in seconds. For terminated sessions, frozen at the final update.
     */
    #[Optional('duration_seconds')]
    public ?float $durationSeconds;

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
        ?float $durationSeconds = null
    ): self {
        $self = new self;

        null !== $activeSeconds && $self['activeSeconds'] = $activeSeconds;
        null !== $durationSeconds && $self['durationSeconds'] = $durationSeconds;

        return $self;
    }

    /**
     * Cumulative time in seconds the session spent in running status. Excludes idle time.
     */
    public function withActiveSeconds(float $activeSeconds): self
    {
        $self = clone $this;
        $self['activeSeconds'] = $activeSeconds;

        return $self;
    }

    /**
     * Elapsed time since session creation in seconds. For terminated sessions, frozen at the final update.
     */
    public function withDurationSeconds(float $durationSeconds): self
    {
        $self = clone $this;
        $self['durationSeconds'] = $durationSeconds;

        return $self;
    }
}
