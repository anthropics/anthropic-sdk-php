<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Release the left mouse button at a viewport coordinate.
 *
 * @phpstan-import-type BetaBrowserCoordinateTargetShape from \Anthropic\Beta\Messages\BetaBrowserCoordinateTarget
 *
 * @phpstan-type BetaBrowserLeftMouseUpInputShape = array{
 *   target: BetaBrowserCoordinateTarget|BetaBrowserCoordinateTargetShape,
 *   tabID?: string|null,
 * }
 */
final class BetaBrowserLeftMouseUpInput implements BaseModel
{
    /** @use SdkModel<BetaBrowserLeftMouseUpInputShape> */
    use SdkModel;

    /**
     * A point in the browser viewport, in viewport pixels (the same frame as a
     * full-viewport screenshot).
     */
    #[Required]
    public BetaBrowserCoordinateTarget $target;

    /**
     * Tab to act on. Defaults to the active tab when omitted.
     */
    #[Optional('tab_id', nullable: true)]
    public ?string $tabID;

    /**
     * `new BetaBrowserLeftMouseUpInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaBrowserLeftMouseUpInput::with(target: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaBrowserLeftMouseUpInput())->withTarget(...)
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
     * @param BetaBrowserCoordinateTarget|BetaBrowserCoordinateTargetShape $target
     */
    public static function with(
        BetaBrowserCoordinateTarget|array $target,
        ?string $tabID = null
    ): self {
        $self = new self;

        $self['target'] = $target;

        null !== $tabID && $self['tabID'] = $tabID;

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
     * Tab to act on. Defaults to the active tab when omitted.
     */
    public function withTabID(?string $tabID): self
    {
        $self = clone $this;
        $self['tabID'] = $tabID;

        return $self;
    }
}
