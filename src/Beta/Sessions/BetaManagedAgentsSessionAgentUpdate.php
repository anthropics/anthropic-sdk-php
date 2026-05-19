<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Beta\Agents\BetaManagedAgentsURLMCPServerParams;
use Anthropic\Beta\Sessions\BetaManagedAgentsSessionAgentUpdate\Tool;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Mid-session agent configuration update. Only `tools` and `mcp_servers` are updatable. Full replacement: the provided array becomes the new value. To preserve existing entries, GET the session, modify the array, and POST it back.
 *
 * @phpstan-import-type ToolVariants from \Anthropic\Beta\Sessions\BetaManagedAgentsSessionAgentUpdate\Tool
 * @phpstan-import-type BetaManagedAgentsURLMCPServerParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsURLMCPServerParams
 * @phpstan-import-type ToolShape from \Anthropic\Beta\Sessions\BetaManagedAgentsSessionAgentUpdate\Tool
 *
 * @phpstan-type BetaManagedAgentsSessionAgentUpdateShape = array{
 *   mcpServers?: list<BetaManagedAgentsURLMCPServerParams|BetaManagedAgentsURLMCPServerParamsShape>|null,
 *   tools?: list<ToolShape>|null,
 * }
 */
final class BetaManagedAgentsSessionAgentUpdate implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsSessionAgentUpdateShape> */
    use SdkModel;

    /**
     * Replacement MCP server list. Full replacement: the provided array becomes the new value. Send an empty array to clear; omit to preserve.
     *
     * @var list<BetaManagedAgentsURLMCPServerParams>|null $mcpServers
     */
    #[Optional('mcp_servers', list: BetaManagedAgentsURLMCPServerParams::class)]
    public ?array $mcpServers;

    /**
     * Replacement tool list. Full replacement: the provided array becomes the new value. Send an empty array to clear; omit to preserve.
     *
     * @var list<ToolVariants>|null $tools
     */
    #[Optional(list: Tool::class)]
    public ?array $tools;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<BetaManagedAgentsURLMCPServerParams|BetaManagedAgentsURLMCPServerParamsShape>|null $mcpServers
     * @param list<ToolShape>|null $tools
     */
    public static function with(
        ?array $mcpServers = null,
        ?array $tools = null
    ): self {
        $self = new self;

        null !== $mcpServers && $self['mcpServers'] = $mcpServers;
        null !== $tools && $self['tools'] = $tools;

        return $self;
    }

    /**
     * Replacement MCP server list. Full replacement: the provided array becomes the new value. Send an empty array to clear; omit to preserve.
     *
     * @param list<BetaManagedAgentsURLMCPServerParams|BetaManagedAgentsURLMCPServerParamsShape> $mcpServers
     */
    public function withMCPServers(array $mcpServers): self
    {
        $self = clone $this;
        $self['mcpServers'] = $mcpServers;

        return $self;
    }

    /**
     * Replacement tool list. Full replacement: the provided array becomes the new value. Send an empty array to clear; omit to preserve.
     *
     * @param list<ToolShape> $tools
     */
    public function withTools(array $tools): self
    {
        $self = clone $this;
        $self['tools'] = $tools;

        return $self;
    }
}
