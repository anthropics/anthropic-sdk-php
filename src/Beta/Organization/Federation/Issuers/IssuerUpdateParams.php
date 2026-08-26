<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Federation\Issuers;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\Federation\Issuers\IssuerUpdateParams\JWKS;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
 *
 * Partially update a federation issuer.
 *
 * Setting `jwks` replaces the full JWKS shape at once. Archived issuers
 * cannot be updated; this returns 400. Create a new issuer instead.
 *
 * Updating an issuer that backs a rule with a scope outside
 * `workspace:developer` or `workspace:inference` requires a Console
 * session.
 *
 * @see Anthropic\Services\Beta\Organization\Federation\IssuersService::update()
 *
 * @phpstan-import-type JWKSVariants from \Anthropic\Beta\Organization\Federation\Issuers\IssuerUpdateParams\JWKS
 * @phpstan-import-type JWKSShape from \Anthropic\Beta\Organization\Federation\Issuers\IssuerUpdateParams\JWKS
 *
 * @phpstan-type IssuerUpdateParamsShape = array{
 *   checkJTI?: bool|null,
 *   issuerURL?: string|null,
 *   jwks?: JWKSShape|null,
 *   jwksPollingDisabled?: bool|null,
 *   maxJWTLifetimeSeconds?: int|null,
 *   name?: string|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class IssuerUpdateParams implements BaseModel
{
    /** @use SdkModel<IssuerUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Whether the jwt-bearer exchange enforces JTI single-use (replay protection) for tokens from this issuer. Applies only to assertions carrying a `jti` claim; tokens without one are accepted without single-use enforcement.
     */
    #[Optional('check_jti', nullable: true)]
    public ?bool $checkJTI;

    /**
     * Replaces the `iss` claim value to match against. For discovery-mode issuers without a `discovery_base`, this is also the URL Anthropic fetches the OIDC discovery document and signing keys from, so changing it repoints the JWKS source. Changing the issuer URL to a well-known shared platform is rejected while any live rule under this issuer would not constrain tenant identity.
     */
    #[Optional('issuer_url', nullable: true)]
    public ?string $issuerURL;

    /**
     * Replaces the entire JWKS configuration.
     *
     * @var JWKSVariants|null $jwks
     */
    #[Optional(union: JWKS::class, nullable: true)]
    public BetaJWKSDiscovery|BetaJWKSExplicitURL|BetaJWKSInline|null $jwks;

    /**
     * Only `false` is accepted, to re-enable polling after the system pauses it. Polling is paused automatically; sending `true` is rejected.
     */
    #[Optional('jwks_polling_disabled', nullable: true)]
    public ?bool $jwksPollingDisabled;

    /**
     * Maximum allowed iat→exp spread for assertions from this issuer (1-176400 seconds, i.e. up to 49h). Assertions must carry both `iat` and `exp`; a missing `iat` is rejected.
     */
    #[Optional('max_jwt_lifetime_seconds', nullable: true)]
    public ?int $maxJWTLifetimeSeconds;

    /**
     * Replaces the slug identifier (lowercase, digits, hyphens). Unique within the organization; a duplicate name returns 409.
     */
    #[Optional(nullable: true)]
    public ?string $name;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param JWKSShape|null $jwks
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        ?bool $checkJTI = null,
        ?string $issuerURL = null,
        BetaJWKSDiscovery|array|BetaJWKSExplicitURL|BetaJWKSInline|null $jwks = null,
        ?bool $jwksPollingDisabled = null,
        ?int $maxJWTLifetimeSeconds = null,
        ?string $name = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        null !== $checkJTI && $self['checkJTI'] = $checkJTI;
        null !== $issuerURL && $self['issuerURL'] = $issuerURL;
        null !== $jwks && $self['jwks'] = $jwks;
        null !== $jwksPollingDisabled && $self['jwksPollingDisabled'] = $jwksPollingDisabled;
        null !== $maxJWTLifetimeSeconds && $self['maxJWTLifetimeSeconds'] = $maxJWTLifetimeSeconds;
        null !== $name && $self['name'] = $name;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Whether the jwt-bearer exchange enforces JTI single-use (replay protection) for tokens from this issuer. Applies only to assertions carrying a `jti` claim; tokens without one are accepted without single-use enforcement.
     */
    public function withCheckJTI(?bool $checkJTI): self
    {
        $self = clone $this;
        $self['checkJTI'] = $checkJTI;

        return $self;
    }

    /**
     * Replaces the `iss` claim value to match against. For discovery-mode issuers without a `discovery_base`, this is also the URL Anthropic fetches the OIDC discovery document and signing keys from, so changing it repoints the JWKS source. Changing the issuer URL to a well-known shared platform is rejected while any live rule under this issuer would not constrain tenant identity.
     */
    public function withIssuerURL(?string $issuerURL): self
    {
        $self = clone $this;
        $self['issuerURL'] = $issuerURL;

        return $self;
    }

    /**
     * Replaces the entire JWKS configuration.
     *
     * @param JWKSShape|null $jwks
     */
    public function withJWKS(
        BetaJWKSDiscovery|array|BetaJWKSExplicitURL|BetaJWKSInline|null $jwks
    ): self {
        $self = clone $this;
        $self['jwks'] = $jwks;

        return $self;
    }

    /**
     * Only `false` is accepted, to re-enable polling after the system pauses it. Polling is paused automatically; sending `true` is rejected.
     */
    public function withJWKSPollingDisabled(?bool $jwksPollingDisabled): self
    {
        $self = clone $this;
        $self['jwksPollingDisabled'] = $jwksPollingDisabled;

        return $self;
    }

    /**
     * Maximum allowed iat→exp spread for assertions from this issuer (1-176400 seconds, i.e. up to 49h). Assertions must carry both `iat` and `exp`; a missing `iat` is rejected.
     */
    public function withMaxJWTLifetimeSeconds(?int $maxJWTLifetimeSeconds): self
    {
        $self = clone $this;
        $self['maxJWTLifetimeSeconds'] = $maxJWTLifetimeSeconds;

        return $self;
    }

    /**
     * Replaces the slug identifier (lowercase, digits, hyphens). Unique within the organization; a duplicate name returns 409.
     */
    public function withName(?string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas
     */
    public function withBetas(array $betas): self
    {
        $self = clone $this;
        $self['betas'] = $betas;

        return $self;
    }
}
