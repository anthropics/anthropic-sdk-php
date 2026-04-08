<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthRefreshResponse\TokenEndpointAuth;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * OAuth refresh token configuration returned in credential responses.
 *
 * @phpstan-import-type TokenEndpointAuthVariants from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthRefreshResponse\TokenEndpointAuth
 * @phpstan-import-type TokenEndpointAuthShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthRefreshResponse\TokenEndpointAuth
 *
 * @phpstan-type ManagedAgentsMCPOAuthRefreshResponseShape = array{
 *   clientID: string,
 *   tokenEndpoint: string,
 *   tokenEndpointAuth: TokenEndpointAuthShape,
 *   resource?: string|null,
 *   scope?: string|null,
 * }
 */
final class ManagedAgentsMCPOAuthRefreshResponse implements BaseModel
{
    /** @use SdkModel<ManagedAgentsMCPOAuthRefreshResponseShape> */
    use SdkModel;

    /**
     * OAuth client ID.
     */
    #[Required('client_id')]
    public string $clientID;

    /**
     * Token endpoint URL used to refresh the access token.
     */
    #[Required('token_endpoint')]
    public string $tokenEndpoint;

    /**
     * Token endpoint requires no client authentication.
     *
     * @var TokenEndpointAuthVariants $tokenEndpointAuth
     */
    #[Required('token_endpoint_auth', union: TokenEndpointAuth::class)]
    public ManagedAgentsTokenEndpointAuthNoneResponse|ManagedAgentsTokenEndpointAuthBasicResponse|ManagedAgentsTokenEndpointAuthPostResponse $tokenEndpointAuth;

    /**
     * OAuth resource indicator.
     */
    #[Optional(nullable: true)]
    public ?string $resource;

    /**
     * OAuth scope for the refresh request.
     */
    #[Optional(nullable: true)]
    public ?string $scope;

    /**
     * `new ManagedAgentsMCPOAuthRefreshResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsMCPOAuthRefreshResponse::with(
     *   clientID: ..., tokenEndpoint: ..., tokenEndpointAuth: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsMCPOAuthRefreshResponse)
     *   ->withClientID(...)
     *   ->withTokenEndpoint(...)
     *   ->withTokenEndpointAuth(...)
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
     * @param TokenEndpointAuthShape $tokenEndpointAuth
     */
    public static function with(
        string $clientID,
        string $tokenEndpoint,
        ManagedAgentsTokenEndpointAuthNoneResponse|array|ManagedAgentsTokenEndpointAuthBasicResponse|ManagedAgentsTokenEndpointAuthPostResponse $tokenEndpointAuth,
        ?string $resource = null,
        ?string $scope = null,
    ): self {
        $self = new self;

        $self['clientID'] = $clientID;
        $self['tokenEndpoint'] = $tokenEndpoint;
        $self['tokenEndpointAuth'] = $tokenEndpointAuth;

        null !== $resource && $self['resource'] = $resource;
        null !== $scope && $self['scope'] = $scope;

        return $self;
    }

    /**
     * OAuth client ID.
     */
    public function withClientID(string $clientID): self
    {
        $self = clone $this;
        $self['clientID'] = $clientID;

        return $self;
    }

    /**
     * Token endpoint URL used to refresh the access token.
     */
    public function withTokenEndpoint(string $tokenEndpoint): self
    {
        $self = clone $this;
        $self['tokenEndpoint'] = $tokenEndpoint;

        return $self;
    }

    /**
     * Token endpoint requires no client authentication.
     *
     * @param TokenEndpointAuthShape $tokenEndpointAuth
     */
    public function withTokenEndpointAuth(
        ManagedAgentsTokenEndpointAuthNoneResponse|array|ManagedAgentsTokenEndpointAuthBasicResponse|ManagedAgentsTokenEndpointAuthPostResponse $tokenEndpointAuth,
    ): self {
        $self = clone $this;
        $self['tokenEndpointAuth'] = $tokenEndpointAuth;

        return $self;
    }

    /**
     * OAuth resource indicator.
     */
    public function withResource(?string $resource): self
    {
        $self = clone $this;
        $self['resource'] = $resource;

        return $self;
    }

    /**
     * OAuth scope for the refresh request.
     */
    public function withScope(?string $scope): self
    {
        $self = clone $this;
        $self['scope'] = $scope;

        return $self;
    }
}
