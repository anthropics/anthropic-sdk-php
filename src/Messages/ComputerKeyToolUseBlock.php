<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-import-type ToolUseCallerShape from \Anthropic\Messages\ToolUseCaller
 * @phpstan-import-type ComputerKeyInputShape from \Anthropic\Messages\ComputerKeyInput
 * @phpstan-import-type ToolUseCallerVariants from \Anthropic\Messages\ToolUseCaller
 *
 * @phpstan-type ComputerKeyToolUseBlockShape = array{
 *   id: string,
 *   caller: ToolUseCallerShape,
 *   input: ComputerKeyInput|ComputerKeyInputShape,
 *   name: 'key',
 *   toolsetName: 'computer',
 *   type: 'tool_use',
 * }
 */
final class ComputerKeyToolUseBlock implements BaseModel
{
    /** @use SdkModel<ComputerKeyToolUseBlockShape> */
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
     * Which party invoked the tool call: the model directly, or a server tool on its behalf.
     *
     * @var ToolUseCallerVariants $caller
     */
    #[Required(union: ToolUseCaller::class)]
    public DirectCaller|ServerToolCaller|ServerToolCaller20260120 $caller;

    /**
     * Press a key or key-combination on the keyboard. Use "+" to combine modifiers with
     * a key (e.g. "ctrl+s", "alt+Tab", "ctrl+shift+Escape"). Key names are
     * case-insensitive; common names like "Return", "Tab", "Escape", "Up", "Down",
     * "Left", "Right", "Home", "End", "Page_Up", "Page_Down", "Delete", "BackSpace" are
     * supported.
     */
    #[Required]
    public ComputerKeyInput $input;

    /**
     * `new ComputerKeyToolUseBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ComputerKeyToolUseBlock::with(id: ..., caller: ..., input: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ComputerKeyToolUseBlock())->withID(...)->withCaller(...)->withInput(...)
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
     * @param ToolUseCallerShape $caller
     * @param ComputerKeyInput|ComputerKeyInputShape $input
     */
    public static function with(
        string $id,
        DirectCaller|array|ServerToolCaller|ServerToolCaller20260120 $caller,
        ComputerKeyInput|array $input,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['caller'] = $caller;
        $self['input'] = $input;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Which party invoked the tool call: the model directly, or a server tool on its behalf.
     *
     * @param ToolUseCallerShape $caller
     */
    public function withCaller(
        DirectCaller|array|ServerToolCaller|ServerToolCaller20260120 $caller
    ): self {
        $self = clone $this;
        $self['caller'] = $caller;

        return $self;
    }

    /**
     * Press a key or key-combination on the keyboard. Use "+" to combine modifiers with
     * a key (e.g. "ctrl+s", "alt+Tab", "ctrl+shift+Escape"). Key names are
     * case-insensitive; common names like "Return", "Tab", "Escape", "Up", "Down",
     * "Left", "Right", "Home", "End", "Page_Up", "Page_Down", "Delete", "BackSpace" are
     * supported.
     *
     * @param ComputerKeyInput|ComputerKeyInputShape $input
     */
    public function withInput(ComputerKeyInput|array $input): self
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
}
