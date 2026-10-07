<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Type a literal string at the current focus.
 *
 * @phpstan-type BetaBrowserTypeInputShape = array{
 *   text: string, tabID?: string|null
 * }
 */
final class BetaBrowserTypeInput implements BaseModel
{
    /** @use SdkModel<BetaBrowserTypeInputShape> */
    use SdkModel;

    /**
     * The text to type.
     */
    #[Required]
    public string $text;

    /**
     * Tab to act on. Defaults to the active tab when omitted.
     */
    #[Optional('tab_id', nullable: true)]
    public ?string $tabID;

    /**
     * `new BetaBrowserTypeInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaBrowserTypeInput::with(text: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaBrowserTypeInput())->withText(...)
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
    public static function with(string $text, ?string $tabID = null): self
    {
        $self = new self;

        $self['text'] = $text;

        null !== $tabID && $self['tabID'] = $tabID;

        return $self;
    }

    /**
     * The text to type.
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
