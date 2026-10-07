<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Press a key or key chord. Use "+" to combine modifiers with a key (e.g. "ctrl+a",
 * "cmd+shift+p") and space to sequence presses (e.g. "Backspace Backspace Delete").
 * Common names like "Return", "Tab", "Escape", "BackSpace" are supported.
 *
 * @phpstan-type BrowserKeyInputShape = array{
 *   text: string, repeat?: int|null, tabID?: string|null
 * }
 */
final class BrowserKeyInput implements BaseModel
{
    /** @use SdkModel<BrowserKeyInputShape> */
    use SdkModel;

    /**
     * The key, chord, or space-separated sequence to press.
     */
    #[Required]
    public string $text;

    /**
     * Number of times to repeat. Default 1.
     */
    #[Optional(nullable: true)]
    public ?int $repeat;

    /**
     * Tab to act on. Defaults to the active tab when omitted.
     */
    #[Optional('tab_id', nullable: true)]
    public ?string $tabID;

    /**
     * `new BrowserKeyInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BrowserKeyInput::with(text: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BrowserKeyInput())->withText(...)
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
        string $text,
        ?int $repeat = null,
        ?string $tabID = null
    ): self {
        $self = new self;

        $self['text'] = $text;

        null !== $repeat && $self['repeat'] = $repeat;
        null !== $tabID && $self['tabID'] = $tabID;

        return $self;
    }

    /**
     * The key, chord, or space-separated sequence to press.
     */
    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    /**
     * Number of times to repeat. Default 1.
     */
    public function withRepeat(?int $repeat): self
    {
        $self = clone $this;
        $self['repeat'] = $repeat;

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
