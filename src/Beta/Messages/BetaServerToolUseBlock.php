<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaServerToolUseBlock\Caller;
use Anthropic\Beta\Messages\BetaServerToolUseBlock\Name;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaServerToolUseBlockShape = array{
 *   id: string,
 *   caller: BetaDirectCaller|BetaServerToolCaller,
 *   input: array<string,mixed>,
 *   name: value-of<Name>,
 *   type?: 'server_tool_use',
 * }
 */
final class BetaServerToolUseBlock implements BaseModel
{
    /** @use SdkModel<BetaServerToolUseBlockShape> */
    use SdkModel;

    /** @var 'server_tool_use' $type */
    #[Required]
    public string $type = 'server_tool_use';

    #[Required]
    public string $id;

    /**
     * Tool invocation directly from the model.
     */
    #[Required(union: Caller::class)]
    public BetaDirectCaller|BetaServerToolCaller $caller;

    /** @var array<string,mixed> $input */
    #[Required(map: 'mixed')]
    public array $input;

    /** @var value-of<Name> $name */
    #[Required(enum: Name::class)]
    public string $name;

    /**
     * `new BetaServerToolUseBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaServerToolUseBlock::with(id: ..., caller: ..., input: ..., name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaServerToolUseBlock)
     *   ->withID(...)
     *   ->withCaller(...)
     *   ->withInput(...)
     *   ->withName(...)
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
     * @param array<string,mixed> $input
     * @param Name|value-of<Name> $name
     * @param BetaDirectCaller|array{type?: 'direct'}|BetaServerToolCaller|array{
     *   toolID: string, type?: 'code_execution_20250825'
     * } $caller
     */
    public static function with(
        string $id,
        array $input,
        Name|string $name,
        BetaDirectCaller|array|BetaServerToolCaller $caller = ['type' => 'direct'],
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['caller'] = $caller;
        $self['input'] = $input;
        $self['name'] = $name;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Tool invocation directly from the model.
     *
     * @param BetaDirectCaller|array{type?: 'direct'}|BetaServerToolCaller|array{
     *   toolID: string, type?: 'code_execution_20250825'
     * } $caller
     */
    public function withCaller(
        BetaDirectCaller|array|BetaServerToolCaller $caller
    ): self {
        $self = clone $this;
        $self['caller'] = $caller;

        return $self;
    }

    /**
     * @param array<string,mixed> $input
     */
    public function withInput(array $input): self
    {
        $self = clone $this;
        $self['input'] = $input;

        return $self;
    }

    /**
     * @param Name|value-of<Name> $name
     */
    public function withName(Name|string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }
}
