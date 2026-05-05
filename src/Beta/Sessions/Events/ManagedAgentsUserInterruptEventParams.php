<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsUserInterruptEventParams\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Parameters for sending an interrupt to pause the agent.
 *
 * @phpstan-type ManagedAgentsUserInterruptEventParamsShape = array{
 *   type: Type|value-of<Type>, sessionThreadID?: string|null
 * }
 */
final class ManagedAgentsUserInterruptEventParams implements BaseModel
{
    /** @use SdkModel<ManagedAgentsUserInterruptEventParamsShape> */
    use SdkModel;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * If absent, interrupts every non-archived thread in a multiagent session (or the primary alone in a single-agent session). If present, interrupts only the named thread.
     */
    #[Optional('session_thread_id', nullable: true)]
    public ?string $sessionThreadID;

    /**
     * `new ManagedAgentsUserInterruptEventParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsUserInterruptEventParams::with(type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsUserInterruptEventParams)->withType(...)
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
        Type|string $type,
        ?string $sessionThreadID = null
    ): self {
        $self = new self;

        $self['type'] = $type;

        null !== $sessionThreadID && $self['sessionThreadID'] = $sessionThreadID;

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
     * If absent, interrupts every non-archived thread in a multiagent session (or the primary alone in a single-agent session). If present, interrupts only the named thread.
     */
    public function withSessionThreadID(?string $sessionThreadID): self
    {
        $self = clone $this;
        $self['sessionThreadID'] = $sessionThreadID;

        return $self;
    }
}
