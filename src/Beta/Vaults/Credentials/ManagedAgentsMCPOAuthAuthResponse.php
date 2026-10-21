<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * OAuth credential details for an MCP server.
 *
 * @phpstan-import-type ManagedAgentsMCPOAuthRefreshResponseShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthRefreshResponse
 *
 * @phpstan-type ManagedAgentsMCPOAuthAuthResponseShape = array{
 *   mcpServerURL: string,
 *   type: 'mcp_oauth',
 *   expiresAt?: \DateTimeInterface|null,
 *   refresh?: null|ManagedAgentsMCPOAuthRefreshResponse|ManagedAgentsMCPOAuthRefreshResponseShape,
 * }
 */
final class ManagedAgentsMCPOAuthAuthResponse implements BaseModel
{
    /** @use SdkModel<ManagedAgentsMCPOAuthAuthResponseShape> */
    use SdkModel;

    /** @var 'mcp_oauth' $type */
    #[Required(type: new ConstantOf('mcp_oauth'))]
    public string $type = 'mcp_oauth';

    /**
     * URL of the MCP server this credential authenticates against.
     */
    #[Required('mcp_server_url')]
    public string $mcpServerURL;

    /**
     * When the credential's access token expires, in RFC 3339. Absent if the expiry isn't known.
     */
    #[Optional('expires_at', nullable: true)]
    public ?\DateTimeInterface $expiresAt;

    /**
     * Refresh token configuration, if the credential supports token refresh.
     */
    #[Optional(nullable: true)]
    public ?ManagedAgentsMCPOAuthRefreshResponse $refresh;

    /**
     * `new ManagedAgentsMCPOAuthAuthResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsMCPOAuthAuthResponse::with(mcpServerURL: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsMCPOAuthAuthResponse())->withMCPServerURL(...)
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
     * @param ManagedAgentsMCPOAuthRefreshResponse|ManagedAgentsMCPOAuthRefreshResponseShape|null $refresh
     */
    public static function with(
        string $mcpServerURL,
        ?\DateTimeInterface $expiresAt = null,
        ManagedAgentsMCPOAuthRefreshResponse|array|null $refresh = null,
    ): self {
        $self = new self;

        $self['mcpServerURL'] = $mcpServerURL;

        null !== $expiresAt && $self['expiresAt'] = $expiresAt;
        null !== $refresh && $self['refresh'] = $refresh;

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
     * When the credential's access token expires, in RFC 3339. Absent if the expiry isn't known.
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
     * @param ManagedAgentsMCPOAuthRefreshResponse|ManagedAgentsMCPOAuthRefreshResponseShape|null $refresh
     */
    public function withRefresh(
        ManagedAgentsMCPOAuthRefreshResponse|array|null $refresh
    ): self {
        $self = clone $this;
        $self['refresh'] = $refresh;

        return $self;
    }
}
