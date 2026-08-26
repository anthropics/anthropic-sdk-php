<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\ServiceAccounts;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\ServiceAccounts\ServiceAccountWorkspaceMember;
use Anthropic\Beta\Organization\ServiceAccounts\Workspaces\WorkspaceAddParams;
use Anthropic\Beta\Organization\ServiceAccounts\Workspaces\WorkspaceListParams;
use Anthropic\Beta\Organization\ServiceAccounts\Workspaces\WorkspaceRemoveParams;
use Anthropic\Beta\Organization\ServiceAccounts\Workspaces\WorkspaceRemoveResponse;
use Anthropic\Beta\Organization\Workspaces\NoBillingWorkspaceRole;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\ServiceAccounts\WorkspacesRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class WorkspacesRawService implements WorkspacesRawContract
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
     * List the workspaces a service account is a member of.
     *
     * Each entry includes the service account's `workspace_role` in that
     * workspace. Use `limit` and the `next_page` cursor to paginate. When the
     * service account has no explicit default-workspace membership, the
     * implicit (`implicit: true`) membership is returned as the first entry on
     * the first page; with `limit=1` the first page may return up to 2 entries
     * (the implicit entry plus one explicit membership) so a pagination cursor
     * can be derived. Memberships are returned only while
     * the service account is active. Without a `page` cursor, an archived
     * service account returns an empty list. A `page` cursor that does not
     * match an active membership returns a 400 invalid-request error. A cursor
     * stops matching when the membership is removed, the workspace is deleted,
     * or the service account is archived. Restart pagination from the first
     * page to recover.
     *
     * @param string $serviceAccountID path param: ID of the service account
     * @param array{
     *   limit?: int,
     *   page?: string|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|WorkspaceListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<ServiceAccountWorkspaceMember>>
     *
     * @throws APIException
     */
    public function list(
        string $serviceAccountID,
        array|WorkspaceListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = WorkspaceListParams::parseRequest(
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
                'v1/organizations/service_accounts/%1$s/workspaces?beta=true',
                $serviceAccountID,
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
     * Mirror of `POST /workspaces/{workspace_id}/service_accounts`, addressed
     * from the service-account side; both create the same membership. If the
     * service account is already an explicit member of the workspace, its
     * `workspace_role` is replaced with the value supplied here. Archived
     * workspaces return 400. Archived service accounts cannot be added and are
     * rejected.
     *
     * @param string $serviceAccountID path param: ID of the service account
     * @param array{
     *   workspaceID: string,
     *   workspaceRole: value-of<NoBillingWorkspaceRole>,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|WorkspaceAddParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ServiceAccountWorkspaceMember>
     *
     * @throws APIException
     */
    public function add(
        string $serviceAccountID,
        array|WorkspaceAddParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = WorkspaceAddParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/organizations/service_accounts/%1$s/workspaces?beta=true',
                $serviceAccountID,
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
     * Mirror of `DELETE /workspaces/{workspace_id}/service_accounts/{service_account_id}`,
     * addressed from the service-account side. Removal is idempotent (returns
     * 200 even if the membership was already removed). A DELETE against the
     * implicit default-workspace membership returns 200 but is a no-op and the
     * membership persists; deleting an explicit default-workspace row reverts
     * to the implicit `workspace_user` membership. Archived workspaces return
     * 400.
     *
     * @param string $workspaceID path param: ID of the workspace
     * @param array{
     *   serviceAccountID: string,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|WorkspaceRemoveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<WorkspaceRemoveResponse>
     *
     * @throws APIException
     */
    public function remove(
        string $workspaceID,
        array|WorkspaceRemoveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = WorkspaceRemoveParams::parseRequest(
            $params,
            $requestOptions,
        );
        $serviceAccountID = $parsed['serviceAccountID'];
        unset($parsed['serviceAccountID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: [
                'v1/organizations/service_accounts/%1$s/workspaces/%2$s?beta=true',
                $serviceAccountID,
                $workspaceID,
            ],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: $options,
            convert: WorkspaceRemoveResponse::class,
        );
    }
}
