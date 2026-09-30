<?php

declare(strict_types=1);

namespace Anthropic\Services\Organization;

use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\Organization\ServiceAccounts\ServiceAccount;
use Anthropic\Organization\ServiceAccounts\ServiceAccountCreateParams;
use Anthropic\Organization\ServiceAccounts\ServiceAccountCreateParams\OrganizationRole;
use Anthropic\Organization\ServiceAccounts\ServiceAccountListParams;
use Anthropic\Organization\ServiceAccounts\ServiceAccountUpdateParams;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Organization\ServiceAccountsRawContract;

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

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/organizations/service_accounts',
            body: (object) $parsed,
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
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ServiceAccount>
     *
     * @throws APIException
     */
    public function retrieve(
        string $serviceAccountID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/organizations/service_accounts/%1$s', $serviceAccountID],
            options: $requestOptions,
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
     * @param string $serviceAccountID ID of the service account to update
     * @param array{
     *   description?: string|null,
     *   organizationRole?: ServiceAccountUpdateParams\OrganizationRole|value-of<ServiceAccountUpdateParams\OrganizationRole>|null,
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

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/organizations/service_accounts/%1$s', $serviceAccountID],
            body: (object) $parsed,
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
     *   includeArchived?: bool, limit?: int, page?: string|null
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

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/organizations/service_accounts',
            query: Util::array_transform_keys(
                $parsed,
                ['includeArchived' => 'include_archived']
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
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ServiceAccount>
     *
     * @throws APIException
     */
    public function archive(
        string $serviceAccountID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/organizations/service_accounts/%1$s/archive', $serviceAccountID,
            ],
            options: $requestOptions,
            convert: ServiceAccount::class,
        );
    }
}
