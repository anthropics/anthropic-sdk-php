<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-import-type ToolUseCallerShape from \Anthropic\Messages\ToolUseCaller
 * @phpstan-import-type BrowserScreenshotInputShape from \Anthropic\Messages\BrowserScreenshotInput
 * @phpstan-import-type ToolUseCallerVariants from \Anthropic\Messages\ToolUseCaller
 *
 * @phpstan-type BrowserScreenshotToolUseBlockShape = array{
 *   id: string,
 *   caller: ToolUseCallerShape,
 *   input: BrowserScreenshotInput|BrowserScreenshotInputShape,
 *   name: 'screenshot',
 *   toolsetName: 'browser',
 *   type: 'tool_use',
 * }
 */
final class BrowserScreenshotToolUseBlock implements BaseModel
{
    /** @use SdkModel<BrowserScreenshotToolUseBlockShape> */
    use SdkModel;

    /** @var 'screenshot' $name */
    #[Required(type: new ConstantOf('screenshot'))]
    public string $name = 'screenshot';

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
     * Capture the current browser viewport.
     */
    #[Required]
    public BrowserScreenshotInput $input;

    /**
     * `new BrowserScreenshotToolUseBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BrowserScreenshotToolUseBlock::with(id: ..., caller: ..., input: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BrowserScreenshotToolUseBlock())
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
     * @param BrowserScreenshotInput|BrowserScreenshotInputShape $input
     */
    public static function with(
        string $id,
        DirectCaller|array|ServerToolCaller|ServerToolCaller20260120 $caller,
        BrowserScreenshotInput|array $input,
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
     * Capture the current browser viewport.
     *
     * @param BrowserScreenshotInput|BrowserScreenshotInputShape $input
     */
    public function withInput(BrowserScreenshotInput|array $input): self
    {
        $self = clone $this;
        $self['input'] = $input;

        return $self;
    }

    /**
     * @param 'screenshot' $name
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
