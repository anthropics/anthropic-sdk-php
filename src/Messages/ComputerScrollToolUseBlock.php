<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-import-type ToolUseCallerShape from \Anthropic\Messages\ToolUseCaller
 * @phpstan-import-type ComputerScrollInputShape from \Anthropic\Messages\ComputerScrollInput
 * @phpstan-import-type ToolUseCallerVariants from \Anthropic\Messages\ToolUseCaller
 *
 * @phpstan-type ComputerScrollToolUseBlockShape = array{
 *   id: string,
 *   caller: ToolUseCallerShape,
 *   input: ComputerScrollInput|ComputerScrollInputShape,
 *   name: 'scroll',
 *   toolsetName: 'computer',
 *   type: 'tool_use',
 * }
 */
final class ComputerScrollToolUseBlock implements BaseModel
{
    /** @use SdkModel<ComputerScrollToolUseBlockShape> */
    use SdkModel;

    /** @var 'scroll' $name */
    #[Required(type: new ConstantOf('scroll'))]
    public string $name = 'scroll';

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
     * Scroll the screen at the specified (x, y) pixel coordinate, or the current cursor
     * position if `coordinate` is omitted. Do NOT use PageUp/PageDown to scroll.
     */
    #[Required]
    public ComputerScrollInput $input;

    /**
     * `new ComputerScrollToolUseBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ComputerScrollToolUseBlock::with(id: ..., caller: ..., input: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ComputerScrollToolUseBlock())->withID(...)->withCaller(...)->withInput(...)
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
     * @param ComputerScrollInput|ComputerScrollInputShape $input
     */
    public static function with(
        string $id,
        DirectCaller|array|ServerToolCaller|ServerToolCaller20260120 $caller,
        ComputerScrollInput|array $input,
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
     * Scroll the screen at the specified (x, y) pixel coordinate, or the current cursor
     * position if `coordinate` is omitted. Do NOT use PageUp/PageDown to scroll.
     *
     * @param ComputerScrollInput|ComputerScrollInputShape $input
     */
    public function withInput(ComputerScrollInput|array $input): self
    {
        $self = clone $this;
        $self['input'] = $input;

        return $self;
    }

    /**
     * @param 'scroll' $name
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
