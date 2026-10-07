<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Wait for a specified duration.
 *
 * @phpstan-type BetaComputerWaitInputShape = array{duration: int}
 */
final class BetaComputerWaitInput implements BaseModel
{
    /** @use SdkModel<BetaComputerWaitInputShape> */
    use SdkModel;

    /**
     * Duration to wait, in seconds.
     */
    #[Required]
    public int $duration;

    /**
     * `new BetaComputerWaitInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaComputerWaitInput::with(duration: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaComputerWaitInput())->withDuration(...)
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
    public static function with(int $duration): self
    {
        $self = new self;

        $self['duration'] = $duration;

        return $self;
    }

    /**
     * Duration to wait, in seconds.
     */
    public function withDuration(int $duration): self
    {
        $self = clone $this;
        $self['duration'] = $duration;

        return $self;
    }
}
