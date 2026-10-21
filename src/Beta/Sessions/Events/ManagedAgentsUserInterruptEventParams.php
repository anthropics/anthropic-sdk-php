<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Parameters for sending an interrupt to pause the agent.
 *
 * @phpstan-type ManagedAgentsUserInterruptEventParamsShape = array{
 *   type: 'user.interrupt', sessionThreadID?: string|null
 * }
 */
final class ManagedAgentsUserInterruptEventParams implements BaseModel
{
    /** @use SdkModel<ManagedAgentsUserInterruptEventParamsShape> */
    use SdkModel;

    /** @var 'user.interrupt' $type */
    #[Required(type: new ConstantOf('user.interrupt'))]
    public string $type = 'user.interrupt';

    /**
     * If absent, interrupts every non-archived thread in a multiagent session (or the primary alone in a single-agent session). If present, interrupts only the named thread.
     */
    #[Optional('session_thread_id', nullable: true)]
    public ?string $sessionThreadID;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $sessionThreadID = null): self
    {
        $self = new self;

        null !== $sessionThreadID && $self['sessionThreadID'] = $sessionThreadID;

        return $self;
    }

    /**
     * @param 'user.interrupt' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * If absent, interrupts every non-archived thread in a multiagent session (or the primary alone in a single-agent session). If present, interrupts only the named thread.
     */
    public function withSessionThreadID(?string $sessionThreadID): self
    {
        $self = clone $this;
        $self['sessionThreadID'] = $sessionThreadID;

        return $self;
    }
}
