<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-import-type BetaBrowserLeftMouseUpInputShape from \Anthropic\Beta\Messages\BetaBrowserLeftMouseUpInput
 * @phpstan-import-type BetaToolUseCallerShape from \Anthropic\Beta\Messages\BetaToolUseCaller
 * @phpstan-import-type BetaToolUseCallerVariants from \Anthropic\Beta\Messages\BetaToolUseCaller
 *
 * @phpstan-type BetaBrowserLeftMouseUpToolUseBlockShape = array{
 *   id: string,
 *   input: BetaBrowserLeftMouseUpInput|BetaBrowserLeftMouseUpInputShape,
 *   name: 'left_mouse_up',
 *   toolsetName: 'browser',
 *   type: 'tool_use',
 *   caller?: BetaToolUseCallerShape|null,
 * }
 */
final class BetaBrowserLeftMouseUpToolUseBlock implements BaseModel
{
    /** @use SdkModel<BetaBrowserLeftMouseUpToolUseBlockShape> */
    use SdkModel;

    /** @var 'left_mouse_up' $name */
    #[Required(type: new ConstantOf('left_mouse_up'))]
    public string $name = 'left_mouse_up';

    /** @var 'browser' $toolsetName */
    #[Required('toolset_name', type: new ConstantOf('browser'))]
    public string $toolsetName = 'browser';

    /** @var 'tool_use' $type */
    #[Required(type: new ConstantOf('tool_use'))]
    public string $type = 'tool_use';

    #[Required]
    public string $id;

    /**
     * Release the left mouse button at a viewport coordinate.
     */
    #[Required]
    public BetaBrowserLeftMouseUpInput $input;

    /**
     * Which party invoked the tool call: the model directly, or a server tool on its behalf.
     *
     * @var BetaToolUseCallerVariants|null $caller
     */
    #[Optional(union: BetaToolUseCaller::class)]
    public BetaDirectCaller|BetaServerToolCaller|BetaServerToolCaller20260120|null $caller;

    /**
     * `new BetaBrowserLeftMouseUpToolUseBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaBrowserLeftMouseUpToolUseBlock::with(id: ..., input: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaBrowserLeftMouseUpToolUseBlock())->withID(...)->withInput(...)
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
     * @param BetaBrowserLeftMouseUpInput|BetaBrowserLeftMouseUpInputShape $input
     * @param BetaToolUseCallerShape|null $caller
     */
    public static function with(
        string $id,
        BetaBrowserLeftMouseUpInput|array $input,
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
     * Release the left mouse button at a viewport coordinate.
     *
     * @param BetaBrowserLeftMouseUpInput|BetaBrowserLeftMouseUpInputShape $input
     */
    public function withInput(BetaBrowserLeftMouseUpInput|array $input): self
    {
        $self = clone $this;
        $self['input'] = $input;

        return $self;
    }

    /**
     * @param 'left_mouse_up' $name
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
