<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthCreateParams\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Parameters for creating an MCP OAuth credential.
 *
 * @phpstan-import-type ManagedAgentsMCPOAuthRefreshParamsShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthRefreshParams
 *
 * @phpstan-type ManagedAgentsMCPOAuthCreateParamsShape = array{
 *   accessToken: string,
 *   mcpServerURL: string,
 *   type: Type|value-of<Type>,
 *   expiresAt?: \DateTimeInterface|null,
 *   refresh?: null|ManagedAgentsMCPOAuthRefreshParams|ManagedAgentsMCPOAuthRefreshParamsShape,
 * }
 */
final class ManagedAgentsMCPOAuthCreateParams implements BaseModel
{
    /** @use SdkModel<ManagedAgentsMCPOAuthCreateParamsShape> */
    use SdkModel;

    /**
     * OAuth access token.
     */
    #[Required('access_token')]
    public string $accessToken;

    /**
     * URL of the MCP server this credential authenticates against.
     */
    #[Required('mcp_server_url')]
    public string $mcpServerURL;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Optional('expires_at', nullable: true)]
    public ?\DateTimeInterface $expiresAt;

    /**
     * OAuth refresh token parameters for creating a credential with refresh support.
     */
    #[Optional(nullable: true)]
    public ?ManagedAgentsMCPOAuthRefreshParams $refresh;

    /**
     * `new ManagedAgentsMCPOAuthCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsMCPOAuthCreateParams::with(
     *   accessToken: ..., mcpServerURL: ..., type: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsMCPOAuthCreateParams)
     *   ->withAccessToken(...)
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
     * @param ManagedAgentsMCPOAuthRefreshParams|ManagedAgentsMCPOAuthRefreshParamsShape|null $refresh
     */
    public static function with(
        string $accessToken,
        string $mcpServerURL,
        Type|string $type,
        ?\DateTimeInterface $expiresAt = null,
        ManagedAgentsMCPOAuthRefreshParams|array|null $refresh = null,
    ): self {
        $self = new self;

        $self['accessToken'] = $accessToken;
        $self['mcpServerURL'] = $mcpServerURL;
        $self['type'] = $type;

        null !== $expiresAt && $self['expiresAt'] = $expiresAt;
        null !== $refresh && $self['refresh'] = $refresh;

        return $self;
    }

    /**
     * OAuth access token.
     */
    public function withAccessToken(string $accessToken): self
    {
        $self = clone $this;
        $self['accessToken'] = $accessToken;

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

    /**
     * A timestamp in RFC 3339 format.
     */
    public function withExpiresAt(?\DateTimeInterface $expiresAt): self
    {
        $self = clone $this;
        $self['expiresAt'] = $expiresAt;

        return $self;
    }

    /**
     * OAuth refresh token parameters for creating a credential with refresh support.
     *
     * @param ManagedAgentsMCPOAuthRefreshParams|ManagedAgentsMCPOAuthRefreshParamsShape|null $refresh
     */
    public function withRefresh(
        ManagedAgentsMCPOAuthRefreshParams|array|null $refresh
    ): self {
        $self = clone $this;
        $self['refresh'] = $refresh;

        return $self;
    }
}
