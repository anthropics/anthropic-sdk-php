<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * One open browser tab reported in a `browser_state` block's `tabs`
 * inventory.
 *
 * `tab_id` is the caller-assigned identifier for the tab; `title` and
 * `url` describe the page the tab is currently showing and may be empty
 * strings (a blank tab legitimately has both empty). `active` marks the
 * tab that is active after this call; whenever `tabs` is non-empty,
 * exactly one entry is marked.
 *
 * @phpstan-type BetaBrowserStateTabEntryShape = array{
 *   tabID: string, title: string, url: string, active?: bool|null
 * }
 */
final class BetaBrowserStateTabEntry implements BaseModel
{
    /** @use SdkModel<BetaBrowserStateTabEntryShape> */
    use SdkModel;

    /**
     * The caller-assigned identifier for this tab, unique within the inventory.
     */
    #[Required('tab_id')]
    public string $tabID;

    /**
     * The title of the page the tab is showing. May be empty.
     */
    #[Required]
    public string $title;

    /**
     * The URL of the page the tab is showing. May be empty.
     */
    #[Required]
    public string $url;

    /**
     * Whether this tab is the active tab after this call. Whenever `tabs` is non-empty, exactly one entry is marked `active: true`.
     */
    #[Optional]
    public ?bool $active;

    /**
     * `new BetaBrowserStateTabEntry()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaBrowserStateTabEntry::with(tabID: ..., title: ..., url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaBrowserStateTabEntry)->withTabID(...)->withTitle(...)->withURL(...)
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
        string $tabID,
        string $title,
        string $url,
        ?bool $active = null
    ): self {
        $self = new self;

        $self['tabID'] = $tabID;
        $self['title'] = $title;
        $self['url'] = $url;

        null !== $active && $self['active'] = $active;

        return $self;
    }

    /**
     * The caller-assigned identifier for this tab, unique within the inventory.
     */
    public function withTabID(string $tabID): self
    {
        $self = clone $this;
        $self['tabID'] = $tabID;

        return $self;
    }

    /**
     * The title of the page the tab is showing. May be empty.
     */
    public function withTitle(string $title): self
    {
        $self = clone $this;
        $self['title'] = $title;

        return $self;
    }

    /**
     * The URL of the page the tab is showing. May be empty.
     */
    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    /**
     * Whether this tab is the active tab after this call. Whenever `tabs` is non-empty, exactly one entry is marked `active: true`.
     */
    public function withActive(bool $active): self
    {
        $self = clone $this;
        $self['active'] = $active;

        return $self;
    }
}
