<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaServerToolUseBlockParam\Name;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaServerToolUseBlockParamShape = array{
 *   id: string,
 *   input: array<string,mixed>,
 *   name: value-of<Name>,
 *   type: "server_tool_use",
 *   cache_control?: BetaCacheControlEphemeral|null,
 * }
 */
final class BetaServerToolUseBlockParam implements BaseModel
{
    /** @use SdkModel<BetaServerToolUseBlockParamShape> */
    use SdkModel;

    /** @var "server_tool_use" $type */
    #[Api]
    public string $type = 'server_tool_use';

    #[Api]
    public string $id;

    /** @var array<string,mixed> $input */
    #[Api(map: 'mixed')]
    public array $input;

    /** @var value-of<Name> $name */
    #[Api(enum: Name::class)]
    public string $name;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api(nullable: true, optional: true)]
    public ?BetaCacheControlEphemeral $cache_control;

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
     */
    public static function with(
        string $id,
        array $input,
        Name|string $name,
        ?BetaCacheControlEphemeral $cache_control = null,
    ): self {
        $obj = new self;

        $obj->id = $id;
        $obj->input = $input;
        $obj['name'] = $name;

        null !== $cache_control && $obj->cache_control = $cache_control;

        return $obj;
    }

    public function withID(string $id): self
    {
        $obj = clone $this;
        $obj->id = $id;

        return $obj;
    }

    /**
     * @param array<string,mixed> $input
     */
    public function withInput(array $input): self
    {
        $obj = clone $this;
        $obj->input = $input;

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
     */
    public function withCacheControl(
        ?BetaCacheControlEphemeral $cacheControl
    ): self {
        $obj = clone $this;
        $obj->cache_control = $cacheControl;

        return $obj;
    }
}
