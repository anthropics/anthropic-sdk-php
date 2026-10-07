<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Double left-click at a viewport coordinate or on an element by reference.
 *
 * @phpstan-import-type BetaBrowserClickTargetShape from \Anthropic\Beta\Messages\BetaBrowserClickTarget
 * @phpstan-import-type BetaBrowserClickTargetVariants from \Anthropic\Beta\Messages\BetaBrowserClickTarget
 *
 * @phpstan-type BetaBrowserDoubleClickInputShape = array{
 *   target: BetaBrowserClickTargetShape,
 *   modifiers?: string|null,
 *   tabID?: string|null,
 * }
 */
final class BetaBrowserDoubleClickInput implements BaseModel
{
    /** @use SdkModel<BetaBrowserDoubleClickInputShape> */
    use SdkModel;

    /**
     * Where to act: either a viewport coordinate or an element reference.
     *
     * @var BetaBrowserClickTargetVariants $target
     */
    #[Required(union: BetaBrowserClickTarget::class)]
    public BetaBrowserCoordinateTarget|BetaBrowserRefTarget $target;

    /**
     * Optional modifier key chord to hold for the duration of this action (e.g. "shift", "ctrl+shift", "cmd+alt").
     */
    #[Optional(nullable: true)]
    public ?string $modifiers;

    /**
     * Tab to act on. Defaults to the active tab when omitted.
     */
    #[Optional('tab_id', nullable: true)]
    public ?string $tabID;

    /**
     * `new BetaBrowserDoubleClickInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaBrowserDoubleClickInput::with(target: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaBrowserDoubleClickInput())->withTarget(...)
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
        ?string $modifiers = null,
        ?string $tabID = null,
    ): self {
        $self = new self;

        $self['target'] = $target;

        null !== $modifiers && $self['modifiers'] = $modifiers;
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
     * Optional modifier key chord to hold for the duration of this action (e.g. "shift", "ctrl+shift", "cmd+alt").
     */
    public function withModifiers(?string $modifiers): self
    {
        $self = clone $this;
        $self['modifiers'] = $modifiers;

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
