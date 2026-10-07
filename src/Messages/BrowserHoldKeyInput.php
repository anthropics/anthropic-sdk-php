<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Hold a key or key chord down for a duration, then release it. Uses the same key
 * names and "+" chord syntax as the key action.
 *
 * @phpstan-type BrowserHoldKeyInputShape = array{
 *   duration: float, text: string, tabID?: string|null
 * }
 */
final class BrowserHoldKeyInput implements BaseModel
{
    /** @use SdkModel<BrowserHoldKeyInputShape> */
    use SdkModel;

    /**
     * Seconds to hold the key down (maximum 30).
     */
    #[Required]
    public float $duration;

    /**
     * The key or chord to hold.
     */
    #[Required]
    public string $text;

    /**
     * Tab to act on. Defaults to the active tab when omitted.
     */
    #[Optional('tab_id', nullable: true)]
    public ?string $tabID;

    /**
     * `new BrowserHoldKeyInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BrowserHoldKeyInput::with(duration: ..., text: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BrowserHoldKeyInput())->withDuration(...)->withText(...)
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
        float $duration,
        string $text,
        ?string $tabID = null
    ): self {
        $self = new self;

        $self['duration'] = $duration;
        $self['text'] = $text;

        null !== $tabID && $self['tabID'] = $tabID;

        return $self;
    }

    /**
     * Seconds to hold the key down (maximum 30).
     */
    public function withDuration(float $duration): self
    {
        $self = clone $this;
        $self['duration'] = $duration;

        return $self;
    }

    /**
     * The key or chord to hold.
     */
    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

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
