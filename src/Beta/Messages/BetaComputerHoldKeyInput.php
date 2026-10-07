<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Hold down a key or key-combination for a specified duration. Uses the same key
 * syntax as `key`.
 *
 * @phpstan-type BetaComputerHoldKeyInputShape = array{duration: int, text: string}
 */
final class BetaComputerHoldKeyInput implements BaseModel
{
    /** @use SdkModel<BetaComputerHoldKeyInputShape> */
    use SdkModel;

    /**
     * Duration to hold the key, in seconds.
     */
    #[Required]
    public int $duration;

    /**
     * The key or key-combination to hold.
     */
    #[Required]
    public string $text;

    /**
     * `new BetaComputerHoldKeyInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaComputerHoldKeyInput::with(duration: ..., text: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaComputerHoldKeyInput())->withDuration(...)->withText(...)
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
    public static function with(int $duration, string $text): self
    {
        $self = new self;

        $self['duration'] = $duration;
        $self['text'] = $text;

        return $self;
    }

    /**
     * Duration to hold the key, in seconds.
     */
    public function withDuration(int $duration): self
    {
        $self = clone $this;
        $self['duration'] = $duration;

        return $self;
    }

    /**
     * The key or key-combination to hold.
     */
    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }
}
