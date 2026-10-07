<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Set the value of a form element (input, textarea, select, checkbox). Use a
 * boolean for checkboxes, an option value or text for selects.
 *
 * @phpstan-import-type BetaBrowserRefTargetShape from \Anthropic\Beta\Messages\BetaBrowserRefTarget
 * @phpstan-import-type BetaBrowserFormInputValueShape from \Anthropic\Beta\Messages\BetaBrowserFormInputValue
 * @phpstan-import-type BetaBrowserFormInputValueVariants from \Anthropic\Beta\Messages\BetaBrowserFormInputValue
 *
 * @phpstan-type BetaBrowserFormInputInputShape = array{
 *   target: BetaBrowserRefTarget|BetaBrowserRefTargetShape,
 *   value: BetaBrowserFormInputValueShape,
 *   tabID?: string|null,
 * }
 */
final class BetaBrowserFormInputInput implements BaseModel
{
    /** @use SdkModel<BetaBrowserFormInputInputShape> */
    use SdkModel;

    /**
     * An element on the page, identified by a reference from a prior `read_page` or
     * `find` result. References are scoped to the tab that produced them and become
     * stale after navigation or a major re-render.
     */
    #[Required]
    public BetaBrowserRefTarget $target;

    /**
     * The value to set.
     *
     * @var BetaBrowserFormInputValueVariants $value
     */
    #[Required]
    public string|float|bool $value;

    /**
     * Tab to act on. Defaults to the active tab when omitted.
     */
    #[Optional('tab_id', nullable: true)]
    public ?string $tabID;

    /**
     * `new BetaBrowserFormInputInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaBrowserFormInputInput::with(target: ..., value: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaBrowserFormInputInput())->withTarget(...)->withValue(...)
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
     * @param BetaBrowserFormInputValueShape $value
     */
    public static function with(
        BetaBrowserRefTarget|array $target,
        string|float|bool $value,
        ?string $tabID = null,
    ): self {
        $self = new self;

        $self['target'] = $target;
        $self['value'] = $value;

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
     * The value to set.
     *
     * @param BetaBrowserFormInputValueShape $value
     */
    public function withValue(string|float|bool $value): self
    {
        $self = clone $this;
        $self['value'] = $value;

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
