<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-import-type ToolUseCallerShape from \Anthropic\Messages\ToolUseCaller
 * @phpstan-import-type BrowserHoverInputShape from \Anthropic\Messages\BrowserHoverInput
 * @phpstan-import-type ToolUseCallerVariants from \Anthropic\Messages\ToolUseCaller
 *
 * @phpstan-type BrowserHoverToolUseBlockShape = array{
 *   id: string,
 *   caller: ToolUseCallerShape,
 *   input: BrowserHoverInput|BrowserHoverInputShape,
 *   name: 'hover',
 *   toolsetName: 'browser',
 *   type: 'tool_use',
 * }
 */
final class BrowserHoverToolUseBlock implements BaseModel
{
    /** @use SdkModel<BrowserHoverToolUseBlockShape> */
    use SdkModel;

    /** @var 'hover' $name */
    #[Required(type: new ConstantOf('hover'))]
    public string $name = 'hover';

    /** @var 'browser' $toolsetName */
    #[Required('toolset_name', type: new ConstantOf('browser'))]
    public string $toolsetName = 'browser';

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
     * Move the cursor to a coordinate or element without clicking.
     */
    #[Required]
    public BrowserHoverInput $input;

    /**
     * `new BrowserHoverToolUseBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BrowserHoverToolUseBlock::with(id: ..., caller: ..., input: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BrowserHoverToolUseBlock())->withID(...)->withCaller(...)->withInput(...)
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
     * @param BrowserHoverInput|BrowserHoverInputShape $input
     */
    public static function with(
        string $id,
        DirectCaller|array|ServerToolCaller|ServerToolCaller20260120 $caller,
        BrowserHoverInput|array $input,
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
     * Move the cursor to a coordinate or element without clicking.
     *
     * @param BrowserHoverInput|BrowserHoverInputShape $input
     */
    public function withInput(BrowserHoverInput|array $input): self
    {
        $self = clone $this;
        $self['input'] = $input;

        return $self;
    }

    /**
     * @param 'hover' $name
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * @param 'browser' $toolsetName
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
