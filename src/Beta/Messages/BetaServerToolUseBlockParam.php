<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaServerToolUseBlockParam\Caller;
use Anthropic\Beta\Messages\BetaServerToolUseBlockParam\Name;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type BetaCacheControlEphemeralShape from \Anthropic\Beta\Messages\BetaCacheControlEphemeral
 * @phpstan-import-type CallerShape from \Anthropic\Beta\Messages\BetaServerToolUseBlockParam\Caller
 *
 * @phpstan-type BetaServerToolUseBlockParamShape = array{
 *   id: string,
 *   input: array<string,mixed>,
 *   name: Name|value-of<Name>,
 *   type: 'server_tool_use',
 *   cacheControl?: null|BetaCacheControlEphemeral|BetaCacheControlEphemeralShape,
 *   caller?: null|CallerShape|BetaDirectCaller|BetaServerToolCaller,
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
     * @param BetaCacheControlEphemeralShape|null $cacheControl
     * @param CallerShape $caller
     */
    public static function with(
        string $id,
        array $input,
        Name|string $name,
        BetaCacheControlEphemeral|array|null $cacheControl = null,
        BetaDirectCaller|array|BetaServerToolCaller|null $caller = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['input'] = $input;
        $self['name'] = $name;

        null !== $cacheControl && $self['cacheControl'] = $cacheControl;
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

    /**
     * @param Name|value-of<Name> $name
     */
    public function withName(Name|string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Create a cache control breakpoint at this content block.
     *
     * @param BetaCacheControlEphemeralShape|null $cacheControl
     */
    public function withCacheControl(
        BetaCacheControlEphemeral|array|null $cacheControl
    ): self {
        $self = clone $this;
        $self['cacheControl'] = $cacheControl;

        return $self;
    }

    /**
     * Tool invocation directly from the model.
     *
     * @param CallerShape $caller
     */
    public function withCaller(
        BetaDirectCaller|array|BetaServerToolCaller $caller
    ): self {
        $self = clone $this;
        $self['caller'] = $caller;

        return $self;
    }
}
