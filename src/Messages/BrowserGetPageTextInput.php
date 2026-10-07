<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Return the page's visible text content as plain text, prioritizing article
 * content. Suited to articles, documentation, and other text-heavy pages.
 *
 * @phpstan-type BrowserGetPageTextInputShape = array{tabID?: string|null}
 */
final class BrowserGetPageTextInput implements BaseModel
{
    /** @use SdkModel<BrowserGetPageTextInputShape> */
    use SdkModel;

    /**
     * Tab to act on. Defaults to the active tab when omitted.
     */
    #[Optional('tab_id', nullable: true)]
    public ?string $tabID;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $tabID = null): self
    {
        $self = new self;

        null !== $tabID && $self['tabID'] = $tabID;

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
