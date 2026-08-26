<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\Workspaces;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\ServiceAccounts\ServiceAccountWorkspaceMember;
use Anthropic\Beta\Organization\Workspaces\NoBillingWorkspaceRole;
use Anthropic\Beta\Organization\Workspaces\ServiceAccounts\ServiceAccountAddParams;
use Anthropic\Beta\Organization\Workspaces\ServiceAccounts\ServiceAccountListParams;
use Anthropic\Beta\Organization\Workspaces\ServiceAccounts\ServiceAccountRemoveParams;
use Anthropic\Beta\Organization\Workspaces\ServiceAccounts\ServiceAccountRemoveResponse;
use Anthropic\Beta\Organization\Workspaces\ServiceAccounts\ServiceAccountRetrieveParams;
use Anthropic\Beta\Organization\Workspaces\ServiceAccounts\ServiceAccountUpdateParams;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\Workspaces\ServiceAccountsRawContract;

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
     * Retrieve a service account's membership in a workspace.
     *
     * Returns the membership record, including the service account's
     * `workspace_role` in this workspace. Archived workspaces return 400. For
     * the default workspace, returns the implicit (`implicit: true`)
     * membership when no explicit membership exists; an explicitly added
     * membership is returned with its assigned role. An archived service
     * account returns 404.
     *
     * @param string $serviceAccountID path param: ID of the service account
     * @param array{
     *   workspaceID: string,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|ServiceAccountRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ServiceAccountWorkspaceMember>
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
        $workspaceID = $parsed['workspaceID'];
        unset($parsed['workspaceID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: [
                'v1/organizations/workspaces/%1$s/service_accounts/%2$s?beta=true',
                $workspaceID,
                $serviceAccountID,
            ],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: $options,
            convert: ServiceAccountWorkspaceMember::class,
        );
    }

    /**
     * @api
     *
     * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
     *
     * Change a service account's role in a workspace.
     *
     * The new `workspace_role` replaces the current one. Only explicit
     * memberships can be updated; to set a role on the implicit
     * default-workspace membership, add the service account explicitly with
     * `POST /workspaces/{workspace_id}/service_accounts`. Archived workspaces
     * return 400. Archived service accounts cannot be updated and are
     * rejected.
     *
     * @param string $serviceAccountID path param: ID of the service account
     * @param array{
     *   workspaceID: string,
     *   workspaceRole: value-of<NoBillingWorkspaceRole>,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|ServiceAccountUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ServiceAccountWorkspaceMember>
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
        $workspaceID = $parsed['workspaceID'];
        unset($parsed['workspaceID']);
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/organizations/workspaces/%1$s/service_accounts/%2$s?beta=true',
                $workspaceID,
                $serviceAccountID,
            ],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                array_diff_key($parsed, array_flip(array_keys($header_params))),
                array_flip(['workspaceID']),
            ),
            options: $options,
            convert: ServiceAccountWorkspaceMember::class,
        );
    }

    /**
     * @api
     *
     * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
     *
     * List the service accounts that are members of a workspace.
     *
     * Each entry includes the service account's `workspace_role`. Use `limit`
     * and the `next_page` cursor to paginate. Archived workspaces return 400;
     * use `GET /service_accounts/{id}/workspaces` to audit memberships of an
     * archived workspace. The implicit default-workspace membership is not
     * included in this list. Memberships of archived service accounts are
     * omitted from the results.
     *
     * @param string $workspaceID path param: ID of the workspace
     * @param array{
     *   limit?: int,
     *   page?: string|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|ServiceAccountListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<ServiceAccountWorkspaceMember>>
     *
     * @throws APIException
     */
    public function list(
        string $workspaceID,
        array|ServiceAccountListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ServiceAccountListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(['limit', 'page']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: [
                'v1/organizations/workspaces/%1$s/service_accounts?beta=true',
                $workspaceID,
            ],
            query: array_intersect_key($parsed, $query_params),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: $options,
            convert: ServiceAccountWorkspaceMember::class,
            page: PageCursor::class,
        );
    }

    /**
     * @api
     *
     * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
     *
     * Add a service account to a workspace with the given `workspace_role`.
     *
     * The role determines what the service account can do in the workspace and
     * which workspace-scoped permissions it can be granted when authenticating
     * through federation. Every service account is already an implicit
     * `workspace_user` member of the default workspace; adding it explicitly
     * assigns a chosen role. If the service account is already an explicit
     * member of the workspace, its `workspace_role` is replaced with the
     * value supplied here. Archived workspaces return 400. Archived service
     * accounts cannot be added and are rejected.
     *
     * @param string $workspaceID path param: ID of the workspace
     * @param array{
     *   serviceAccountID: string,
     *   workspaceRole: value-of<NoBillingWorkspaceRole>,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|ServiceAccountAddParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ServiceAccountWorkspaceMember>
     *
     * @throws APIException
     */
    public function add(
        string $workspaceID,
        array|ServiceAccountAddParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ServiceAccountAddParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/organizations/workspaces/%1$s/service_accounts?beta=true',
                $workspaceID,
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
            convert: ServiceAccountWorkspaceMember::class,
        );
    }

    /**
     * @api
     *
     * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
     *
     * Remove a service account from a workspace.
     *
     * Removal is idempotent (returns 200 even if the membership was already
     * removed). A DELETE against the implicit default-workspace membership
     * returns 200 but is a no-op and the membership persists; deleting an
     * explicit default-workspace row reverts to the implicit `workspace_user`
     * membership. Archived workspaces return 400.
     *
     * @param string $serviceAccountID path param: ID of the service account
     * @param array{
     *   workspaceID: string,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|ServiceAccountRemoveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ServiceAccountRemoveResponse>
     *
     * @throws APIException
     */
    public function remove(
        string $serviceAccountID,
        array|ServiceAccountRemoveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ServiceAccountRemoveParams::parseRequest(
            $params,
            $requestOptions,
        );
        $workspaceID = $parsed['workspaceID'];
        unset($parsed['workspaceID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: [
                'v1/organizations/workspaces/%1$s/service_accounts/%2$s?beta=true',
                $workspaceID,
                $serviceAccountID,
            ],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: $options,
            convert: ServiceAccountRemoveResponse::class,
        );
    }
}
