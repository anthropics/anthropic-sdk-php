<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The tool listing an MCP server returned while an earlier response was
 * produced, as that response carried it. Send the assistant message back
 * unchanged, this block included, and the server uses this listing for the
 * matching `mcp_toolset` instead of asking the MCP server again.
 *
 * @phpstan-import-type BetaMCPToolParamShape from \Anthropic\Beta\Messages\BetaMCPToolParam
 *
 * @phpstan-type BetaMCPToolListingBlockParamShape = array{
 *   mcpServerName: string,
 *   tools: list<BetaMCPToolParam|BetaMCPToolParamShape>,
 *   type: 'mcp_tool_listing',
 * }
 */
final class BetaMCPToolListingBlockParam implements BaseModel
{
    /** @use SdkModel<BetaMCPToolListingBlockParamShape> */
    use SdkModel;

    /** @var 'mcp_tool_listing' $type */
    #[Required(type: new ConstantOf('mcp_tool_listing'))]
    public string $type = 'mcp_tool_listing';

    /**
     * The name of the MCP server this listing came from, as `mcp_servers` declares it.
     */
    #[Required('mcp_server_name')]
    public string $mcpServerName;

    /**
     * The server's tools, exactly as the response listed them.
     *
     * @var list<BetaMCPToolParam> $tools
     */
    #[Required(list: BetaMCPToolParam::class)]
    public array $tools;

    /**
     * `new BetaMCPToolListingBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaMCPToolListingBlockParam::with(mcpServerName: ..., tools: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaMCPToolListingBlockParam)->withMCPServerName(...)->withTools(...)
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
     * @param list<BetaMCPToolParam|BetaMCPToolParamShape> $tools
     */
    public static function with(string $mcpServerName, array $tools): self
    {
        $self = new self;

        $self['mcpServerName'] = $mcpServerName;
        $self['tools'] = $tools;

        return $self;
    }

    /**
     * The name of the MCP server this listing came from, as `mcp_servers` declares it.
     */
    public function withMCPServerName(string $mcpServerName): self
    {
        $self = clone $this;
        $self['mcpServerName'] = $mcpServerName;

        return $self;
    }

    /**
     * The server's tools, exactly as the response listed them.
     *
     * @param list<BetaMCPToolParam|BetaMCPToolParamShape> $tools
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
