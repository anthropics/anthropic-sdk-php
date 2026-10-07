<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Release the left mouse button at a viewport coordinate.
 *
 * @phpstan-import-type BrowserCoordinateTargetShape from \Anthropic\Messages\BrowserCoordinateTarget
 *
 * @phpstan-type BrowserLeftMouseUpInputShape = array{
 *   target: BrowserCoordinateTarget|BrowserCoordinateTargetShape,
 *   tabID?: string|null,
 * }
 */
final class BrowserLeftMouseUpInput implements BaseModel
{
    /** @use SdkModel<BrowserLeftMouseUpInputShape> */
    use SdkModel;

    /**
     * A point in the browser viewport, in viewport pixels (the same frame as a
     * full-viewport screenshot).
     */
    #[Required]
    public BrowserCoordinateTarget $target;

    /**
     * Tab to act on. Defaults to the active tab when omitted.
     */
    #[Optional('tab_id', nullable: true)]
    public ?string $tabID;

    /**
     * `new BrowserLeftMouseUpInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BrowserLeftMouseUpInput::with(target: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BrowserLeftMouseUpInput())->withTarget(...)
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
     * @param BrowserCoordinateTarget|BrowserCoordinateTargetShape $target
     */
    public static function with(
        BrowserCoordinateTarget|array $target,
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
     * @param BrowserCoordinateTarget|BrowserCoordinateTargetShape $target
     */
    public function withTarget(BrowserCoordinateTarget|array $target): self
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
