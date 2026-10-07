<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Scroll at a viewport position. `target` must be a coordinate target.
 *
 * @phpstan-import-type BetaBrowserCoordinateTargetShape from \Anthropic\Beta\Messages\BetaBrowserCoordinateTarget
 *
 * @phpstan-type BetaBrowserScrollInputShape = array{
 *   scrollDirection: BetaBrowserScrollDirection|value-of<BetaBrowserScrollDirection>,
 *   target: BetaBrowserCoordinateTarget|BetaBrowserCoordinateTargetShape,
 *   scrollAmount?: int|null,
 *   tabID?: string|null,
 * }
 */
final class BetaBrowserScrollInput implements BaseModel
{
    /** @use SdkModel<BetaBrowserScrollInputShape> */
    use SdkModel;

    /** @var value-of<BetaBrowserScrollDirection> $scrollDirection */
    #[Required('scroll_direction', enum: BetaBrowserScrollDirection::class)]
    public string $scrollDirection;

    /**
     * A point in the browser viewport, in viewport pixels (the same frame as a
     * full-viewport screenshot).
     */
    #[Required]
    public BetaBrowserCoordinateTarget $target;

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
     * `new BetaBrowserScrollInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaBrowserScrollInput::with(scrollDirection: ..., target: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaBrowserScrollInput())->withScrollDirection(...)->withTarget(...)
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
     * @param BetaBrowserScrollDirection|value-of<BetaBrowserScrollDirection> $scrollDirection
     * @param BetaBrowserCoordinateTarget|BetaBrowserCoordinateTargetShape $target
     */
    public static function with(
        BetaBrowserScrollDirection|string $scrollDirection,
        BetaBrowserCoordinateTarget|array $target,
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
     * @param BetaBrowserScrollDirection|value-of<BetaBrowserScrollDirection> $scrollDirection
     */
    public function withScrollDirection(
        BetaBrowserScrollDirection|string $scrollDirection
    ): self {
        $self = clone $this;
        $self['scrollDirection'] = $scrollDirection;

        return $self;
    }

    /**
     * A point in the browser viewport, in viewport pixels (the same frame as a
     * full-viewport screenshot).
     *
     * @param BetaBrowserCoordinateTarget|BetaBrowserCoordinateTargetShape $target
     */
    public function withTarget(BetaBrowserCoordinateTarget|array $target): self
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
