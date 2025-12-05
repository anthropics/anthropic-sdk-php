<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaCacheControlEphemeral\TTL;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaMCPToolUseBlockParamShape = array{
 *   id: string,
 *   input: array<string,mixed>,
 *   name: string,
 *   server_name: string,
 *   type: 'mcp_tool_use',
 *   cache_control?: BetaCacheControlEphemeral|null,
 * }
 */
final class BetaMCPToolUseBlockParam implements BaseModel
{
    /** @use SdkModel<BetaMCPToolUseBlockParamShape> */
    use SdkModel;

    /** @var 'mcp_tool_use' $type */
    #[Api]
    public string $type = 'mcp_tool_use';

    #[Api]
    public string $id;

    /** @var array<string,mixed> $input */
    #[Api(map: 'mixed')]
    public array $input;

    #[Api]
    public string $name;

    /**
     * The name of the MCP server.
     */
    #[Api]
    public string $server_name;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api(nullable: true, optional: true)]
    public ?BetaCacheControlEphemeral $cache_control;

    /**
     * `new BetaMCPToolUseBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaMCPToolUseBlockParam::with(id: ..., input: ..., name: ..., server_name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaMCPToolUseBlockParam)
     *   ->withID(...)
     *   ->withInput(...)
     *   ->withName(...)
     *   ->withServerName(...)
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
     */
    public static function with(
        string $id,
        array $input,
        string $name,
        string $server_name,
        BetaCacheControlEphemeral|array|null $cache_control = null,
    ): self {
        $obj = new self;

        $obj['id'] = $id;
        $obj['input'] = $input;
        $obj['name'] = $name;
        $obj['server_name'] = $server_name;

        null !== $cache_control && $obj['cache_control'] = $cache_control;

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
     * The name of the MCP server.
     */
    public function withServerName(string $serverName): self
    {
        $obj = clone $this;
        $obj['server_name'] = $serverName;

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
}
