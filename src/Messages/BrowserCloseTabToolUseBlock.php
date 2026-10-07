<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-import-type ToolUseCallerShape from \Anthropic\Messages\ToolUseCaller
 * @phpstan-import-type BrowserCloseTabInputShape from \Anthropic\Messages\BrowserCloseTabInput
 * @phpstan-import-type ToolUseCallerVariants from \Anthropic\Messages\ToolUseCaller
 *
 * @phpstan-type BrowserCloseTabToolUseBlockShape = array{
 *   id: string,
 *   caller: ToolUseCallerShape,
 *   input: BrowserCloseTabInput|BrowserCloseTabInputShape,
 *   name: 'close_tab',
 *   toolsetName: 'browser',
 *   type: 'tool_use',
 * }
 */
final class BrowserCloseTabToolUseBlock implements BaseModel
{
    /** @use SdkModel<BrowserCloseTabToolUseBlockShape> */
    use SdkModel;

    /** @var 'close_tab' $name */
    #[Required(type: new ConstantOf('close_tab'))]
    public string $name = 'close_tab';

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
     * Close the tab with the given tab_id.
     */
    #[Required]
    public BrowserCloseTabInput $input;

    /**
     * `new BrowserCloseTabToolUseBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BrowserCloseTabToolUseBlock::with(id: ..., caller: ..., input: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BrowserCloseTabToolUseBlock())
     *   ->withID(...)
     *   ->withCaller(...)
     *   ->withInput(...)
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
     * @param BrowserCloseTabInput|BrowserCloseTabInputShape $input
     */
    public static function with(
        string $id,
        DirectCaller|array|ServerToolCaller|ServerToolCaller20260120 $caller,
        BrowserCloseTabInput|array $input,
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
     * Close the tab with the given tab_id.
     *
     * @param BrowserCloseTabInput|BrowserCloseTabInputShape $input
     */
    public function withInput(BrowserCloseTabInput|array $input): self
    {
        $self = clone $this;
        $self['input'] = $input;

        return $self;
    }

    /**
     * @param 'close_tab' $name
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
