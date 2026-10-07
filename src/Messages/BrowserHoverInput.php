<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Move the cursor to a coordinate or element without clicking.
 *
 * @phpstan-import-type BrowserClickTargetShape from \Anthropic\Messages\BrowserClickTarget
 * @phpstan-import-type BrowserClickTargetVariants from \Anthropic\Messages\BrowserClickTarget
 *
 * @phpstan-type BrowserHoverInputShape = array{
 *   target: BrowserClickTargetShape, tabID?: string|null
 * }
 */
final class BrowserHoverInput implements BaseModel
{
    /** @use SdkModel<BrowserHoverInputShape> */
    use SdkModel;

    /**
     * Where to act: either a viewport coordinate or an element reference.
     *
     * @var BrowserClickTargetVariants $target
     */
    #[Required(union: BrowserClickTarget::class)]
    public BrowserCoordinateTarget|BrowserRefTarget $target;

    /**
     * Tab to act on. Defaults to the active tab when omitted.
     */
    #[Optional('tab_id', nullable: true)]
    public ?string $tabID;

    /**
     * `new BrowserHoverInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BrowserHoverInput::with(target: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BrowserHoverInput())->withTarget(...)
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
     * Tab to act on. Defaults to the active tab when omitted.
     */
    public function withTabID(?string $tabID): self
    {
        $self = clone $this;
        $self['tabID'] = $tabID;

        return $self;
    }
}
