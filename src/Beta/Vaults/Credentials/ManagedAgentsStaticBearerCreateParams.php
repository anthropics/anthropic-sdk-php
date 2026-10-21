<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Parameters for creating a static bearer token credential.
 *
 * @phpstan-type ManagedAgentsStaticBearerCreateParamsShape = array{
 *   token: string, mcpServerURL: string, type: 'static_bearer'
 * }
 */
final class ManagedAgentsStaticBearerCreateParams implements BaseModel
{
    /** @use SdkModel<ManagedAgentsStaticBearerCreateParamsShape> */
    use SdkModel;

    /** @var 'static_bearer' $type */
    #[Required(type: new ConstantOf('static_bearer'))]
    public string $type = 'static_bearer';

    /**
     * The static bearer token to send to the MCP server, such as an API key or personal access token.
     */
    #[Required]
    public string $token;

    /**
     * URL of the MCP server this credential authenticates against.
     */
    #[Required('mcp_server_url')]
    public string $mcpServerURL;

    /**
     * `new ManagedAgentsStaticBearerCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsStaticBearerCreateParams::with(token: ..., mcpServerURL: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsStaticBearerCreateParams())
     *   ->withToken(...)
     *   ->withMCPServerURL(...)
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
    public static function with(string $token, string $mcpServerURL): self
    {
        $self = new self;

        $self['token'] = $token;
        $self['mcpServerURL'] = $mcpServerURL;

        return $self;
    }

    /**
     * The static bearer token to send to the MCP server, such as an API key or personal access token.
     */
    public function withToken(string $token): self
    {
        $self = clone $this;
        $self['token'] = $token;

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
