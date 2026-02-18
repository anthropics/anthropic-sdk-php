<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\ServerToolUseBlockParam\Caller;
use Anthropic\Messages\ServerToolUseBlockParam\Name;

/**
 * @phpstan-import-type CallerVariants from \Anthropic\Messages\ServerToolUseBlockParam\Caller
 * @phpstan-import-type CacheControlEphemeralShape from \Anthropic\Messages\CacheControlEphemeral
 * @phpstan-import-type CallerShape from \Anthropic\Messages\ServerToolUseBlockParam\Caller
 *
 * @phpstan-type ServerToolUseBlockParamShape = array{
 *   id: string,
 *   input: array<string,mixed>,
 *   name: Name|value-of<Name>,
 *   type: 'server_tool_use',
 *   cacheControl?: null|CacheControlEphemeral|CacheControlEphemeralShape,
 *   caller?: CallerShape|null,
 * }
 */
final class ServerToolUseBlockParam implements BaseModel
{
    /** @use SdkModel<ServerToolUseBlockParamShape> */
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
    public ?CacheControlEphemeral $cacheControl;

    /**
     * Tool invocation directly from the model.
     *
     * @var CallerVariants|null $caller
     */
    #[Optional(union: Caller::class)]
    public DirectCaller|ServerToolCaller|ServerToolCaller20260120|null $caller;

    /**
     * `new ServerToolUseBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ServerToolUseBlockParam::with(id: ..., input: ..., name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ServerToolUseBlockParam)->withID(...)->withInput(...)->withName(...)
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
     * @param CacheControlEphemeral|CacheControlEphemeralShape|null $cacheControl
     * @param CallerShape|null $caller
     */
    public static function with(
        string $id,
        array $input,
        Name|string $name,
        CacheControlEphemeral|array|null $cacheControl = null,
        DirectCaller|array|ServerToolCaller|ServerToolCaller20260120|null $caller = null,
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
     * @param 'server_tool_use' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Create a cache control breakpoint at this content block.
     *
     * @param CacheControlEphemeral|CacheControlEphemeralShape|null $cacheControl
     */
    public function withCacheControl(
        CacheControlEphemeral|array|null $cacheControl
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
        DirectCaller|array|ServerToolCaller|ServerToolCaller20260120 $caller
    ): self {
        $self = clone $this;
        $self['caller'] = $caller;

        return $self;
    }
}
