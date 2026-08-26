<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\ServiceAccounts\ServiceAccount;
use Anthropic\Beta\Organization\ServiceAccounts\ServiceAccountArchiveParams;
use Anthropic\Beta\Organization\ServiceAccounts\ServiceAccountCreateParams;
use Anthropic\Beta\Organization\ServiceAccounts\ServiceAccountCreateParams\OrganizationRole;
use Anthropic\Beta\Organization\ServiceAccounts\ServiceAccountListParams;
use Anthropic\Beta\Organization\ServiceAccounts\ServiceAccountRetrieveParams;
use Anthropic\Beta\Organization\ServiceAccounts\ServiceAccountUpdateParams;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\ServiceAccountsRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class ServiceAccountsRawService implements ServiceAccountsRawContract
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
     * Create a service account.
     *
     * A service account is a named workload identity that federation rules
     * target. `organization_role` is `developer` (default) or `admin`; a rule
     * may only be created or retargeted to grant `org:admin` scope when the
     * target's `organization_role` is `admin`. Creating an `admin`-role service
     * account requires an interactive credential (a user OAuth token or a
     * Console session) — a workload may only create `developer`-role service
     * accounts.
     *
     * @param array{
     *   name: string,
     *   description?: string|null,
     *   organizationRole?: OrganizationRole|value-of<OrganizationRole>,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|ServiceAccountCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ServiceAccount>
     *
     * @throws APIException
     */
    public function create(
        array|ServiceAccountCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ServiceAccountCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/organizations/service_accounts?beta=true',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: ServiceAccount::class,
        );
    }

    /**
     * @api
     *
     * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
     *
     * Retrieve a service account by its ID (`svac_...`).
     *
     * @param string $serviceAccountID ID of the service account
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|ServiceAccountRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ServiceAccount>
     *
     * @throws APIException
     */
    public function retrieve(
        string $serviceAccountID,
        array|ServiceAccountRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ServiceAccountRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: [
                'v1/organizations/service_accounts/%1$s?beta=true', $serviceAccountID,
            ],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: $options,
            convert: ServiceAccount::class,
        );
    }

    /**
     * @api
     *
     * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
     *
     * Update a service account.
     *
     * Only `description` and `organization_role` are mutable; `name` cannot be
     * changed. Archived service accounts cannot be updated; this returns 400.
     * Setting `organization_role` to `admin` (even when unchanged) requires an
     * interactive credential (a user OAuth token or a Console session).
     *
     * @param string $serviceAccountID path param: ID of the service account to update
     * @param array{
     *   description?: string|null,
     *   organizationRole?: ServiceAccountUpdateParams\OrganizationRole|value-of<ServiceAccountUpdateParams\OrganizationRole>|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|ServiceAccountUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ServiceAccount>
     *
     * @throws APIException
     */
    public function update(
        string $serviceAccountID,
        array|ServiceAccountUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ServiceAccountUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/organizations/service_accounts/%1$s?beta=true', $serviceAccountID,
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
            convert: ServiceAccount::class,
        );
    }

    /**
     * @api
     *
     * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
     *
     * List service accounts in the caller's organization.
     *
     * Results are ordered by creation time, newest first. Use `limit` and the
     * `next_page` cursor to paginate; set `include_archived=true` to include
     * archived service accounts.
     *
     * @param array{
     *   includeArchived?: bool,
     *   limit?: int,
     *   page?: string|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|ServiceAccountListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<ServiceAccount>>
     *
     * @throws APIException
     */
    public function list(
        array|ServiceAccountListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ServiceAccountListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(['includeArchived', 'limit', 'page']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/organizations/service_accounts?beta=true',
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                ['includeArchived' => 'include_archived'],
            ),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: $options,
            convert: ServiceAccount::class,
            page: PageCursor::class,
        );
    }

    /**
     * @api
     *
     * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
     *
     * Archive a service account.
     *
     * Idempotent; re-archiving returns the service account with its original
     * `archived_at`. Rejected with 400 if any live (non-archived) federation
     * rule still targets this service account, same as issuer archival; archive
     * those rules first or change their target to another service account.
     *
     * @param string $serviceAccountID ID of the service account to archive
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|ServiceAccountArchiveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ServiceAccount>
     *
     * @throws APIException
     */
    public function archive(
        string $serviceAccountID,
        array|ServiceAccountArchiveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ServiceAccountArchiveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/organizations/service_accounts/%1$s/archive?beta=true',
                $serviceAccountID,
            ],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: $options,
            convert: ServiceAccount::class,
        );
    }
}
