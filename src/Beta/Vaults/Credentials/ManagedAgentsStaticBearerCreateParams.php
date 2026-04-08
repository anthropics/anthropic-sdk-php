<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Beta\Vaults\Credentials\ManagedAgentsStaticBearerCreateParams\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Parameters for creating a static bearer token credential.
 *
 * @phpstan-type ManagedAgentsStaticBearerCreateParamsShape = array{
 *   token: string, mcpServerURL: string, type: Type|value-of<Type>
 * }
 */
final class ManagedAgentsStaticBearerCreateParams implements BaseModel
{
    /** @use SdkModel<ManagedAgentsStaticBearerCreateParamsShape> */
    use SdkModel;

    /**
     * Static bearer token value.
     */
    #[Required]
    public string $token;

    /**
     * URL of the MCP server this credential authenticates against.
     */
    #[Required('mcp_server_url')]
    public string $mcpServerURL;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new ManagedAgentsStaticBearerCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsStaticBearerCreateParams::with(
     *   token: ..., mcpServerURL: ..., type: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsStaticBearerCreateParams)
     *   ->withToken(...)
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
    public static function with(
        string $token,
        string $mcpServerURL,
        Type|string $type
    ): self {
        $self = new self;

        $self['token'] = $token;
        $self['mcpServerURL'] = $mcpServerURL;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Static bearer token value.
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
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
