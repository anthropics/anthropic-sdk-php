<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaCacheControlEphemeral\TTL;
use Anthropic\Beta\Messages\BetaServerToolUseBlockParam\Caller;
use Anthropic\Beta\Messages\BetaServerToolUseBlockParam\Name;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaServerToolUseBlockParamShape = array{
 *   id: string,
 *   input: array<string,mixed>,
 *   name: value-of<Name>,
 *   type?: 'server_tool_use',
 *   cacheControl?: BetaCacheControlEphemeral|null,
 *   caller?: null|BetaDirectCaller|BetaServerToolCaller,
 * }
 */
final class BetaServerToolUseBlockParam implements BaseModel
{
    /** @use SdkModel<BetaServerToolUseBlockParamShape> */
    use SdkModel;

    /** @var 'server_tool_use' $type */
    #[Required]
    public string $type = 'server_tool_use';

    #[Required]
    public string $id;

    /** @var array<string,mixed> $input */
    #[Required(map: 'mixed')]
    public array $input;

    /** @var value-of<Name> $name */
    #[Required(enum: Name::class)]
    public string $name;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * Tool invocation directly from the model.
     */
    #[Optional(union: Caller::class)]
    public BetaDirectCaller|BetaServerToolCaller|null $caller;

    /**
     * `new BetaServerToolUseBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaServerToolUseBlockParam::with(id: ..., input: ..., name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaServerToolUseBlockParam)->withID(...)->withInput(...)->withName(...)
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
     * @param BetaCacheControlEphemeral|array{
     *   type?: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     * @param BetaDirectCaller|array{type?: 'direct'}|BetaServerToolCaller|array{
     *   toolID: string, type?: 'code_execution_20250825'
     * } $caller
     */
    public static function with(
        string $id,
        array $input,
        Name|string $name,
        BetaCacheControlEphemeral|array|null $cacheControl = null,
        BetaDirectCaller|array|BetaServerToolCaller|null $caller = null,
    ): self {
        $obj = new self;

        $obj['id'] = $id;
        $obj['input'] = $input;
        $obj['name'] = $name;

        null !== $cacheControl && $obj['cacheControl'] = $cacheControl;
        null !== $caller && $obj['caller'] = $caller;

        return $obj;
    }

    public function withID(string $id): self
    {
        $obj = clone $this;
        $obj['id'] = $id;

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

    /**
     * Create a cache control breakpoint at this content block.
     *
     * @param BetaCacheControlEphemeral|array{
     *   type?: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     */
    public function withCacheControl(
        BetaCacheControlEphemeral|array|null $cacheControl
    ): self {
        $obj = clone $this;
        $obj['cacheControl'] = $cacheControl;

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
}
