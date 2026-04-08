<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Agents\BetaManagedAgentsMCPToolsetParams\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Configuration for tools from an MCP server defined in `mcp_servers`.
 *
 * @phpstan-import-type BetaManagedAgentsMCPToolConfigParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsMCPToolConfigParams
 * @phpstan-import-type BetaManagedAgentsMCPToolsetDefaultConfigParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsMCPToolsetDefaultConfigParams
 *
 * @phpstan-type BetaManagedAgentsMCPToolsetParamsShape = array{
 *   mcpServerName: string,
 *   type: Type|value-of<Type>,
 *   configs?: list<BetaManagedAgentsMCPToolConfigParams|BetaManagedAgentsMCPToolConfigParamsShape>|null,
 *   defaultConfig?: null|BetaManagedAgentsMCPToolsetDefaultConfigParams|BetaManagedAgentsMCPToolsetDefaultConfigParamsShape,
 * }
 */
final class BetaManagedAgentsMCPToolsetParams implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsMCPToolsetParamsShape> */
    use SdkModel;

    /**
     * Name of the MCP server. Must match a server name from the mcp_servers array. 1-255 characters.
     */
    #[Required('mcp_server_name')]
    public string $mcpServerName;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * Per-tool configuration overrides.
     *
     * @var list<BetaManagedAgentsMCPToolConfigParams>|null $configs
     */
    #[Optional(list: BetaManagedAgentsMCPToolConfigParams::class)]
    public ?array $configs;

    /**
     * Default configuration for all tools from an MCP server.
     */
    #[Optional('default_config', nullable: true)]
    public ?BetaManagedAgentsMCPToolsetDefaultConfigParams $defaultConfig;

    /**
     * `new BetaManagedAgentsMCPToolsetParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsMCPToolsetParams::with(mcpServerName: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsMCPToolsetParams)->withMCPServerName(...)->withType(...)
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
     * @param Type|value-of<Type> $type
     * @param list<BetaManagedAgentsMCPToolConfigParams|BetaManagedAgentsMCPToolConfigParamsShape>|null $configs
     * @param BetaManagedAgentsMCPToolsetDefaultConfigParams|BetaManagedAgentsMCPToolsetDefaultConfigParamsShape|null $defaultConfig
     */
    public static function with(
        string $mcpServerName,
        Type|string $type,
        ?array $configs = null,
        BetaManagedAgentsMCPToolsetDefaultConfigParams|array|null $defaultConfig = null,
    ): self {
        $self = new self;

        $self['mcpServerName'] = $mcpServerName;
        $self['type'] = $type;

        null !== $configs && $self['configs'] = $configs;
        null !== $defaultConfig && $self['defaultConfig'] = $defaultConfig;

        return $self;
    }

    /**
     * Name of the MCP server. Must match a server name from the mcp_servers array. 1-255 characters.
     */
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

    /**
     * Per-tool configuration overrides.
     *
     * @param list<BetaManagedAgentsMCPToolConfigParams|BetaManagedAgentsMCPToolConfigParamsShape> $configs
     */
    public function withConfigs(array $configs): self
    {
        $self = clone $this;
        $self['configs'] = $configs;

        return $self;
    }

    /**
     * Default configuration for all tools from an MCP server.
     *
     * @param BetaManagedAgentsMCPToolsetDefaultConfigParams|BetaManagedAgentsMCPToolsetDefaultConfigParamsShape|null $defaultConfig
     */
    public function withDefaultConfig(
        BetaManagedAgentsMCPToolsetDefaultConfigParams|array|null $defaultConfig
    ): self {
        $self = clone $this;
        $self['defaultConfig'] = $defaultConfig;

        return $self;
    }
}
