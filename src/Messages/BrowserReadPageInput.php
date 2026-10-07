<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Return a structured accessibility tree of the page (or the subtree rooted at
 * `ref`), with element references like [ref_7] that can be used as targets on later
 * actions. Output is capped at 50,000 characters — narrow with `ref` or a smaller
 * `depth` when exceeded.
 *
 * @phpstan-type BrowserReadPageInputShape = array{
 *   depth?: int|null,
 *   filter?: null|BrowserReadPageFilter|value-of<BrowserReadPageFilter>,
 *   ref?: string|null,
 *   tabID?: string|null,
 * }
 */
final class BrowserReadPageInput implements BaseModel
{
    /** @use SdkModel<BrowserReadPageInputShape> */
    use SdkModel;

    /**
     * Maximum tree depth. Default 15.
     */
    #[Optional(nullable: true)]
    public ?int $depth;

    /**
     * Which elements to include. Omitted: every visible element. "interactive": interactive elements only. "all": additionally includes off-viewport elements.
     *
     * @var value-of<BrowserReadPageFilter>|null $filter
     */
    #[Optional(enum: BrowserReadPageFilter::class, nullable: true)]
    public ?string $filter;

    /**
     * Element reference to read a subtree from. Omit to read from the page root.
     */
    #[Optional(nullable: true)]
    public ?string $ref;

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
     *
     * @param BrowserReadPageFilter|value-of<BrowserReadPageFilter>|null $filter
     */
    public static function with(
        ?int $depth = null,
        BrowserReadPageFilter|string|null $filter = null,
        ?string $ref = null,
        ?string $tabID = null,
    ): self {
        $self = new self;

        null !== $depth && $self['depth'] = $depth;
        null !== $filter && $self['filter'] = $filter;
        null !== $ref && $self['ref'] = $ref;
        null !== $tabID && $self['tabID'] = $tabID;

        return $self;
    }

    /**
     * Maximum tree depth. Default 15.
     */
    public function withDepth(?int $depth): self
    {
        $self = clone $this;
        $self['depth'] = $depth;

        return $self;
    }

    /**
     * Which elements to include. Omitted: every visible element. "interactive": interactive elements only. "all": additionally includes off-viewport elements.
     *
     * @param BrowserReadPageFilter|value-of<BrowserReadPageFilter>|null $filter
     */
    public function withFilter(BrowserReadPageFilter|string|null $filter): self
    {
        $self = clone $this;
        $self['filter'] = $filter;

        return $self;
    }

    /**
     * Element reference to read a subtree from. Omit to read from the page root.
     */
    public function withRef(?string $ref): self
    {
        $self = clone $this;
        $self['ref'] = $ref;

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
