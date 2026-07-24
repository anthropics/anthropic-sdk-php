<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Reference to a single MCP tool by its server and remote name — the
 * same ``server_name``/``name`` pair ``mcp_tool_use`` carries.
 *
 * @phpstan-type BetaToolChangeMCPToolReferenceShape = array{
 *   name: string, serverName: string, type: 'mcp_tool_reference'
 * }
 */
final class BetaToolChangeMCPToolReference implements BaseModel
{
    /** @use SdkModel<BetaToolChangeMCPToolReferenceShape> */
    use SdkModel;

    /** @var 'mcp_tool_reference' $type */
    #[Required]
    public string $type = 'mcp_tool_reference';

    #[Required]
    public string $name;

    #[Required('server_name')]
    public string $serverName;

    /**
     * `new BetaToolChangeMCPToolReference()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaToolChangeMCPToolReference::with(name: ..., serverName: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaToolChangeMCPToolReference)->withName(...)->withServerName(...)
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
     */
    public static function with(string $name, string $serverName): self
    {
        $self = new self;

        $self['name'] = $name;
        $self['serverName'] = $serverName;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    public function withServerName(string $serverName): self
    {
        $self = clone $this;
        $self['serverName'] = $serverName;

        return $self;
    }

    /**
     * @param 'mcp_tool_reference' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
