<?php

declare(strict_types=1);

namespace Anthropic\Services\Organization\Federation;

use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\Organization\Federation\Issuers\FederationIssuer;
use Anthropic\Organization\Federation\Issuers\IssuerCreateParams;
use Anthropic\Organization\Federation\Issuers\IssuerListParams;
use Anthropic\Organization\Federation\Issuers\IssuerUpdateParams;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Organization\Federation\IssuersRawContract;

/**
 * @phpstan-import-type JWKSShape from \Anthropic\Organization\Federation\Issuers\IssuerCreateParams\JWKS
 * @phpstan-import-type JWKSShape from \Anthropic\Organization\Federation\Issuers\IssuerUpdateParams\JWKS as JWKSShape1
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class IssuersRawService implements IssuersRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

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
     * @param array{
     *   issuerURL: string,
     *   name: string,
     *   checkJTI?: bool|null,
     *   jwks?: JWKSShape,
     *   maxJWTLifetimeSeconds?: int|null,
     * }|IssuerCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FederationIssuer>
     *
     * @throws APIException
     */
    public function create(
        array|IssuerCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = IssuerCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/organizations/federation_issuers',
            body: (object) $parsed,
            options: $options,
            convert: FederationIssuer::class,
        );
    }

    /**
     * @api
     *
     * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
     *
     * Retrieve a federation issuer by its ID (`fdis_...`).
     *
     * @param string $federationIssuerID ID of the federation issuer
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FederationIssuer>
     *
     * @throws APIException
     */
    public function retrieve(
        string $federationIssuerID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/organizations/federation_issuers/%1$s', $federationIssuerID],
            options: $requestOptions,
            convert: FederationIssuer::class,
        );
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
     * @param string $federationIssuerID ID of the federation issuer to update
     * @param array{
     *   checkJTI?: bool|null,
     *   issuerURL?: string|null,
     *   jwks?: JWKSShape1|null,
     *   jwksPollingDisabled?: bool|null,
     *   maxJWTLifetimeSeconds?: int|null,
     *   name?: string|null,
     * }|IssuerUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FederationIssuer>
     *
     * @throws APIException
     */
    public function update(
        string $federationIssuerID,
        array|IssuerUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = IssuerUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/organizations/federation_issuers/%1$s', $federationIssuerID],
            body: (object) $parsed,
            options: $options,
            convert: FederationIssuer::class,
        );
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
     * @param array{
     *   includeArchived?: bool, limit?: int, page?: string|null
     * }|IssuerListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<FederationIssuer>>
     *
     * @throws APIException
     */
    public function list(
        array|IssuerListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = IssuerListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/organizations/federation_issuers',
            query: Util::array_transform_keys(
                $parsed,
                ['includeArchived' => 'include_archived']
            ),
            options: $options,
            convert: FederationIssuer::class,
            page: PageCursor::class,
        );
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
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FederationIssuer>
     *
     * @throws APIException
     */
    public function archive(
        string $federationIssuerID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/organizations/federation_issuers/%1$s/archive', $federationIssuerID,
            ],
            options: $requestOptions,
            convert: FederationIssuer::class,
        );
    }
}
