<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Beta\Vaults\Credentials\ManagedAgentsStaticBearerAuthResponse\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Static bearer token credential details for an MCP server.
 *
 * @phpstan-type ManagedAgentsStaticBearerAuthResponseShape = array{
 *   mcpServerURL: string, type: Type|value-of<Type>
 * }
 */
final class ManagedAgentsStaticBearerAuthResponse implements BaseModel
{
    /** @use SdkModel<ManagedAgentsStaticBearerAuthResponseShape> */
    use SdkModel;

    /**
     * URL of the MCP server this credential authenticates against.
     */
    #[Required('mcp_server_url')]
    public string $mcpServerURL;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new ManagedAgentsStaticBearerAuthResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsStaticBearerAuthResponse::with(mcpServerURL: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsStaticBearerAuthResponse)
     *   ->withMCPServerURL(...)
     *   ->withType(...)
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
    public static function with(string $mcpServerURL, Type|string $type): self
    {
        $self = new self;

        $self['mcpServerURL'] = $mcpServerURL;
        $self['type'] = $type;

        return $self;
    }

    /**
     * URL of the MCP server this credential authenticates against.
     */
    public function withMCPServerURL(string $mcpServerURL): self
    {
        $self = clone $this;
        $self['mcpServerURL'] = $mcpServerURL;

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
}
