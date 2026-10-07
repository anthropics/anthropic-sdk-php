<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Scroll an element into view.
 *
 * @phpstan-import-type BetaBrowserRefTargetShape from \Anthropic\Beta\Messages\BetaBrowserRefTarget
 *
 * @phpstan-type BetaBrowserScrollToInputShape = array{
 *   target: BetaBrowserRefTarget|BetaBrowserRefTargetShape, tabID?: string|null
 * }
 */
final class BetaBrowserScrollToInput implements BaseModel
{
    /** @use SdkModel<BetaBrowserScrollToInputShape> */
    use SdkModel;

    /**
     * An element on the page, identified by a reference from a prior `read_page` or
     * `find` result. References are scoped to the tab that produced them and become
     * stale after navigation or a major re-render.
     */
    #[Required]
    public BetaBrowserRefTarget $target;

    /**
     * Tab to act on. Defaults to the active tab when omitted.
     */
    #[Optional('tab_id', nullable: true)]
    public ?string $tabID;

    /**
     * `new BetaBrowserScrollToInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaBrowserScrollToInput::with(target: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaBrowserScrollToInput())->withTarget(...)
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
     * @param BetaBrowserRefTarget|BetaBrowserRefTargetShape $target
     */
    public static function with(
        BetaBrowserRefTarget|array $target,
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
     * @param BetaBrowserRefTarget|BetaBrowserRefTargetShape $target
     */
    public function withTarget(BetaBrowserRefTarget|array $target): self
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
