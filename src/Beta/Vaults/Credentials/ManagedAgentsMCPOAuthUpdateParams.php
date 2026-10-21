<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Parameters for updating an MCP OAuth credential. The `mcp_server_url` is immutable.
 *
 * @phpstan-import-type ManagedAgentsMCPOAuthRefreshUpdateParamsShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthRefreshUpdateParams
 *
 * @phpstan-type ManagedAgentsMCPOAuthUpdateParamsShape = array{
 *   type: 'mcp_oauth',
 *   accessToken?: string|null,
 *   expiresAt?: \DateTimeInterface|null,
 *   refresh?: null|ManagedAgentsMCPOAuthRefreshUpdateParams|ManagedAgentsMCPOAuthRefreshUpdateParamsShape,
 * }
 */
final class ManagedAgentsMCPOAuthUpdateParams implements BaseModel
{
    /** @use SdkModel<ManagedAgentsMCPOAuthUpdateParamsShape> */
    use SdkModel;

    /** @var 'mcp_oauth' $type */
    #[Required(type: new ConstantOf('mcp_oauth'))]
    public string $type = 'mcp_oauth';

    /**
     * The new OAuth access token to replace the stored one.
     */
    #[Optional('access_token', nullable: true)]
    public ?string $accessToken;

    /**
     * When the credential's access token expires, in RFC 3339. Leave it out to keep the stored expiry.
     *
     * If you send a new `access_token`, send its `expires_at` too, or the new token keeps the old expiry.
     *
     * Must be in the future.
     */
    #[Optional('expires_at', nullable: true)]
    public ?\DateTimeInterface $expiresAt;

    /**
     * Updated refresh token configuration.
     */
    #[Optional(nullable: true)]
    public ?ManagedAgentsMCPOAuthRefreshUpdateParams $refresh;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param ManagedAgentsMCPOAuthRefreshUpdateParams|ManagedAgentsMCPOAuthRefreshUpdateParamsShape|null $refresh
     */
    public static function with(
        ?string $accessToken = null,
        ?\DateTimeInterface $expiresAt = null,
        ManagedAgentsMCPOAuthRefreshUpdateParams|array|null $refresh = null,
    ): self {
        $self = new self;

        null !== $accessToken && $self['accessToken'] = $accessToken;
        null !== $expiresAt && $self['expiresAt'] = $expiresAt;
        null !== $refresh && $self['refresh'] = $refresh;

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
     * The new OAuth access token to replace the stored one.
     */
    public function withAccessToken(?string $accessToken): self
    {
        $self = clone $this;
        $self['accessToken'] = $accessToken;

        return $self;
    }

    /**
     * When the credential's access token expires, in RFC 3339. Leave it out to keep the stored expiry.
     *
     * If you send a new `access_token`, send its `expires_at` too, or the new token keeps the old expiry.
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
     * Updated refresh token configuration.
     *
     * @param ManagedAgentsMCPOAuthRefreshUpdateParams|ManagedAgentsMCPOAuthRefreshUpdateParamsShape|null $refresh
     */
    public function withRefresh(
        ManagedAgentsMCPOAuthRefreshUpdateParams|array|null $refresh
    ): self {
        $self = clone $this;
        $self['refresh'] = $refresh;

        return $self;
    }
}
