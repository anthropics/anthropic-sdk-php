<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-import-type BetaBrowserReadPageInputShape from \Anthropic\Beta\Messages\BetaBrowserReadPageInput
 * @phpstan-import-type BetaToolUseCallerShape from \Anthropic\Beta\Messages\BetaToolUseCaller
 * @phpstan-import-type BetaToolUseCallerVariants from \Anthropic\Beta\Messages\BetaToolUseCaller
 *
 * @phpstan-type BetaBrowserReadPageToolUseBlockShape = array{
 *   id: string,
 *   input: BetaBrowserReadPageInput|BetaBrowserReadPageInputShape,
 *   name: 'read_page',
 *   toolsetName: 'browser',
 *   type: 'tool_use',
 *   caller?: BetaToolUseCallerShape|null,
 * }
 */
final class BetaBrowserReadPageToolUseBlock implements BaseModel
{
    /** @use SdkModel<BetaBrowserReadPageToolUseBlockShape> */
    use SdkModel;

    /** @var 'read_page' $name */
    #[Required(type: new ConstantOf('read_page'))]
    public string $name = 'read_page';

    /** @var 'browser' $toolsetName */
    #[Required('toolset_name', type: new ConstantOf('browser'))]
    public string $toolsetName = 'browser';

    /** @var 'tool_use' $type */
    #[Required(type: new ConstantOf('tool_use'))]
    public string $type = 'tool_use';

    #[Required]
    public string $id;

    /**
     * Return a structured accessibility tree of the page (or the subtree rooted at
     * `ref`), with element references like [ref_7] that can be used as targets on later
     * actions. Output is capped at 50,000 characters — narrow with `ref` or a smaller
     * `depth` when exceeded.
     */
    #[Required]
    public BetaBrowserReadPageInput $input;

    /**
     * Which party invoked the tool call: the model directly, or a server tool on its behalf.
     *
     * @var BetaToolUseCallerVariants|null $caller
     */
    #[Optional(union: BetaToolUseCaller::class)]
    public BetaDirectCaller|BetaServerToolCaller|BetaServerToolCaller20260120|null $caller;

    /**
     * `new BetaBrowserReadPageToolUseBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaBrowserReadPageToolUseBlock::with(id: ..., input: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaBrowserReadPageToolUseBlock())->withID(...)->withInput(...)
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
     * @param BetaBrowserReadPageInput|BetaBrowserReadPageInputShape $input
     * @param BetaToolUseCallerShape|null $caller
     */
    public static function with(
        string $id,
        BetaBrowserReadPageInput|array $input,
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
     * Return a structured accessibility tree of the page (or the subtree rooted at
     * `ref`), with element references like [ref_7] that can be used as targets on later
     * actions. Output is capped at 50,000 characters — narrow with `ref` or a smaller
     * `depth` when exceeded.
     *
     * @param BetaBrowserReadPageInput|BetaBrowserReadPageInputShape $input
     */
    public function withInput(BetaBrowserReadPageInput|array $input): self
    {
        $self = clone $this;
        $self['input'] = $input;

        return $self;
    }

    /**
     * @param 'read_page' $name
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
