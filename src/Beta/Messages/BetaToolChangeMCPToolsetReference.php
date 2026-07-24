<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Reference to every tool in the named MCP server's toolset.
 *
 * @phpstan-type BetaToolChangeMCPToolsetReferenceShape = array{
 *   serverName: string, type: 'mcp_toolset_reference'
 * }
 */
final class BetaToolChangeMCPToolsetReference implements BaseModel
{
    /** @use SdkModel<BetaToolChangeMCPToolsetReferenceShape> */
    use SdkModel;

    /** @var 'mcp_toolset_reference' $type */
    #[Required]
    public string $type = 'mcp_toolset_reference';

    #[Required('server_name')]
    public string $serverName;

    /**
     * `new BetaToolChangeMCPToolsetReference()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaToolChangeMCPToolsetReference::with(serverName: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaToolChangeMCPToolsetReference)->withServerName(...)
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
    public static function with(string $serverName): self
    {
        $self = new self;

        $self['serverName'] = $serverName;

        return $self;
    }

    public function withServerName(string $serverName): self
    {
        $self = clone $this;
        $self['serverName'] = $serverName;

        return $self;
    }

    /**
     * @param 'mcp_toolset_reference' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
