<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Scroll at a viewport position. `target` must be a coordinate target.
 *
 * @phpstan-import-type BrowserCoordinateTargetShape from \Anthropic\Messages\BrowserCoordinateTarget
 *
 * @phpstan-type BrowserScrollInputShape = array{
 *   scrollDirection: BrowserScrollDirection|value-of<BrowserScrollDirection>,
 *   target: BrowserCoordinateTarget|BrowserCoordinateTargetShape,
 *   scrollAmount?: int|null,
 *   tabID?: string|null,
 * }
 */
final class BrowserScrollInput implements BaseModel
{
    /** @use SdkModel<BrowserScrollInputShape> */
    use SdkModel;

    /** @var value-of<BrowserScrollDirection> $scrollDirection */
    #[Required('scroll_direction', enum: BrowserScrollDirection::class)]
    public string $scrollDirection;

    /**
     * A point in the browser viewport, in viewport pixels (the same frame as a
     * full-viewport screenshot).
     */
    #[Required]
    public BrowserCoordinateTarget $target;

    /**
     * Scroll-wheel notches (1–10). Default 3.
     */
    #[Optional('scroll_amount', nullable: true)]
    public ?int $scrollAmount;

    /**
     * Tab to act on. Defaults to the active tab when omitted.
     */
    #[Optional('tab_id', nullable: true)]
    public ?string $tabID;

    /**
     * `new BrowserScrollInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BrowserScrollInput::with(scrollDirection: ..., target: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BrowserScrollInput())->withScrollDirection(...)->withTarget(...)
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
     *
     * @param BrowserScrollDirection|value-of<BrowserScrollDirection> $scrollDirection
     * @param BrowserCoordinateTarget|BrowserCoordinateTargetShape $target
     */
    public static function with(
        BrowserScrollDirection|string $scrollDirection,
        BrowserCoordinateTarget|array $target,
        ?int $scrollAmount = null,
        ?string $tabID = null,
    ): self {
        $self = new self;

        $self['scrollDirection'] = $scrollDirection;
        $self['target'] = $target;

        null !== $scrollAmount && $self['scrollAmount'] = $scrollAmount;
        null !== $tabID && $self['tabID'] = $tabID;

        return $self;
    }

    /**
     * @param BrowserScrollDirection|value-of<BrowserScrollDirection> $scrollDirection
     */
    public function withScrollDirection(
        BrowserScrollDirection|string $scrollDirection
    ): self {
        $self = clone $this;
        $self['scrollDirection'] = $scrollDirection;

        return $self;
    }

    /**
     * A point in the browser viewport, in viewport pixels (the same frame as a
     * full-viewport screenshot).
     *
     * @param BrowserCoordinateTarget|BrowserCoordinateTargetShape $target
     */
    public function withTarget(BrowserCoordinateTarget|array $target): self
    {
        $self = clone $this;
        $self['target'] = $target;

        return $self;
    }

    /**
     * Scroll-wheel notches (1–10). Default 3.
     */
    public function withScrollAmount(?int $scrollAmount): self
    {
        $self = clone $this;
        $self['scrollAmount'] = $scrollAmount;

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
