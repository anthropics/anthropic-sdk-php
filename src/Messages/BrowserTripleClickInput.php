<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Triple left-click at a viewport coordinate or on an element by reference
 * (typically selects a line or paragraph).
 *
 * @phpstan-import-type BrowserClickTargetShape from \Anthropic\Messages\BrowserClickTarget
 * @phpstan-import-type BrowserClickTargetVariants from \Anthropic\Messages\BrowserClickTarget
 *
 * @phpstan-type BrowserTripleClickInputShape = array{
 *   target: BrowserClickTargetShape, modifiers?: string|null, tabID?: string|null
 * }
 */
final class BrowserTripleClickInput implements BaseModel
{
    /** @use SdkModel<BrowserTripleClickInputShape> */
    use SdkModel;

    /**
     * Where to act: either a viewport coordinate or an element reference.
     *
     * @var BrowserClickTargetVariants $target
     */
    #[Required(union: BrowserClickTarget::class)]
    public BrowserCoordinateTarget|BrowserRefTarget $target;

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
     * `new BrowserTripleClickInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BrowserTripleClickInput::with(target: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BrowserTripleClickInput())->withTarget(...)
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
     * @param BrowserClickTargetShape $target
     */
    public static function with(
        BrowserCoordinateTarget|array|BrowserRefTarget $target,
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
     * @param BrowserClickTargetShape $target
     */
    public function withTarget(
        BrowserCoordinateTarget|array|BrowserRefTarget $target
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
