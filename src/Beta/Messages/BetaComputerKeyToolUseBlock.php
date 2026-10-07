<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-import-type BetaComputerKeyInputShape from \Anthropic\Beta\Messages\BetaComputerKeyInput
 * @phpstan-import-type BetaToolUseCallerShape from \Anthropic\Beta\Messages\BetaToolUseCaller
 * @phpstan-import-type BetaToolUseCallerVariants from \Anthropic\Beta\Messages\BetaToolUseCaller
 *
 * @phpstan-type BetaComputerKeyToolUseBlockShape = array{
 *   id: string,
 *   input: BetaComputerKeyInput|BetaComputerKeyInputShape,
 *   name: 'key',
 *   toolsetName: 'computer',
 *   type: 'tool_use',
 *   caller?: BetaToolUseCallerShape|null,
 * }
 */
final class BetaComputerKeyToolUseBlock implements BaseModel
{
    /** @use SdkModel<BetaComputerKeyToolUseBlockShape> */
    use SdkModel;

    /** @var 'key' $name */
    #[Required(type: new ConstantOf('key'))]
    public string $name = 'key';

    /** @var 'computer' $toolsetName */
    #[Required('toolset_name', type: new ConstantOf('computer'))]
    public string $toolsetName = 'computer';

    /** @var 'tool_use' $type */
    #[Required(type: new ConstantOf('tool_use'))]
    public string $type = 'tool_use';

    #[Required]
    public string $id;

    /**
     * Press a key or key-combination on the keyboard. Use "+" to combine modifiers with
     * a key (e.g. "ctrl+s", "alt+Tab", "ctrl+shift+Escape"). Key names are
     * case-insensitive; common names like "Return", "Tab", "Escape", "Up", "Down",
     * "Left", "Right", "Home", "End", "Page_Up", "Page_Down", "Delete", "BackSpace" are
     * supported.
     */
    #[Required]
    public BetaComputerKeyInput $input;

    /**
     * Which party invoked the tool call: the model directly, or a server tool on its behalf.
     *
     * @var BetaToolUseCallerVariants|null $caller
     */
    #[Optional(union: BetaToolUseCaller::class)]
    public BetaDirectCaller|BetaServerToolCaller|BetaServerToolCaller20260120|null $caller;

    /**
     * `new BetaComputerKeyToolUseBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaComputerKeyToolUseBlock::with(id: ..., input: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaComputerKeyToolUseBlock())->withID(...)->withInput(...)
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
     * @param BetaComputerKeyInput|BetaComputerKeyInputShape $input
     * @param BetaToolUseCallerShape|null $caller
     */
    public static function with(
        string $id,
        BetaComputerKeyInput|array $input,
        BetaDirectCaller|array|BetaServerToolCaller|BetaServerToolCaller20260120|null $caller = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['input'] = $input;

        null !== $caller && $self['caller'] = $caller;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Press a key or key-combination on the keyboard. Use "+" to combine modifiers with
     * a key (e.g. "ctrl+s", "alt+Tab", "ctrl+shift+Escape"). Key names are
     * case-insensitive; common names like "Return", "Tab", "Escape", "Up", "Down",
     * "Left", "Right", "Home", "End", "Page_Up", "Page_Down", "Delete", "BackSpace" are
     * supported.
     *
     * @param BetaComputerKeyInput|BetaComputerKeyInputShape $input
     */
    public function withInput(BetaComputerKeyInput|array $input): self
    {
        $self = clone $this;
        $self['input'] = $input;

        return $self;
    }

    /**
     * @param 'key' $name
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * @param 'computer' $toolsetName
     */
    public function withToolsetName(string $toolsetName): self
    {
        $self = clone $this;
        $self['toolsetName'] = $toolsetName;

        return $self;
    }

    /**
     * @param 'tool_use' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Which party invoked the tool call: the model directly, or a server tool on its behalf.
     *
     * @param BetaToolUseCallerShape $caller
     */
    public function withCaller(
        BetaDirectCaller|array|BetaServerToolCaller|BetaServerToolCaller20260120 $caller,
    ): self {
        $self = clone $this;
        $self['caller'] = $caller;

        return $self;
    }
}
