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
        $obj = new self;

        $obj['id'] = $id;
        $obj['caller'] = $caller;
        $obj['input'] = $input;
        $obj['name'] = $name;

        return $obj;
    }

    public function withID(string $id): self
    {
        $obj = clone $this;
        $obj['id'] = $id;

        return $obj;
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
        $obj = clone $this;
        $obj['caller'] = $caller;

        return $obj;
    }

    /**
     * @param array<string,mixed> $input
     */
    public function withInput(array $input): self
    {
        $obj = clone $this;
        $obj['input'] = $input;

        return $obj;
    }

    /**
     * @param Name|value-of<Name> $name
     */
    public function withName(Name|string $name): self
    {
        $obj = clone $this;
        $obj['name'] = $name;

        return $obj;
    }
}
