<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * URL-based MCP server connection.
 *
 * @phpstan-type BetaManagedAgentsURLMCPServerParamsShape = array{
 *   name: string, type: 'url', url: string
 * }
 */
final class BetaManagedAgentsURLMCPServerParams implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsURLMCPServerParamsShape> */
    use SdkModel;

    /** @var 'url' $type */
    #[Required(type: new ConstantOf('url'))]
    public string $type = 'url';

    /**
     * Unique name for this server, referenced by mcp_toolset configurations. 1-255 characters.
     */
    #[Required]
    public string $name;

    /**
     * Endpoint URL for the MCP server.
     */
    #[Required]
    public string $url;

    /**
     * `new BetaManagedAgentsURLMCPServerParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsURLMCPServerParams::with(name: ..., url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsURLMCPServerParams())->withName(...)->withURL(...)
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
    public static function with(string $name, string $url): self
    {
        $self = new self;

        $self['name'] = $name;
        $self['url'] = $url;

        return $self;
    }

    /**
     * Unique name for this server, referenced by mcp_toolset configurations. 1-255 characters.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * @param 'url' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Endpoint URL for the MCP server.
     */
    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
