<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments;

use Anthropic\Beta\Deployments\BetaManagedAgentsSchedule\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * 5-field POSIX cron schedule with computed runtime timestamps.
 *
 * @phpstan-type BetaManagedAgentsScheduleShape = array{
 *   expression: string,
 *   timezone: string,
 *   type: Type|value-of<Type>,
 *   lastRunAt?: \DateTimeInterface|null,
 *   upcomingRunsAt?: list<\DateTimeInterface>|null,
 * }
 */
final class BetaManagedAgentsSchedule implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsScheduleShape> */
    use SdkModel;

    /**
     * 5-field POSIX cron expression: minute hour day-of-month month day-of-week (e.g., "0 9 * * 1-5" for weekdays at 9am). Day-of-week is 0-7 where 0 and 7 both mean Sunday. Extended cron syntax - seconds or year fields, and the special characters L, W, #, and ? - is not supported, nor are predefined shortcuts (@daily).
     */
    #[Required]
    public string $expression;

    /**
     * IANA timezone identifier (e.g., "America/Los_Angeles", "UTC").
     */
    #[Required]
    public string $timezone;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Optional('last_run_at', nullable: true)]
    public ?\DateTimeInterface $lastRunAt;

    /**
     * Up to 5 timestamps of upcoming cron occurrences. Non-empty for active and paused deployments (reflects what the schedule would do if unpaused); empty once the deployment is archived (`archived_at` set). Each fire is offset by a small per-schedule jitter, so a run will actually start at or shortly after its listed time.
     *
     * @var list<\DateTimeInterface>|null $upcomingRunsAt
     */
    #[Optional('upcoming_runs_at', list: '\DateTimeInterface')]
    public ?array $upcomingRunsAt;

    /**
     * `new BetaManagedAgentsSchedule()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsSchedule::with(expression: ..., timezone: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsSchedule)
     *   ->withExpression(...)
     *   ->withTimezone(...)
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
     * @param Type|value-of<Type> $type
     * @param list<\DateTimeInterface>|null $upcomingRunsAt
     */
    public static function with(
        string $expression,
        string $timezone,
        Type|string $type,
        ?\DateTimeInterface $lastRunAt = null,
        ?array $upcomingRunsAt = null,
    ): self {
        $self = new self;

        $self['expression'] = $expression;
        $self['timezone'] = $timezone;
        $self['type'] = $type;

        null !== $lastRunAt && $self['lastRunAt'] = $lastRunAt;
        null !== $upcomingRunsAt && $self['upcomingRunsAt'] = $upcomingRunsAt;

        return $self;
    }

    /**
     * 5-field POSIX cron expression: minute hour day-of-month month day-of-week (e.g., "0 9 * * 1-5" for weekdays at 9am). Day-of-week is 0-7 where 0 and 7 both mean Sunday. Extended cron syntax - seconds or year fields, and the special characters L, W, #, and ? - is not supported, nor are predefined shortcuts (@daily).
     */
    public function withExpression(string $expression): self
    {
        $self = clone $this;
        $self['expression'] = $expression;

        return $self;
    }

    /**
     * IANA timezone identifier (e.g., "America/Los_Angeles", "UTC").
     */
    public function withTimezone(string $timezone): self
    {
        $self = clone $this;
        $self['timezone'] = $timezone;

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
     * A timestamp in RFC 3339 format.
     */
    public function withLastRunAt(?\DateTimeInterface $lastRunAt): self
    {
        $self = clone $this;
        $self['lastRunAt'] = $lastRunAt;

        return $self;
    }

    /**
     * Up to 5 timestamps of upcoming cron occurrences. Non-empty for active and paused deployments (reflects what the schedule would do if unpaused); empty once the deployment is archived (`archived_at` set). Each fire is offset by a small per-schedule jitter, so a run will actually start at or shortly after its listed time.
     *
     * @param list<\DateTimeInterface> $upcomingRunsAt
     */
    public function withUpcomingRunsAt(array $upcomingRunsAt): self
    {
        $self = clone $this;
        $self['upcomingRunsAt'] = $upcomingRunsAt;

        return $self;
    }
}
