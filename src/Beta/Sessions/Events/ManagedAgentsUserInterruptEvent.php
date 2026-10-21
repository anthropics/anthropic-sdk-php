<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * An interrupt event that pauses agent execution and returns control to the user.
 *
 * @phpstan-type ManagedAgentsUserInterruptEventShape = array{
 *   id: string,
 *   type: 'user.interrupt',
 *   processedAt?: \DateTimeInterface|null,
 *   sessionThreadID?: string|null,
 * }
 */
final class ManagedAgentsUserInterruptEvent implements BaseModel
{
    /** @use SdkModel<ManagedAgentsUserInterruptEventShape> */
    use SdkModel;

    /** @var 'user.interrupt' $type */
    #[Required(type: new ConstantOf('user.interrupt'))]
    public string $type = 'user.interrupt';

    /**
     * Unique identifier for this event.
     */
    #[Required]
    public string $id;

    /**
     * Timestamp when the interrupt was processed.
     */
    #[Optional('processed_at', nullable: true)]
    public ?\DateTimeInterface $processedAt;

    /**
     * If absent, interrupts every non-archived thread in a multiagent session (or the primary alone in a single-agent session). If present, interrupts only the named thread.
     */
    #[Optional('session_thread_id', nullable: true)]
    public ?string $sessionThreadID;

    /**
     * `new ManagedAgentsUserInterruptEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsUserInterruptEvent::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsUserInterruptEvent())->withID(...)
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
        string $id,
        ?\DateTimeInterface $processedAt = null,
        ?string $sessionThreadID = null,
    ): self {
        $self = new self;

        $self['id'] = $id;

        null !== $processedAt && $self['processedAt'] = $processedAt;
        null !== $sessionThreadID && $self['sessionThreadID'] = $sessionThreadID;

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
     * @param 'user.interrupt' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Timestamp when the interrupt was processed.
     */
    public function withProcessedAt(?\DateTimeInterface $processedAt): self
    {
        $self = clone $this;
        $self['processedAt'] = $processedAt;

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
