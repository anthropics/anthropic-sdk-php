<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A recurring schedule. Discriminated union — only cron is supported currently.
 *
 * @phpstan-type BetaManagedAgentsScheduleParamsShape = array{
 *   expression: string, timezone: string, type: 'cron'
 * }
 */
final class BetaManagedAgentsScheduleParams implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsScheduleParamsShape> */
    use SdkModel;

    /** @var 'cron' $type */
    #[Required(type: new ConstantOf('cron'))]
    public string $type = 'cron';

    /**
     * 5-field POSIX cron expression: minute hour day-of-month month day-of-week (e.g., "0 9 * * 1-5" for weekdays at 9am). Day-of-week is 0-7 where 0 and 7 both mean Sunday. Extended cron syntax - seconds or year fields, and the special characters L, W, #, and ? - is not supported, nor are predefined shortcuts (@daily).
     */
    #[Required]
    public string $expression;

    /**
     * Required. IANA timezone identifier (e.g., "America/Los_Angeles", "UTC"). Validated against the IANA timezone database.
     */
    #[Required]
    public string $timezone;

    /**
     * `new BetaManagedAgentsScheduleParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsScheduleParams::with(expression: ..., timezone: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsScheduleParams())->withExpression(...)->withTimezone(...)
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
    public static function with(string $expression, string $timezone): self
    {
        $self = new self;

        $self['expression'] = $expression;
        $self['timezone'] = $timezone;

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
     * Required. IANA timezone identifier (e.g., "America/Los_Angeles", "UTC"). Validated against the IANA timezone database.
     */
    public function withTimezone(string $timezone): self
    {
        $self = clone $this;
        $self['timezone'] = $timezone;

        return $self;
    }

    /**
     * @param 'cron' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
