<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Find elements matching a natural-language description (e.g. "search bar", "add to
 * cart button") and return up to 20 matches with element references.
 *
 * @phpstan-type BrowserFindInputShape = array{query: string, tabID?: string|null}
 */
final class BrowserFindInput implements BaseModel
{
    /** @use SdkModel<BrowserFindInputShape> */
    use SdkModel;

    /**
     * Natural-language description of the element(s) to find.
     */
    #[Required]
    public string $query;

    /**
     * Tab to act on. Defaults to the active tab when omitted.
     */
    #[Optional('tab_id', nullable: true)]
    public ?string $tabID;

    /**
     * `new BrowserFindInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BrowserFindInput::with(query: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BrowserFindInput())->withQuery(...)
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
    public static function with(string $query, ?string $tabID = null): self
    {
        $self = new self;

        $self['query'] = $query;

        null !== $tabID && $self['tabID'] = $tabID;

        return $self;
    }

    /**
     * Natural-language description of the element(s) to find.
     */
    public function withQuery(string $query): self
    {
        $self = clone $this;
        $self['query'] = $query;

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
