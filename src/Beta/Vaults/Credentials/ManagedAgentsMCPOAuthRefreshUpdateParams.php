<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthRefreshUpdateParams\TokenEndpointAuth;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Parameters for updating OAuth refresh token configuration.
 *
 * @phpstan-import-type TokenEndpointAuthVariants from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthRefreshUpdateParams\TokenEndpointAuth
 * @phpstan-import-type TokenEndpointAuthShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthRefreshUpdateParams\TokenEndpointAuth
 *
 * @phpstan-type ManagedAgentsMCPOAuthRefreshUpdateParamsShape = array{
 *   refreshToken?: string|null,
 *   scope?: string|null,
 *   tokenEndpointAuth?: TokenEndpointAuthShape|null,
 * }
 */
final class ManagedAgentsMCPOAuthRefreshUpdateParams implements BaseModel
{
    /** @use SdkModel<ManagedAgentsMCPOAuthRefreshUpdateParamsShape> */
    use SdkModel;

    /**
     * Updated OAuth refresh token.
     */
    #[Optional('refresh_token', nullable: true)]
    public ?string $refreshToken;

    /**
     * Updated OAuth scope for the refresh request.
     */
    #[Optional(nullable: true)]
    public ?string $scope;

    /**
     * Updated HTTP Basic authentication parameters for the token endpoint.
     *
     * @var TokenEndpointAuthVariants|null $tokenEndpointAuth
     */
    #[Optional('token_endpoint_auth', union: TokenEndpointAuth::class)]
    public ManagedAgentsTokenEndpointAuthBasicUpdateParam|ManagedAgentsTokenEndpointAuthPostUpdateParam|null $tokenEndpointAuth;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param TokenEndpointAuthShape|null $tokenEndpointAuth
     */
    public static function with(
        ?string $refreshToken = null,
        ?string $scope = null,
        ManagedAgentsTokenEndpointAuthBasicUpdateParam|array|ManagedAgentsTokenEndpointAuthPostUpdateParam|null $tokenEndpointAuth = null,
    ): self {
        $self = new self;

        null !== $refreshToken && $self['refreshToken'] = $refreshToken;
        null !== $scope && $self['scope'] = $scope;
        null !== $tokenEndpointAuth && $self['tokenEndpointAuth'] = $tokenEndpointAuth;

        return $self;
    }

    /**
     * Updated OAuth refresh token.
     */
    public function withRefreshToken(?string $refreshToken): self
    {
        $self = clone $this;
        $self['refreshToken'] = $refreshToken;

        return $self;
    }

    /**
     * Updated OAuth scope for the refresh request.
     */
    public function withScope(?string $scope): self
    {
        $self = clone $this;
        $self['scope'] = $scope;

        return $self;
    }

    /**
     * Updated HTTP Basic authentication parameters for the token endpoint.
     *
     * @param TokenEndpointAuthShape $tokenEndpointAuth
     */
    public function withTokenEndpointAuth(
        ManagedAgentsTokenEndpointAuthBasicUpdateParam|array|ManagedAgentsTokenEndpointAuthPostUpdateParam $tokenEndpointAuth,
    ): self {
        $self = clone $this;
        $self['tokenEndpointAuth'] = $tokenEndpointAuth;

        return $self;
    }
}
