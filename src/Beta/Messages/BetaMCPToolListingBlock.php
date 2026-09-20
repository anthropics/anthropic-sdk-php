<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The tool listing the server fetched from an MCP server while producing
 * this response. Send the assistant message back unchanged, this block
 * included, so later requests use this listing instead of asking the MCP
 * server again.
 *
 * @phpstan-import-type BetaMCPToolShape from \Anthropic\Beta\Messages\BetaMCPTool
 *
 * @phpstan-type BetaMCPToolListingBlockShape = array{
 *   mcpServerName: string,
 *   tools: list<BetaMCPTool|BetaMCPToolShape>,
 *   type: 'mcp_tool_listing',
 * }
 */
final class BetaMCPToolListingBlock implements BaseModel
{
    /** @use SdkModel<BetaMCPToolListingBlockShape> */
    use SdkModel;

    /** @var 'mcp_tool_listing' $type */
    #[Required(type: new ConstantOf('mcp_tool_listing'))]
    public string $type = 'mcp_tool_listing';

    #[Required('mcp_server_name')]
    public string $mcpServerName;

    /** @var list<BetaMCPTool> $tools */
    #[Required(list: BetaMCPTool::class)]
    public array $tools;

    /**
     * `new BetaMCPToolListingBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaMCPToolListingBlock::with(mcpServerName: ..., tools: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaMCPToolListingBlock)->withMCPServerName(...)->withTools(...)
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
     * @param list<BetaMCPTool|BetaMCPToolShape> $tools
     */
    public static function with(string $mcpServerName, array $tools): self
    {
        $self = new self;

        $self['mcpServerName'] = $mcpServerName;
        $self['tools'] = $tools;

        return $self;
    }

    public function withMCPServerName(string $mcpServerName): self
    {
        $self = clone $this;
        $self['mcpServerName'] = $mcpServerName;

        return $self;
    }

    /**
     * @param list<BetaMCPTool|BetaMCPToolShape> $tools
     */
    public function withTools(array $tools): self
    {
        $self = clone $this;
        $self['tools'] = $tools;

        return $self;
    }

    /**
     * @param 'mcp_tool_listing' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
