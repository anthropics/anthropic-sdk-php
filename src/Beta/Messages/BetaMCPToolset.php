<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

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
 * @phpstan-import-type BetaCacheControlEphemeralShape from \Anthropic\Beta\Messages\BetaCacheControlEphemeral
 * @phpstan-import-type BetaMCPToolConfigShape from \Anthropic\Beta\Messages\BetaMCPToolConfig
 * @phpstan-import-type BetaMCPToolDefaultConfigShape from \Anthropic\Beta\Messages\BetaMCPToolDefaultConfig
 *
 * @phpstan-type BetaMCPToolsetShape = array{
 *   mcpServerName: string,
 *   type: 'mcp_toolset',
 *   cacheControl?: null|BetaCacheControlEphemeral|BetaCacheControlEphemeralShape,
 *   configs?: array<string,BetaMCPToolConfigShape>|null,
 *   defaultConfig?: null|BetaMCPToolDefaultConfig|BetaMCPToolDefaultConfigShape,
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
     * @param BetaCacheControlEphemeralShape|null $cacheControl
     * @param array<string,BetaMCPToolConfigShape>|null $configs
     * @param BetaMCPToolDefaultConfigShape $defaultConfig
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
     * Configuration overrides for specific tools, keyed by tool name.
     *
     * @param array<string,BetaMCPToolConfigShape>|null $configs
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
     * @param BetaMCPToolDefaultConfigShape $defaultConfig
     */
    public function withDefaultConfig(
        BetaMCPToolDefaultConfig|array $defaultConfig
    ): self {
        $self = clone $this;
        $self['defaultConfig'] = $defaultConfig;

        return $self;
    }
}
