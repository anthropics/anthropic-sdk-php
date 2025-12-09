<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaToolUseBlock\Caller;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaToolUseBlockShape = array{
 *   id: string,
 *   input: array<string,mixed>,
 *   name: string,
 *   type?: 'tool_use',
 *   caller?: null|BetaDirectCaller|BetaServerToolCaller,
 * }
 */
final class BetaToolUseBlock implements BaseModel
{
    /** @use SdkModel<BetaToolUseBlockShape> */
    use SdkModel;

    /** @var 'tool_use' $type */
    #[Required]
    public string $type = 'tool_use';

    #[Required]
    public string $id;

    /** @var array<string,mixed> $input */
    #[Required(map: 'mixed')]
    public array $input;

    #[Required]
    public string $name;

    /**
     * Tool invocation directly from the model.
     */
    #[Optional(union: Caller::class)]
    public BetaDirectCaller|BetaServerToolCaller|null $caller;

    /**
     * `new BetaToolUseBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaToolUseBlock::with(id: ..., input: ..., name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaToolUseBlock)->withID(...)->withInput(...)->withName(...)
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
     * @param BetaDirectCaller|array{type?: 'direct'}|BetaServerToolCaller|array{
     *   toolID: string, type?: 'code_execution_20250825'
     * } $caller
     */
    public static function with(
        string $id,
        array $input,
        string $name,
        BetaDirectCaller|array|BetaServerToolCaller|null $caller = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['input'] = $input;
        $self['name'] = $name;

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
     * @param array<string,mixed> $input
     */
    public function withInput(array $input): self
    {
        $self = clone $this;
        $self['input'] = $input;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

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
}
