<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Scroll an element into view.
 *
 * @phpstan-import-type BrowserRefTargetShape from \Anthropic\Messages\BrowserRefTarget
 *
 * @phpstan-type BrowserScrollToInputShape = array{
 *   target: BrowserRefTarget|BrowserRefTargetShape, tabID?: string|null
 * }
 */
final class BrowserScrollToInput implements BaseModel
{
    /** @use SdkModel<BrowserScrollToInputShape> */
    use SdkModel;

    /**
     * An element on the page, identified by a reference from a prior `read_page` or
     * `find` result. References are scoped to the tab that produced them and become
     * stale after navigation or a major re-render.
     */
    #[Required]
    public BrowserRefTarget $target;

    /**
     * Tab to act on. Defaults to the active tab when omitted.
     */
    #[Optional('tab_id', nullable: true)]
    public ?string $tabID;

    /**
     * `new BrowserScrollToInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BrowserScrollToInput::with(target: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BrowserScrollToInput())->withTarget(...)
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
     * @param BrowserRefTarget|BrowserRefTargetShape $target
     */
    public static function with(
        BrowserRefTarget|array $target,
        ?string $tabID = null
    ): self {
        $self = new self;

        $self['target'] = $target;

        null !== $tabID && $self['tabID'] = $tabID;

        return $self;
    }

    /**
     * An element on the page, identified by a reference from a prior `read_page` or
     * `find` result. References are scoped to the tab that produced them and become
     * stale after navigation or a major re-render.
     *
     * @param BrowserRefTarget|BrowserRefTargetShape $target
     */
    public function withTarget(BrowserRefTarget|array $target): self
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
