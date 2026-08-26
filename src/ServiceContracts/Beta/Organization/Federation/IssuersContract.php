<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\Federation;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\Federation\Issuers\BetaFederationIssuer;
use Anthropic\Beta\Organization\Federation\Issuers\BetaJWKSDiscovery;
use Anthropic\Beta\Organization\Federation\Issuers\BetaJWKSExplicitURL;
use Anthropic\Beta\Organization\Federation\Issuers\BetaJWKSInline;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type JWKSShape from \Anthropic\Beta\Organization\Federation\Issuers\IssuerCreateParams\JWKS
 * @phpstan-import-type JWKSShape from \Anthropic\Beta\Organization\Federation\Issuers\IssuerUpdateParams\JWKS as JWKSShape1
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface IssuersContract
{
    /**
     * @api
     *
     * @param string $issuerURL body param: The `iss` claim value to match against
     * @param string $name Body param: Slug identifier (lowercase, digits, hyphens). Unique within the organization; a duplicate name returns 409.
     * @param bool|null $checkJTI Body param: Whether the jwt-bearer exchange enforces JTI single-use (replay protection) for tokens from this issuer. Defaults to true. Applies only to assertions carrying a `jti` claim; tokens without one are accepted without single-use enforcement.
     * @param JWKSShape $jwks Body param: How signing keys are obtained. Defaults to OIDC discovery.
     * @param int|null $maxJWTLifetimeSeconds Body param: Maximum allowed iat→exp spread for assertions from this issuer (1-176400 seconds, i.e. up to 49h). Defaults to 3600 (1h). Assertions must carry both `iat` and `exp`; a missing `iat` is rejected.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $issuerURL,
        string $name,
        ?bool $checkJTI = null,
        BetaJWKSDiscovery|array|BetaJWKSExplicitURL|BetaJWKSInline|null $jwks = null,
        ?int $maxJWTLifetimeSeconds = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaFederationIssuer;

    /**
     * @api
     *
     * @param string $federationIssuerID ID of the federation issuer
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $federationIssuerID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaFederationIssuer;

    /**
     * @api
     *
     * @param string $federationIssuerID path param: ID of the federation issuer to update
     * @param bool|null $checkJTI Body param: Whether the jwt-bearer exchange enforces JTI single-use (replay protection) for tokens from this issuer. Applies only to assertions carrying a `jti` claim; tokens without one are accepted without single-use enforcement.
     * @param string|null $issuerURL Body param: Replaces the `iss` claim value to match against. For discovery-mode issuers without a `discovery_base`, this is also the URL Anthropic fetches the OIDC discovery document and signing keys from, so changing it repoints the JWKS source. Changing the issuer URL to a well-known shared platform is rejected while any live rule under this issuer would not constrain tenant identity.
     * @param JWKSShape1|null $jwks body param: Replaces the entire JWKS configuration
     * @param bool|null $jwksPollingDisabled Body param: Only `false` is accepted, to re-enable polling after the system pauses it. Polling is paused automatically; sending `true` is rejected.
     * @param int|null $maxJWTLifetimeSeconds Body param: Maximum allowed iat→exp spread for assertions from this issuer (1-176400 seconds, i.e. up to 49h). Assertions must carry both `iat` and `exp`; a missing `iat` is rejected.
     * @param string|null $name Body param: Replaces the slug identifier (lowercase, digits, hyphens). Unique within the organization; a duplicate name returns 409.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $federationIssuerID,
        ?bool $checkJTI = null,
        ?string $issuerURL = null,
        BetaJWKSDiscovery|array|BetaJWKSExplicitURL|BetaJWKSInline|null $jwks = null,
        ?bool $jwksPollingDisabled = null,
        ?int $maxJWTLifetimeSeconds = null,
        ?string $name = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaFederationIssuer;

    /**
     * @api
     *
     * @param bool $includeArchived Query param: Include archived resources. Defaults to false.
     * @param int $limit query param: Number of results per page
     * @param string|null $page query param: Opaque cursor from a previous response's `next_page`
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<BetaFederationIssuer>
     *
     * @throws APIException
     */
    public function list(
        ?bool $includeArchived = null,
        ?int $limit = null,
        ?string $page = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;

    /**
     * @api
     *
     * @param string $federationIssuerID ID of the federation issuer to archive
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function archive(
        string $federationIssuerID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaFederationIssuer;
}
