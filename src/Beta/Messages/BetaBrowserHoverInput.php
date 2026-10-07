<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Move the cursor to a coordinate or element without clicking.
 *
 * @phpstan-import-type BetaBrowserClickTargetShape from \Anthropic\Beta\Messages\BetaBrowserClickTarget
 * @phpstan-import-type BetaBrowserClickTargetVariants from \Anthropic\Beta\Messages\BetaBrowserClickTarget
 *
 * @phpstan-type BetaBrowserHoverInputShape = array{
 *   target: BetaBrowserClickTargetShape, tabID?: string|null
 * }
 */
final class BetaBrowserHoverInput implements BaseModel
{
    /** @use SdkModel<BetaBrowserHoverInputShape> */
    use SdkModel;

    /**
     * Where to act: either a viewport coordinate or an element reference.
     *
     * @var BetaBrowserClickTargetVariants $target
     */
    #[Required(union: BetaBrowserClickTarget::class)]
    public BetaBrowserCoordinateTarget|BetaBrowserRefTarget $target;

    /**
     * Tab to act on. Defaults to the active tab when omitted.
     */
    #[Optional('tab_id', nullable: true)]
    public ?string $tabID;

    /**
     * `new BetaBrowserHoverInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaBrowserHoverInput::with(target: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaBrowserHoverInput())->withTarget(...)
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
     * @param BetaBrowserClickTargetShape $target
     */
    public static function with(
        BetaBrowserCoordinateTarget|array|BetaBrowserRefTarget $target,
        ?string $tabID = null,
    ): self {
        $self = new self;

        $self['target'] = $target;

        null !== $tabID && $self['tabID'] = $tabID;

        return $self;
    }

    /**
     * Where to act: either a viewport coordinate or an element reference.
     *
     * @param BetaBrowserClickTargetShape $target
     */
    public function withTarget(
        BetaBrowserCoordinateTarget|array|BetaBrowserRefTarget $target
    ): self {
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
