<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Navigate to a URL, or go back/forward/reload in history. The protocol may be
 * omitted (defaults to https://).
 *
 * @phpstan-type BetaBrowserNavigateInputShape = array{
 *   url: string, tabID?: string|null
 * }
 */
final class BetaBrowserNavigateInput implements BaseModel
{
    /** @use SdkModel<BetaBrowserNavigateInputShape> */
    use SdkModel;

    /**
     * The URL to navigate to, or "back" / "forward" / "reload" for history navigation.
     */
    #[Required]
    public string $url;

    /**
     * Tab to act on. Defaults to the active tab when omitted.
     */
    #[Optional('tab_id', nullable: true)]
    public ?string $tabID;

    /**
     * `new BetaBrowserNavigateInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaBrowserNavigateInput::with(url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaBrowserNavigateInput())->withURL(...)
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
    public static function with(string $url, ?string $tabID = null): self
    {
        $self = new self;

        $self['url'] = $url;

        null !== $tabID && $self['tabID'] = $tabID;

        return $self;
    }

    /**
     * The URL to navigate to, or "back" / "forward" / "reload" for history navigation.
     */
    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

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
