<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

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

    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function new(
        string $id,
        mixed $input,
        string $name,
        string $serverName
    ): self {
        $obj = new self;

        $obj->id = $id;
        $obj->input = $input;
        $obj->name = $name;
        $obj->serverName = $serverName;

        return $obj;
    }

    public function setID(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setInput(mixed $input): self
    {
        $this->input = $input;

        return $this;
    }

    /**
     * The name of the MCP tool.
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * The name of the MCP server.
     */
    public function setServerName(string $serverName): self
    {
        $this->serverName = $serverName;

        return $this;
    }
}
