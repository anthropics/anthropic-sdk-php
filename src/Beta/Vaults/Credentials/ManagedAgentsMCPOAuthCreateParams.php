<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Parameters for creating an MCP OAuth credential.
 *
 * @phpstan-import-type ManagedAgentsMCPOAuthRefreshParamsShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthRefreshParams
 *
 * @phpstan-type ManagedAgentsMCPOAuthCreateParamsShape = array{
 *   accessToken: string,
 *   mcpServerURL: string,
 *   type: 'mcp_oauth',
 *   expiresAt?: \DateTimeInterface|null,
 *   refresh?: null|ManagedAgentsMCPOAuthRefreshParams|ManagedAgentsMCPOAuthRefreshParamsShape,
 * }
 */
final class ManagedAgentsMCPOAuthCreateParams implements BaseModel
{
    /** @use SdkModel<ManagedAgentsMCPOAuthCreateParamsShape> */
    use SdkModel;

    /** @var 'mcp_oauth' $type */
    #[Required(type: new ConstantOf('mcp_oauth'))]
    public string $type = 'mcp_oauth';

    /**
     * The OAuth access token to send to the MCP server.
     */
    #[Required('access_token')]
    public string $accessToken;

    /**
     * URL of the MCP server this credential authenticates against.
     */
    #[Required('mcp_server_url')]
    public string $mcpServerURL;

    /**
     * When `access_token` expires, in RFC 3339.
     *
     * Must be in the future.
     */
    #[Optional('expires_at', nullable: true)]
    public ?\DateTimeInterface $expiresAt;

    /**
     * Refresh token configuration, if the credential supports token refresh.
     */
    #[Optional(nullable: true)]
    public ?ManagedAgentsMCPOAuthRefreshParams $refresh;

    /**
     * `new ManagedAgentsMCPOAuthCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsMCPOAuthCreateParams::with(accessToken: ..., mcpServerURL: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsMCPOAuthCreateParams())
     *   ->withAccessToken(...)
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
     *
     * @param ManagedAgentsMCPOAuthRefreshParams|ManagedAgentsMCPOAuthRefreshParamsShape|null $refresh
     */
    public static function with(
        string $accessToken,
        string $mcpServerURL,
        ?\DateTimeInterface $expiresAt = null,
        ManagedAgentsMCPOAuthRefreshParams|array|null $refresh = null,
    ): self {
        $self = new self;

        $self['accessToken'] = $accessToken;
        $self['mcpServerURL'] = $mcpServerURL;

        null !== $expiresAt && $self['expiresAt'] = $expiresAt;
        null !== $refresh && $self['refresh'] = $refresh;

        return $self;
    }

    /**
     * The OAuth access token to send to the MCP server.
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
     * @param 'mcp_oauth' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * When `access_token` expires, in RFC 3339.
     *
     * Must be in the future.
     */
    public function withExpiresAt(?\DateTimeInterface $expiresAt): self
    {
        $self = clone $this;
        $self['expiresAt'] = $expiresAt;

        return $self;
    }

    /**
     * Refresh token configuration, if the credential supports token refresh.
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
