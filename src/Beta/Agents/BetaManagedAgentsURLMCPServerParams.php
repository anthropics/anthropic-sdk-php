<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Agents\BetaManagedAgentsURLMCPServerParams\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * URL-based MCP server connection.
 *
 * @phpstan-type BetaManagedAgentsURLMCPServerParamsShape = array{
 *   name: string, type: Type|value-of<Type>, url: string
 * }
 */
final class BetaManagedAgentsURLMCPServerParams implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsURLMCPServerParamsShape> */
    use SdkModel;

    /**
     * Unique name for this server, referenced by mcp_toolset configurations. 1-255 characters.
     */
    #[Required]
    public string $name;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

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
     * BetaManagedAgentsURLMCPServerParams::with(name: ..., type: ..., url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsURLMCPServerParams)
     *   ->withName(...)
     *   ->withType(...)
     *   ->withURL(...)
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
     * @param Type|value-of<Type> $type
     */
    public static function with(
        string $name,
        Type|string $type,
        string $url
    ): self {
        $self = new self;

        $self['name'] = $name;
        $self['type'] = $type;
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
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
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
