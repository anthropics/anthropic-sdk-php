<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaCacheControlEphemeral\TTL;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Configuration for a group of tools from an MCP server.
 *
 * Allows configuring enabled status and defer_loading for all tools
 * from an MCP server, with optional per-tool overrides.
 *
 * @phpstan-type BetaMCPToolsetShape = array{
 *   mcpServerName: string,
 *   type?: 'mcp_toolset',
 *   cacheControl?: BetaCacheControlEphemeral|null,
 *   configs?: array<string,BetaMCPToolConfig>|null,
 *   defaultConfig?: BetaMCPToolDefaultConfig|null,
 * }
 */
final class BetaMCPToolset implements BaseModel
{
    /** @use SdkModel<BetaMCPToolsetShape> */
    use SdkModel;

    /** @var 'mcp_toolset' $type */
    #[Required]
    public string $type = 'mcp_toolset';

    /**
     * Name of the MCP server to configure tools for.
     */
    #[Required('mcp_server_name')]
    public string $mcpServerName;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * Configuration overrides for specific tools, keyed by tool name.
     *
     * @var array<string,BetaMCPToolConfig>|null $configs
     */
    #[Optional(map: BetaMCPToolConfig::class, nullable: true)]
    public ?array $configs;

    /**
     * Default configuration applied to all tools from this server.
     */
    #[Optional('default_config')]
    public ?BetaMCPToolDefaultConfig $defaultConfig;

    /**
     * `new BetaMCPToolset()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaMCPToolset::with(mcpServerName: ...)
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
     *   type?: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     * @param array<string,BetaMCPToolConfig|array{
     *   deferLoading?: bool|null, enabled?: bool|null
     * }>|null $configs
     * @param BetaMCPToolDefaultConfig|array{
     *   deferLoading?: bool|null, enabled?: bool|null
     * } $defaultConfig
     */
    public static function with(
        string $mcpServerName,
        BetaCacheControlEphemeral|array|null $cacheControl = null,
        ?array $configs = null,
        BetaMCPToolDefaultConfig|array|null $defaultConfig = null,
    ): self {
        $self = new self;

        $self['mcpServerName'] = $mcpServerName;

        null !== $cacheControl && $self['cacheControl'] = $cacheControl;
        null !== $configs && $self['configs'] = $configs;
        null !== $defaultConfig && $self['defaultConfig'] = $defaultConfig;

        return $self;
    }

    /**
     * Name of the MCP server to configure tools for.
     */
    public function withMCPServerName(string $mcpServerName): self
    {
        $self = clone $this;
        $self['mcpServerName'] = $mcpServerName;

        return $self;
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
        $self = clone $this;
        $self['cacheControl'] = $cacheControl;

        return $self;
    }

    /**
     * Configuration overrides for specific tools, keyed by tool name.
     *
     * @param array<string,BetaMCPToolConfig|array{
     *   deferLoading?: bool|null, enabled?: bool|null
     * }>|null $configs
     */
    public function withConfigs(?array $configs): self
    {
        $self = clone $this;
        $self['configs'] = $configs;

        return $self;
    }

    /**
     * Default configuration applied to all tools from this server.
     *
     * @param BetaMCPToolDefaultConfig|array{
     *   deferLoading?: bool|null, enabled?: bool|null
     * } $defaultConfig
     */
    public function withDefaultConfig(
        BetaMCPToolDefaultConfig|array $defaultConfig
    ): self {
        $self = clone $this;
        $self['defaultConfig'] = $defaultConfig;

        return $self;
    }
}
