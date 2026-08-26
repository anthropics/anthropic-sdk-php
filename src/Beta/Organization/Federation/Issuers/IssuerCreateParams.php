<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Federation\Issuers;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\Federation\Issuers\IssuerCreateParams\JWKS;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
 *
 * Register an OIDC issuer that Anthropic will trust for workload identity
 * federation in your organization.
 *
 * The `jwks` field controls how the issuer's signing keys are obtained and
 * takes one of three shapes selected by `type`: `discovery` (resolve keys
 * through OIDC discovery), `explicit_url` (fetch keys from a fixed JWKS
 * URL), or `inline` (provide a static key set). When `jwks.type` is
 * `discovery` and no `discovery_base` is set, the issuer URL must be
 * publicly reachable over HTTPS so Anthropic can fetch the discovery
 * document; for `explicit_url` and `inline` modes the issuer URL is only
 * matched as the JWT's `iss` claim and is not fetched.
 *
 * @see Anthropic\Services\Beta\Organization\Federation\IssuersService::create()
 *
 * @phpstan-import-type JWKSVariants from \Anthropic\Beta\Organization\Federation\Issuers\IssuerCreateParams\JWKS
 * @phpstan-import-type JWKSShape from \Anthropic\Beta\Organization\Federation\Issuers\IssuerCreateParams\JWKS
 *
 * @phpstan-type IssuerCreateParamsShape = array{
 *   issuerURL: string,
 *   name: string,
 *   checkJTI?: bool|null,
 *   jwks?: JWKSShape|null,
 *   maxJWTLifetimeSeconds?: int|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class IssuerCreateParams implements BaseModel
{
    /** @use SdkModel<IssuerCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * The `iss` claim value to match against.
     */
    #[Required('issuer_url')]
    public string $issuerURL;

    /**
     * Slug identifier (lowercase, digits, hyphens). Unique within the organization; a duplicate name returns 409.
     */
    #[Required]
    public string $name;

    /**
     * Whether the jwt-bearer exchange enforces JTI single-use (replay protection) for tokens from this issuer. Defaults to true. Applies only to assertions carrying a `jti` claim; tokens without one are accepted without single-use enforcement.
     */
    #[Optional('check_jti', nullable: true)]
    public ?bool $checkJTI;

    /**
     * How signing keys are obtained. Defaults to OIDC discovery.
     *
     * @var JWKSVariants|null $jwks
     */
    #[Optional(union: JWKS::class)]
    public BetaJWKSDiscovery|BetaJWKSExplicitURL|BetaJWKSInline|null $jwks;

    /**
     * Maximum allowed iat→exp spread for assertions from this issuer (1-176400 seconds, i.e. up to 49h). Defaults to 3600 (1h). Assertions must carry both `iat` and `exp`; a missing `iat` is rejected.
     */
    #[Optional('max_jwt_lifetime_seconds', nullable: true)]
    public ?int $maxJWTLifetimeSeconds;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new IssuerCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * IssuerCreateParams::with(issuerURL: ..., name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new IssuerCreateParams)->withIssuerURL(...)->withName(...)
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
     * @param JWKSShape|null $jwks
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        string $issuerURL,
        string $name,
        ?bool $checkJTI = null,
        BetaJWKSDiscovery|array|BetaJWKSExplicitURL|BetaJWKSInline|null $jwks = null,
        ?int $maxJWTLifetimeSeconds = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        $self['issuerURL'] = $issuerURL;
        $self['name'] = $name;

        null !== $checkJTI && $self['checkJTI'] = $checkJTI;
        null !== $jwks && $self['jwks'] = $jwks;
        null !== $maxJWTLifetimeSeconds && $self['maxJWTLifetimeSeconds'] = $maxJWTLifetimeSeconds;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * The `iss` claim value to match against.
     */
    public function withIssuerURL(string $issuerURL): self
    {
        $self = clone $this;
        $self['issuerURL'] = $issuerURL;

        return $self;
    }

    /**
     * Slug identifier (lowercase, digits, hyphens). Unique within the organization; a duplicate name returns 409.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Whether the jwt-bearer exchange enforces JTI single-use (replay protection) for tokens from this issuer. Defaults to true. Applies only to assertions carrying a `jti` claim; tokens without one are accepted without single-use enforcement.
     */
    public function withCheckJTI(?bool $checkJTI): self
    {
        $self = clone $this;
        $self['checkJTI'] = $checkJTI;

        return $self;
    }

    /**
     * How signing keys are obtained. Defaults to OIDC discovery.
     *
     * @param JWKSShape $jwks
     */
    public function withJWKS(
        BetaJWKSDiscovery|array|BetaJWKSExplicitURL|BetaJWKSInline $jwks
    ): self {
        $self = clone $this;
        $self['jwks'] = $jwks;

        return $self;
    }

    /**
     * Maximum allowed iat→exp spread for assertions from this issuer (1-176400 seconds, i.e. up to 49h). Defaults to 3600 (1h). Assertions must carry both `iat` and `exp`; a missing `iat` is rejected.
     */
    public function withMaxJWTLifetimeSeconds(?int $maxJWTLifetimeSeconds): self
    {
        $self = clone $this;
        $self['maxJWTLifetimeSeconds'] = $maxJWTLifetimeSeconds;

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
