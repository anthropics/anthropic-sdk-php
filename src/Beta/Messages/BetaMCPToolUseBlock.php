<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaMCPToolUseBlockShape = array{
 *   id: string,
 *   input: array<string,mixed>,
 *   name: string,
 *   server_name: string,
 *   type: 'mcp_tool_use',
 * }
 */
final class BetaMCPToolUseBlock implements BaseModel
{
    /** @use SdkModel<BetaMCPToolUseBlockShape> */
    use SdkModel;

    /** @var 'mcp_tool_use' $type */
    #[Api]
    public string $type = 'mcp_tool_use';

    #[Api]
    public string $id;

    /** @var array<string,mixed> $input */
    #[Api(map: 'mixed')]
    public array $input;

    /**
     * The name of the MCP tool.
     */
    #[Api]
    public string $name;

    /**
     * The name of the MCP server.
     */
    #[Api]
    public string $server_name;

    /**
     * `new BetaMCPToolUseBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaMCPToolUseBlock::with(id: ..., input: ..., name: ..., server_name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaMCPToolUseBlock)
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
     */
    public static function with(
        string $id,
        array $input,
        string $name,
        string $server_name
    ): self {
        $obj = new self;

        $obj['id'] = $id;
        $obj['input'] = $input;
        $obj['name'] = $name;
        $obj['server_name'] = $server_name;

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

    /**
     * The name of the MCP tool.
     */
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
}
