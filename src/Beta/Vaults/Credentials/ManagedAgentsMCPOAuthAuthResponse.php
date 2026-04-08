<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthAuthResponse\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * OAuth credential details for an MCP server.
 *
 * @phpstan-import-type ManagedAgentsMCPOAuthRefreshResponseShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthRefreshResponse
 *
 * @phpstan-type ManagedAgentsMCPOAuthAuthResponseShape = array{
 *   mcpServerURL: string,
 *   type: Type|value-of<Type>,
 *   expiresAt?: \DateTimeInterface|null,
 *   refresh?: null|ManagedAgentsMCPOAuthRefreshResponse|ManagedAgentsMCPOAuthRefreshResponseShape,
 * }
 */
final class ManagedAgentsMCPOAuthAuthResponse implements BaseModel
{
    /** @use SdkModel<ManagedAgentsMCPOAuthAuthResponseShape> */
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
     * A timestamp in RFC 3339 format.
     */
    #[Optional('expires_at', nullable: true)]
    public ?\DateTimeInterface $expiresAt;

    /**
     * OAuth refresh token configuration returned in credential responses.
     */
    #[Optional(nullable: true)]
    public ?ManagedAgentsMCPOAuthRefreshResponse $refresh;

    /**
     * `new ManagedAgentsMCPOAuthAuthResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsMCPOAuthAuthResponse::with(mcpServerURL: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsMCPOAuthAuthResponse)->withMCPServerURL(...)->withType(...)
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
     * @param ManagedAgentsMCPOAuthRefreshResponse|ManagedAgentsMCPOAuthRefreshResponseShape|null $refresh
     */
    public static function with(
        string $mcpServerURL,
        Type|string $type,
        ?\DateTimeInterface $expiresAt = null,
        ManagedAgentsMCPOAuthRefreshResponse|array|null $refresh = null,
    ): self {
        $self = new self;

        $self['mcpServerURL'] = $mcpServerURL;
        $self['type'] = $type;

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
     * OAuth refresh token configuration returned in credential responses.
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
