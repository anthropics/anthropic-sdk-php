<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Set the value of a form element (input, textarea, select, checkbox). Use a
 * boolean for checkboxes, an option value or text for selects.
 *
 * @phpstan-import-type BrowserRefTargetShape from \Anthropic\Messages\BrowserRefTarget
 * @phpstan-import-type BrowserFormInputValueShape from \Anthropic\Messages\BrowserFormInputValue
 * @phpstan-import-type BrowserFormInputValueVariants from \Anthropic\Messages\BrowserFormInputValue
 *
 * @phpstan-type BrowserFormInputInputShape = array{
 *   target: BrowserRefTarget|BrowserRefTargetShape,
 *   value: BrowserFormInputValueShape,
 *   tabID?: string|null,
 * }
 */
final class BrowserFormInputInput implements BaseModel
{
    /** @use SdkModel<BrowserFormInputInputShape> */
    use SdkModel;

    /**
     * An element on the page, identified by a reference from a prior `read_page` or
     * `find` result. References are scoped to the tab that produced them and become
     * stale after navigation or a major re-render.
     */
    #[Required]
    public BrowserRefTarget $target;

    /**
     * The value to set.
     *
     * @var BrowserFormInputValueVariants $value
     */
    #[Required]
    public string|float|bool $value;

    /**
     * Tab to act on. Defaults to the active tab when omitted.
     */
    #[Optional('tab_id', nullable: true)]
    public ?string $tabID;

    /**
     * `new BrowserFormInputInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BrowserFormInputInput::with(target: ..., value: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BrowserFormInputInput())->withTarget(...)->withValue(...)
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
     * @param BrowserFormInputValueShape $value
     */
    public static function with(
        BrowserRefTarget|array $target,
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
     * @param BrowserRefTarget|BrowserRefTargetShape $target
     */
    public function withTarget(BrowserRefTarget|array $target): self
    {
        $self = clone $this;
        $self['target'] = $target;

        return $self;
    }

    /**
     * The value to set.
     *
     * @param BrowserFormInputValueShape $value
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
