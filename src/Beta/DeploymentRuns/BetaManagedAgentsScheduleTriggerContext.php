<?php

declare(strict_types=1);

namespace Anthropic\Beta\DeploymentRuns;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The run was fired by the deployment's cron schedule.
 *
 * @phpstan-type BetaManagedAgentsScheduleTriggerContextShape = array{
 *   scheduledAt: \DateTimeInterface, type: 'schedule'
 * }
 */
final class BetaManagedAgentsScheduleTriggerContext implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsScheduleTriggerContextShape> */
    use SdkModel;

    /** @var 'schedule' $type */
    #[Required(type: new ConstantOf('schedule'))]
    public string $type = 'schedule';

    /**
     * The UTC instant at which the cron expression matched in the configured timezone, before jitter is applied. At most one run is recorded per (`deployment_id`, `scheduled_at`) pair.
     */
    #[Required('scheduled_at')]
    public \DateTimeInterface $scheduledAt;

    /**
     * `new BetaManagedAgentsScheduleTriggerContext()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsScheduleTriggerContext::with(scheduledAt: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsScheduleTriggerContext())->withScheduledAt(...)
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
    public static function with(\DateTimeInterface $scheduledAt): self
    {
        $self = new self;

        $self['scheduledAt'] = $scheduledAt;

        return $self;
    }

    /**
     * The UTC instant at which the cron expression matched in the configured timezone, before jitter is applied. At most one run is recorded per (`deployment_id`, `scheduled_at`) pair.
     */
    public function withScheduledAt(\DateTimeInterface $scheduledAt): self
    {
        $self = clone $this;
        $self['scheduledAt'] = $scheduledAt;

        return $self;
    }

    /**
     * @param 'schedule' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
