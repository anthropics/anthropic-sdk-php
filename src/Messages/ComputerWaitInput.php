<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Wait for a specified duration.
 *
 * @phpstan-type ComputerWaitInputShape = array{duration: int}
 */
final class ComputerWaitInput implements BaseModel
{
    /** @use SdkModel<ComputerWaitInputShape> */
    use SdkModel;

    /**
     * Duration to wait, in seconds.
     */
    #[Required]
    public int $duration;

    /**
     * `new ComputerWaitInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ComputerWaitInput::with(duration: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ComputerWaitInput())->withDuration(...)
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
