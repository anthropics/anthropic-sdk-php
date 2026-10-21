<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-import-type BetaManagedAgentsMCPToolConfigShape from \Anthropic\Beta\Agents\BetaManagedAgentsMCPToolConfig
 * @phpstan-import-type BetaManagedAgentsMCPToolsetDefaultConfigShape from \Anthropic\Beta\Agents\BetaManagedAgentsMCPToolsetDefaultConfig
 *
 * @phpstan-type BetaManagedAgentsMCPToolsetShape = array{
 *   configs: list<BetaManagedAgentsMCPToolConfig|BetaManagedAgentsMCPToolConfigShape>,
 *   defaultConfig: BetaManagedAgentsMCPToolsetDefaultConfig|BetaManagedAgentsMCPToolsetDefaultConfigShape,
 *   mcpServerName: string,
 *   type: 'mcp_toolset',
 * }
 */
final class BetaManagedAgentsMCPToolset implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsMCPToolsetShape> */
    use SdkModel;

    /** @var 'mcp_toolset' $type */
    #[Required(type: new ConstantOf('mcp_toolset'))]
    public string $type = 'mcp_toolset';

    /** @var list<BetaManagedAgentsMCPToolConfig> $configs */
    #[Required(list: BetaManagedAgentsMCPToolConfig::class)]
    public array $configs;

    /**
     * Resolved default configuration for all tools from an MCP server.
     */
    #[Required('default_config')]
    public BetaManagedAgentsMCPToolsetDefaultConfig $defaultConfig;

    #[Required('mcp_server_name')]
    public string $mcpServerName;

    /**
     * `new BetaManagedAgentsMCPToolset()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsMCPToolset::with(
     *   configs: ..., defaultConfig: ..., mcpServerName: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsMCPToolset())
     *   ->withConfigs(...)
     *   ->withDefaultConfig(...)
     *   ->withMCPServerName(...)
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
     * @param list<BetaManagedAgentsMCPToolConfig|BetaManagedAgentsMCPToolConfigShape> $configs
     * @param BetaManagedAgentsMCPToolsetDefaultConfig|BetaManagedAgentsMCPToolsetDefaultConfigShape $defaultConfig
     */
    public static function with(
        array $configs,
        BetaManagedAgentsMCPToolsetDefaultConfig|array $defaultConfig,
        string $mcpServerName,
    ): self {
        $self = new self;

        $self['configs'] = $configs;
        $self['defaultConfig'] = $defaultConfig;
        $self['mcpServerName'] = $mcpServerName;

        return $self;
    }

    /**
     * @param list<BetaManagedAgentsMCPToolConfig|BetaManagedAgentsMCPToolConfigShape> $configs
     */
    public function withConfigs(array $configs): self
    {
        $self = clone $this;
        $self['configs'] = $configs;

        return $self;
    }

    /**
     * Resolved default configuration for all tools from an MCP server.
     *
     * @param BetaManagedAgentsMCPToolsetDefaultConfig|BetaManagedAgentsMCPToolsetDefaultConfigShape $defaultConfig
     */
    public function withDefaultConfig(
        BetaManagedAgentsMCPToolsetDefaultConfig|array $defaultConfig
    ): self {
        $self = clone $this;
        $self['defaultConfig'] = $defaultConfig;

        return $self;
    }

    public function withMCPServerName(string $mcpServerName): self
    {
        $self = clone $this;
        $self['mcpServerName'] = $mcpServerName;

        return $self;
    }

    /**
     * @param 'mcp_toolset' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
