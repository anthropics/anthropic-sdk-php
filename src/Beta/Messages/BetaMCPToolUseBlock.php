<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaMCPToolUseBlockShape = array{
 *   id: string,
 *   input: array<string,mixed>,
 *   name: string,
 *   serverName: string,
 *   type?: 'mcp_tool_use',
 * }
 */
final class BetaMCPToolUseBlock implements BaseModel
{
    /** @use SdkModel<BetaMCPToolUseBlockShape> */
    use SdkModel;

    /** @var 'mcp_tool_use' $type */
    #[Required]
    public string $type = 'mcp_tool_use';

    #[Required]
    public string $id;

    /** @var array<string,mixed> $input */
    #[Required(map: 'mixed')]
    public array $input;

    /**
     * The name of the MCP tool.
     */
    #[Required]
    public string $name;

    /**
     * The name of the MCP server.
     */
    #[Required('server_name')]
    public string $serverName;

    /**
     * `new BetaMCPToolUseBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaMCPToolUseBlock::with(id: ..., input: ..., name: ..., serverName: ...)
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
        string $serverName
    ): self {
        $obj = new self;

        $obj['id'] = $id;
        $obj['input'] = $input;
        $obj['name'] = $name;
        $obj['serverName'] = $serverName;

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
        $obj['serverName'] = $serverName;

        return $obj;
    }
}
