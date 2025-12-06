<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaCacheControlEphemeral\TTL;
use Anthropic\Beta\Messages\BetaToolUseBlockParam\Caller;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaToolUseBlockParamShape = array{
 *   id: string,
 *   input: array<string,mixed>,
 *   name: string,
 *   type: 'tool_use',
 *   cache_control?: BetaCacheControlEphemeral|null,
 *   caller?: null|BetaDirectCaller|BetaServerToolCaller,
 * }
 */
final class BetaToolUseBlockParam implements BaseModel
{
    /** @use SdkModel<BetaToolUseBlockParamShape> */
    use SdkModel;

    /** @var 'tool_use' $type */
    #[Api]
    public string $type = 'tool_use';

    #[Api]
    public string $id;

    /** @var array<string,mixed> $input */
    #[Api(map: 'mixed')]
    public array $input;

    #[Api]
    public string $name;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api(nullable: true, optional: true)]
    public ?BetaCacheControlEphemeral $cache_control;

    /**
     * Tool invocation directly from the model.
     */
    #[Api(union: Caller::class, optional: true)]
    public BetaDirectCaller|BetaServerToolCaller|null $caller;

    /**
     * `new BetaToolUseBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaToolUseBlockParam::with(id: ..., input: ..., name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaToolUseBlockParam)->withID(...)->withInput(...)->withName(...)
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
     * @param BetaCacheControlEphemeral|array{
     *   type: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cache_control
     * @param BetaDirectCaller|array{type: 'direct'}|BetaServerToolCaller|array{
     *   tool_id: string, type: 'code_execution_20250825'
     * } $caller
     */
    public static function with(
        string $id,
        array $input,
        string $name,
        BetaCacheControlEphemeral|array|null $cache_control = null,
        BetaDirectCaller|array|BetaServerToolCaller|null $caller = null,
    ): self {
        $obj = new self;

        $obj['id'] = $id;
        $obj['input'] = $input;
        $obj['name'] = $name;

        null !== $cache_control && $obj['cache_control'] = $cache_control;
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

    public function withName(string $name): self
    {
        $obj = clone $this;
        $obj['name'] = $name;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     *
     * @param BetaCacheControlEphemeral|array{
     *   type: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     */
    public function withCacheControl(
        BetaCacheControlEphemeral|array|null $cacheControl
    ): self {
        $obj = clone $this;
        $obj['cache_control'] = $cacheControl;

        return $obj;
    }

    /**
     * Tool invocation directly from the model.
     *
     * @param BetaDirectCaller|array{type: 'direct'}|BetaServerToolCaller|array{
     *   tool_id: string, type: 'code_execution_20250825'
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
