<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Static bearer token credential details for an MCP server.
 *
 * @phpstan-type ManagedAgentsStaticBearerAuthResponseShape = array{
 *   mcpServerURL: string, type: 'static_bearer'
 * }
 */
final class ManagedAgentsStaticBearerAuthResponse implements BaseModel
{
    /** @use SdkModel<ManagedAgentsStaticBearerAuthResponseShape> */
    use SdkModel;

    /** @var 'static_bearer' $type */
    #[Required(type: new ConstantOf('static_bearer'))]
    public string $type = 'static_bearer';

    /**
     * URL of the MCP server this credential authenticates against.
     */
    #[Required('mcp_server_url')]
    public string $mcpServerURL;

    /**
     * `new ManagedAgentsStaticBearerAuthResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsStaticBearerAuthResponse::with(mcpServerURL: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsStaticBearerAuthResponse())->withMCPServerURL(...)
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
    public static function with(string $mcpServerURL): self
    {
        $self = new self;

        $self['mcpServerURL'] = $mcpServerURL;

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
     * @param 'static_bearer' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
