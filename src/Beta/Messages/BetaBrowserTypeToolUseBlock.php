<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-import-type BetaBrowserTypeInputShape from \Anthropic\Beta\Messages\BetaBrowserTypeInput
 * @phpstan-import-type BetaToolUseCallerShape from \Anthropic\Beta\Messages\BetaToolUseCaller
 * @phpstan-import-type BetaToolUseCallerVariants from \Anthropic\Beta\Messages\BetaToolUseCaller
 *
 * @phpstan-type BetaBrowserTypeToolUseBlockShape = array{
 *   id: string,
 *   input: BetaBrowserTypeInput|BetaBrowserTypeInputShape,
 *   name: 'type',
 *   toolsetName: 'browser',
 *   type: 'tool_use',
 *   caller?: BetaToolUseCallerShape|null,
 * }
 */
final class BetaBrowserTypeToolUseBlock implements BaseModel
{
    /** @use SdkModel<BetaBrowserTypeToolUseBlockShape> */
    use SdkModel;

    /** @var 'type' $name */
    #[Required(type: new ConstantOf('type'))]
    public string $name = 'type';

    /** @var 'browser' $toolsetName */
    #[Required('toolset_name', type: new ConstantOf('browser'))]
    public string $toolsetName = 'browser';

    /** @var 'tool_use' $type */
    #[Required(type: new ConstantOf('tool_use'))]
    public string $type = 'tool_use';

    #[Required]
    public string $id;

    /**
     * Type a literal string at the current focus.
     */
    #[Required]
    public BetaBrowserTypeInput $input;

    /**
     * Which party invoked the tool call: the model directly, or a server tool on its behalf.
     *
     * @var BetaToolUseCallerVariants|null $caller
     */
    #[Optional(union: BetaToolUseCaller::class)]
    public BetaDirectCaller|BetaServerToolCaller|BetaServerToolCaller20260120|null $caller;

    /**
     * `new BetaBrowserTypeToolUseBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaBrowserTypeToolUseBlock::with(id: ..., input: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaBrowserTypeToolUseBlock())->withID(...)->withInput(...)
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
     * @param BetaBrowserTypeInput|BetaBrowserTypeInputShape $input
     * @param BetaToolUseCallerShape|null $caller
     */
    public static function with(
        string $id,
        BetaBrowserTypeInput|array $input,
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
     * Type a literal string at the current focus.
     *
     * @param BetaBrowserTypeInput|BetaBrowserTypeInputShape $input
     */
    public function withInput(BetaBrowserTypeInput|array $input): self
    {
        $self = clone $this;
        $self['input'] = $input;

        return $self;
    }

    /**
     * @param 'type' $name
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
