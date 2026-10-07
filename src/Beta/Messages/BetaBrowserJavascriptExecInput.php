<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Execute JavaScript in the page context and return the value of the last
 * expression. The code runs with access to the DOM, `window`, and page variables.
 * Write the expression you want evaluated — do NOT use `return`.
 *
 * @phpstan-type BetaBrowserJavascriptExecInputShape = array{
 *   text: string, tabID?: string|null
 * }
 */
final class BetaBrowserJavascriptExecInput implements BaseModel
{
    /** @use SdkModel<BetaBrowserJavascriptExecInputShape> */
    use SdkModel;

    /**
     * JavaScript to execute in the page context.
     */
    #[Required]
    public string $text;

    /**
     * Tab to act on. Defaults to the active tab when omitted.
     */
    #[Optional('tab_id', nullable: true)]
    public ?string $tabID;

    /**
     * `new BetaBrowserJavascriptExecInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaBrowserJavascriptExecInput::with(text: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaBrowserJavascriptExecInput())->withText(...)
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
     * JavaScript to execute in the page context.
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
