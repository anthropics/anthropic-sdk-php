<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Agents\BetaManagedAgentsMCPToolset\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type BetaManagedAgentsMCPToolConfigShape from \Anthropic\Beta\Agents\BetaManagedAgentsMCPToolConfig
 * @phpstan-import-type BetaManagedAgentsMCPToolsetDefaultConfigShape from \Anthropic\Beta\Agents\BetaManagedAgentsMCPToolsetDefaultConfig
 *
 * @phpstan-type BetaManagedAgentsMCPToolsetShape = array{
 *   configs: list<BetaManagedAgentsMCPToolConfig|BetaManagedAgentsMCPToolConfigShape>,
 *   defaultConfig: BetaManagedAgentsMCPToolsetDefaultConfig|BetaManagedAgentsMCPToolsetDefaultConfigShape,
 *   mcpServerName: string,
 *   type: Type|value-of<Type>,
 * }
 */
final class BetaManagedAgentsMCPToolset implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsMCPToolsetShape> */
    use SdkModel;

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

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new BetaManagedAgentsMCPToolset()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsMCPToolset::with(
     *   configs: ..., defaultConfig: ..., mcpServerName: ..., type: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsMCPToolset)
     *   ->withConfigs(...)
     *   ->withDefaultConfig(...)
     *   ->withMCPServerName(...)
     *   ->withType(...)
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
     * @param Type|value-of<Type> $type
     */
    public static function with(
        array $configs,
        BetaManagedAgentsMCPToolsetDefaultConfig|array $defaultConfig,
        string $mcpServerName,
        Type|string $type,
    ): self {
        $self = new self;

        $self['configs'] = $configs;
        $self['defaultConfig'] = $defaultConfig;
        $self['mcpServerName'] = $mcpServerName;
        $self['type'] = $type;

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
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
