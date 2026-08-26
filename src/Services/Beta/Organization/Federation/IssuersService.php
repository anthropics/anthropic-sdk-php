<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\Federation;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\Federation\Issuers\BetaFederationIssuer;
use Anthropic\Beta\Organization\Federation\Issuers\BetaJWKSDiscovery;
use Anthropic\Beta\Organization\Federation\Issuers\BetaJWKSExplicitURL;
use Anthropic\Beta\Organization\Federation\Issuers\BetaJWKSInline;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\Federation\IssuersContract;

/**
 * @phpstan-import-type JWKSShape from \Anthropic\Beta\Organization\Federation\Issuers\IssuerCreateParams\JWKS
 * @phpstan-import-type JWKSShape from \Anthropic\Beta\Organization\Federation\Issuers\IssuerUpdateParams\JWKS as JWKSShape1
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class IssuersService implements IssuersContract
{
    /**
     * @api
     */
    public IssuersRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new IssuersRawService($client);
    }

    /**
     * @api
     *
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
    ): BetaFederationIssuer {
        $params = Util::removeNulls(
            [
                'issuerURL' => $issuerURL,
                'name' => $name,
                'checkJTI' => $checkJTI,
                'jwks' => $jwks,
                'maxJWTLifetimeSeconds' => $maxJWTLifetimeSeconds,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
     *
     * Retrieve a federation issuer by its ID (`fdis_...`).
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
    ): BetaFederationIssuer {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($federationIssuerID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
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
    ): BetaFederationIssuer {
        $params = Util::removeNulls(
            [
                'checkJTI' => $checkJTI,
                'issuerURL' => $issuerURL,
                'jwks' => $jwks,
                'jwksPollingDisabled' => $jwksPollingDisabled,
                'maxJWTLifetimeSeconds' => $maxJWTLifetimeSeconds,
                'name' => $name,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($federationIssuerID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
     *
     * List federation issuers in your organization.
     *
     * Archived issuers are excluded unless `include_archived=true`.
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
    ): PageCursor {
        $params = Util::removeNulls(
            [
                'includeArchived' => $includeArchived,
                'limit' => $limit,
                'page' => $page,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
     *
     * Archive a federation issuer.
     *
     * Idempotent; re-archiving returns the issuer with its original
     * `archived_at`. Rejected with 400 if any live (non-archived) federation
     * rule still references the issuer; archive those rules first (a rule's
     * issuer cannot be changed), or recreate them against another issuer.
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
    ): BetaFederationIssuer {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->archive($federationIssuerID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
