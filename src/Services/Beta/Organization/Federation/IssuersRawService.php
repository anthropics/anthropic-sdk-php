<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\Federation;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\Federation\Issuers\BetaFederationIssuer;
use Anthropic\Beta\Organization\Federation\Issuers\IssuerArchiveParams;
use Anthropic\Beta\Organization\Federation\Issuers\IssuerCreateParams;
use Anthropic\Beta\Organization\Federation\Issuers\IssuerListParams;
use Anthropic\Beta\Organization\Federation\Issuers\IssuerRetrieveParams;
use Anthropic\Beta\Organization\Federation\Issuers\IssuerUpdateParams;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\Federation\IssuersRawContract;

/**
 * @phpstan-import-type JWKSShape from \Anthropic\Beta\Organization\Federation\Issuers\IssuerCreateParams\JWKS
 * @phpstan-import-type JWKSShape from \Anthropic\Beta\Organization\Federation\Issuers\IssuerUpdateParams\JWKS as JWKSShape1
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
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|IssuerCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaFederationIssuer>
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
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/organizations/federation_issuers?beta=true',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: BetaFederationIssuer::class,
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
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|IssuerRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaFederationIssuer>
     *
     * @throws APIException
     */
    public function retrieve(
        string $federationIssuerID,
        array|IssuerRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = IssuerRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: [
                'v1/organizations/federation_issuers/%1$s?beta=true',
                $federationIssuerID,
            ],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: $options,
            convert: BetaFederationIssuer::class,
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
     * @param string $federationIssuerID path param: ID of the federation issuer to update
     * @param array{
     *   checkJTI?: bool|null,
     *   issuerURL?: string|null,
     *   jwks?: JWKSShape1|null,
     *   jwksPollingDisabled?: bool|null,
     *   maxJWTLifetimeSeconds?: int|null,
     *   name?: string|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|IssuerUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaFederationIssuer>
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
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/organizations/federation_issuers/%1$s?beta=true',
                $federationIssuerID,
            ],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: BetaFederationIssuer::class,
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
     *   includeArchived?: bool,
     *   limit?: int,
     *   page?: string|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|IssuerListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaFederationIssuer>>
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
        $query_params = array_flip(['includeArchived', 'limit', 'page']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/organizations/federation_issuers?beta=true',
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                ['includeArchived' => 'include_archived'],
            ),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: $options,
            convert: BetaFederationIssuer::class,
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
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|IssuerArchiveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaFederationIssuer>
     *
     * @throws APIException
     */
    public function archive(
        string $federationIssuerID,
        array|IssuerArchiveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = IssuerArchiveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/organizations/federation_issuers/%1$s/archive?beta=true',
                $federationIssuerID,
            ],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: $options,
            convert: BetaFederationIssuer::class,
        );
    }
}
