<?php

declare(strict_types=1);

namespace Anthropic\Beta\DeploymentRuns;

use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsScheduleTriggerContext\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The run was fired by the deployment's cron schedule.
 *
 * @phpstan-type BetaManagedAgentsScheduleTriggerContextShape = array{
 *   scheduledAt: \DateTimeInterface, type: Type|value-of<Type>
 * }
 */
final class BetaManagedAgentsScheduleTriggerContext implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsScheduleTriggerContextShape> */
    use SdkModel;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('scheduled_at')]
    public \DateTimeInterface $scheduledAt;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new BetaManagedAgentsScheduleTriggerContext()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsScheduleTriggerContext::with(scheduledAt: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsScheduleTriggerContext)
     *   ->withScheduledAt(...)
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
     */
    public static function with(
        \DateTimeInterface $scheduledAt,
        Type|string $type
    ): self {
        $self = new self;

        $self['scheduledAt'] = $scheduledAt;
        $self['type'] = $type;

        return $self;
    }

    /**
     * A timestamp in RFC 3339 format.
     */
    public function withScheduledAt(\DateTimeInterface $scheduledAt): self
    {
        $self = clone $this;
        $self['scheduledAt'] = $scheduledAt;

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
