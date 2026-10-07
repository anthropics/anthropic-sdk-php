<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Pause for the given duration.
 *
 * @phpstan-type BetaBrowserWaitInputShape = array{
 *   duration: float, tabID?: string|null
 * }
 */
final class BetaBrowserWaitInput implements BaseModel
{
    /** @use SdkModel<BetaBrowserWaitInputShape> */
    use SdkModel;

    /**
     * Seconds to wait (maximum 30).
     */
    #[Required]
    public float $duration;

    /**
     * Tab to act on. Defaults to the active tab when omitted.
     */
    #[Optional('tab_id', nullable: true)]
    public ?string $tabID;

    /**
     * `new BetaBrowserWaitInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaBrowserWaitInput::with(duration: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaBrowserWaitInput())->withDuration(...)
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
    public static function with(float $duration, ?string $tabID = null): self
    {
        $self = new self;

        $self['duration'] = $duration;

        null !== $tabID && $self['tabID'] = $tabID;

        return $self;
    }

    /**
     * Seconds to wait (maximum 30).
     */
    public function withDuration(float $duration): self
    {
        $self = clone $this;
        $self['duration'] = $duration;

        return $self;
    }

    /**
     * Tab to act on. Defaults to the active tab when omitted.
     */
    public function withTabID(?string $tabID): self
    {
        $self = clone $this;
        $self['tabID'] = $tabID;

        return $self;
    }
}
