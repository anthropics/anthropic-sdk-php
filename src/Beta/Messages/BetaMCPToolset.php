<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaCacheControlEphemeral\TTL;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Configuration for a group of tools from an MCP server.
 *
 * Allows configuring enabled status and defer_loading for all tools
 * from an MCP server, with optional per-tool overrides.
 *
 * @phpstan-type BetaMCPToolsetShape = array{
 *   mcp_server_name: string,
 *   type: 'mcp_toolset',
 *   cache_control?: BetaCacheControlEphemeral|null,
 *   configs?: array<string,BetaMCPToolConfig>|null,
 *   default_config?: BetaMCPToolDefaultConfig|null,
 * }
 */
final class BetaMCPToolset implements BaseModel
{
    /** @use SdkModel<BetaMCPToolsetShape> */
    use SdkModel;

    /** @var 'mcp_toolset' $type */
    #[Api]
    public string $type = 'mcp_toolset';

    /**
     * Name of the MCP server to configure tools for.
     */
    #[Api]
    public string $mcp_server_name;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api(nullable: true, optional: true)]
    public ?BetaCacheControlEphemeral $cache_control;

    /**
     * Configuration overrides for specific tools, keyed by tool name.
     *
     * @var array<string,BetaMCPToolConfig>|null $configs
     */
    #[Api(map: BetaMCPToolConfig::class, nullable: true, optional: true)]
    public ?array $configs;

    /**
     * Default configuration applied to all tools from this server.
     */
    #[Api(optional: true)]
    public ?BetaMCPToolDefaultConfig $default_config;

    /**
     * `new BetaMCPToolset()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaMCPToolset::with(mcp_server_name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaMCPToolset)->withMCPServerName(...)
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
     * @param BetaCacheControlEphemeral|array{
     *   type: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cache_control
     * @param array<string,BetaMCPToolConfig|array{
     *   defer_loading?: bool|null, enabled?: bool|null
     * }>|null $configs
     * @param BetaMCPToolDefaultConfig|array{
     *   defer_loading?: bool|null, enabled?: bool|null
     * } $default_config
     */
    public static function with(
        string $mcp_server_name,
        BetaCacheControlEphemeral|array|null $cache_control = null,
        ?array $configs = null,
        BetaMCPToolDefaultConfig|array|null $default_config = null,
    ): self {
        $obj = new self;

        $obj['mcp_server_name'] = $mcp_server_name;

        null !== $cache_control && $obj['cache_control'] = $cache_control;
        null !== $configs && $obj['configs'] = $configs;
        null !== $default_config && $obj['default_config'] = $default_config;

        return $obj;
    }

    /**
     * Name of the MCP server to configure tools for.
     */
    public function withMCPServerName(string $mcpServerName): self
    {
        $obj = clone $this;
        $obj['mcp_server_name'] = $mcpServerName;

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
     * Configuration overrides for specific tools, keyed by tool name.
     *
     * @param array<string,BetaMCPToolConfig|array{
     *   defer_loading?: bool|null, enabled?: bool|null
     * }>|null $configs
     */
    public function withConfigs(?array $configs): self
    {
        $obj = clone $this;
        $obj['configs'] = $configs;

        return $obj;
    }

    /**
     * Default configuration applied to all tools from this server.
     *
     * @param BetaMCPToolDefaultConfig|array{
     *   defer_loading?: bool|null, enabled?: bool|null
     * } $defaultConfig
     */
    public function withDefaultConfig(
        BetaMCPToolDefaultConfig|array $defaultConfig
    ): self {
        $obj = clone $this;
        $obj['default_config'] = $defaultConfig;

        return $obj;
    }
}
