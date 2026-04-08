<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthUpdateParams\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Parameters for updating an MCP OAuth credential. The `mcp_server_url` is immutable.
 *
 * @phpstan-import-type ManagedAgentsMCPOAuthRefreshUpdateParamsShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthRefreshUpdateParams
 *
 * @phpstan-type ManagedAgentsMCPOAuthUpdateParamsShape = array{
 *   type: Type|value-of<Type>,
 *   accessToken?: string|null,
 *   expiresAt?: \DateTimeInterface|null,
 *   refresh?: null|ManagedAgentsMCPOAuthRefreshUpdateParams|ManagedAgentsMCPOAuthRefreshUpdateParamsShape,
 * }
 */
final class ManagedAgentsMCPOAuthUpdateParams implements BaseModel
{
    /** @use SdkModel<ManagedAgentsMCPOAuthUpdateParamsShape> */
    use SdkModel;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * Updated OAuth access token.
     */
    #[Optional('access_token', nullable: true)]
    public ?string $accessToken;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Optional('expires_at', nullable: true)]
    public ?\DateTimeInterface $expiresAt;

    /**
     * Parameters for updating OAuth refresh token configuration.
     */
    #[Optional(nullable: true)]
    public ?ManagedAgentsMCPOAuthRefreshUpdateParams $refresh;

    /**
     * `new ManagedAgentsMCPOAuthUpdateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsMCPOAuthUpdateParams::with(type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsMCPOAuthUpdateParams)->withType(...)
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
     * @param ManagedAgentsMCPOAuthRefreshUpdateParams|ManagedAgentsMCPOAuthRefreshUpdateParamsShape|null $refresh
     */
    public static function with(
        Type|string $type,
        ?string $accessToken = null,
        ?\DateTimeInterface $expiresAt = null,
        ManagedAgentsMCPOAuthRefreshUpdateParams|array|null $refresh = null,
    ): self {
        $self = new self;

        $self['type'] = $type;

        null !== $accessToken && $self['accessToken'] = $accessToken;
        null !== $expiresAt && $self['expiresAt'] = $expiresAt;
        null !== $refresh && $self['refresh'] = $refresh;

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
     * Updated OAuth access token.
     */
    public function withAccessToken(?string $accessToken): self
    {
        $self = clone $this;
        $self['accessToken'] = $accessToken;

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
     * Parameters for updating OAuth refresh token configuration.
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
