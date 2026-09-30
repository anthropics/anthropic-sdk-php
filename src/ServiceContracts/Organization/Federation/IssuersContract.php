<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Organization\Federation;

use Anthropic\Core\Exceptions\APIException;
use Anthropic\Organization\Federation\Issuers\FederationIssuer;
use Anthropic\Organization\Federation\Issuers\JWKSDiscovery;
use Anthropic\Organization\Federation\Issuers\JWKSExplicitURL;
use Anthropic\Organization\Federation\Issuers\JWKSInline;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type JWKSShape from \Anthropic\Organization\Federation\Issuers\IssuerCreateParams\JWKS
 * @phpstan-import-type JWKSShape from \Anthropic\Organization\Federation\Issuers\IssuerUpdateParams\JWKS as JWKSShape1
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface IssuersContract
{
    /**
     * @api
     *
     * @param string $issuerURL the `iss` claim value to match against
     * @param string $name Slug identifier (lowercase, digits, hyphens). Unique within the organization; a duplicate name returns 409.
     * @param bool|null $checkJTI Whether the jwt-bearer exchange enforces JTI single-use (replay protection) for tokens from this issuer. Defaults to true. Applies only to assertions carrying a `jti` claim; tokens without one are accepted without single-use enforcement.
     * @param JWKSShape $jwks How signing keys are obtained. Defaults to OIDC discovery.
     * @param int|null $maxJWTLifetimeSeconds Maximum allowed iat→exp spread for assertions from this issuer (1-176400 seconds, i.e. up to 49h). Defaults to 3600 (1h). Assertions must carry both `iat` and `exp`; a missing `iat` is rejected.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $issuerURL,
        string $name,
        ?bool $checkJTI = null,
        JWKSDiscovery|array|JWKSExplicitURL|JWKSInline|null $jwks = null,
        ?int $maxJWTLifetimeSeconds = null,
        RequestOptions|array|null $requestOptions = null,
    ): FederationIssuer;

    /**
     * @api
     *
     * @param string $federationIssuerID ID of the federation issuer
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $federationIssuerID,
        RequestOptions|array|null $requestOptions = null,
    ): FederationIssuer;

    /**
     * @api
     *
     * @param string $federationIssuerID ID of the federation issuer to update
     * @param bool|null $checkJTI Whether the jwt-bearer exchange enforces JTI single-use (replay protection) for tokens from this issuer. Applies only to assertions carrying a `jti` claim; tokens without one are accepted without single-use enforcement.
     * @param string|null $issuerURL Replaces the `iss` claim value to match against. For discovery-mode issuers without a `discovery_base`, this is also the URL Anthropic fetches the OIDC discovery document and signing keys from, so changing it repoints the JWKS source. Changing the issuer URL to a well-known shared platform is rejected while any live rule under this issuer would not constrain tenant identity.
     * @param JWKSShape1|null $jwks replaces the entire JWKS configuration
     * @param bool|null $jwksPollingDisabled Only `false` is accepted, to re-enable polling after the system pauses it. Polling is paused automatically; sending `true` is rejected.
     * @param int|null $maxJWTLifetimeSeconds Maximum allowed iat→exp spread for assertions from this issuer (1-176400 seconds, i.e. up to 49h). Assertions must carry both `iat` and `exp`; a missing `iat` is rejected.
     * @param string|null $name Replaces the slug identifier (lowercase, digits, hyphens). Unique within the organization; a duplicate name returns 409.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $federationIssuerID,
        ?bool $checkJTI = null,
        ?string $issuerURL = null,
        JWKSDiscovery|array|JWKSExplicitURL|JWKSInline|null $jwks = null,
        ?bool $jwksPollingDisabled = null,
        ?int $maxJWTLifetimeSeconds = null,
        ?string $name = null,
        RequestOptions|array|null $requestOptions = null,
    ): FederationIssuer;

    /**
     * @api
     *
     * @param bool $includeArchived Include archived resources. Defaults to false.
     * @param int $limit number of results per page
     * @param string|null $page opaque cursor from a previous response's `next_page`
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<FederationIssuer>
     *
     * @throws APIException
     */
    public function list(
        ?bool $includeArchived = null,
        ?int $limit = null,
        ?string $page = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;

    /**
     * @api
     *
     * @param string $federationIssuerID ID of the federation issuer to archive
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function archive(
        string $federationIssuerID,
        RequestOptions|array|null $requestOptions = null,
    ): FederationIssuer;
}
