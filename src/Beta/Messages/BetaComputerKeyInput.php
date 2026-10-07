<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Press a key or key-combination on the keyboard. Use "+" to combine modifiers with
 * a key (e.g. "ctrl+s", "alt+Tab", "ctrl+shift+Escape"). Key names are
 * case-insensitive; common names like "Return", "Tab", "Escape", "Up", "Down",
 * "Left", "Right", "Home", "End", "Page_Up", "Page_Down", "Delete", "BackSpace" are
 * supported.
 *
 * @phpstan-type BetaComputerKeyInputShape = array{text: string, repeat?: int|null}
 */
final class BetaComputerKeyInput implements BaseModel
{
    /** @use SdkModel<BetaComputerKeyInputShape> */
    use SdkModel;

    /**
     * The key or key-combination to press.
     */
    #[Required]
    public string $text;

    /**
     * Number of times to repeat the key press. Default is 1.
     */
    #[Optional(nullable: true)]
    public ?int $repeat;

    /**
     * `new BetaComputerKeyInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaComputerKeyInput::with(text: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaComputerKeyInput())->withText(...)
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
    public static function with(string $text, ?int $repeat = null): self
    {
        $self = new self;

        $self['text'] = $text;

        null !== $repeat && $self['repeat'] = $repeat;

        return $self;
    }

    /**
     * The key or key-combination to press.
     */
    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    /**
     * Number of times to repeat the key press. Default is 1.
     */
    public function withRepeat(?int $repeat): self
    {
        $self = clone $this;
        $self['repeat'] = $repeat;

        return $self;
    }
}
