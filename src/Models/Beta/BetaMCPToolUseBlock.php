<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_mcp_tool_use_block_alias = array{
 *   id: string, input: mixed, name: string, serverName: string, type: string
 * }
 */
final class BetaMCPToolUseBlock implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'mcp_tool_use';

    #[Api]
    public string $id;

    #[Api]
    public mixed $input;

    /**
     * The name of the MCP tool.
     */
    #[Api]
    public string $name;

    /**
     * The name of the MCP server.
     */
    #[Api('server_name')]
    public string $serverName;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        string $id,
        mixed $input,
        string $name,
        string $serverName
    ) {
        self::introspect();

        $this->id = $id;
        $this->input = $input;
        $this->name = $name;
        $this->serverName = $serverName;
    }
}
