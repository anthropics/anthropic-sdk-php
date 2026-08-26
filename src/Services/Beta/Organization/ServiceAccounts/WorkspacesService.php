<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\ServiceAccounts;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\ServiceAccounts\ServiceAccountWorkspaceMember;
use Anthropic\Beta\Organization\ServiceAccounts\Workspaces\WorkspaceRemoveResponse;
use Anthropic\Beta\Organization\Workspaces\NoBillingWorkspaceRole;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\ServiceAccounts\WorkspacesContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class WorkspacesService implements WorkspacesContract
{
    /**
     * @api
     */
    public WorkspacesRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new WorkspacesRawService($client);
    }

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
     * @param int $limit query param: Number of results per page
     * @param string|null $page query param: Opaque cursor from a previous response's `next_page`
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<ServiceAccountWorkspaceMember>
     *
     * @throws APIException
     */
    public function list(
        string $serviceAccountID,
        ?int $limit = null,
        ?string $page = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor {
        $params = Util::removeNulls(
            ['limit' => $limit, 'page' => $page, 'betas' => $betas]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list($serviceAccountID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
     * @param string $workspaceID body param: Tagged workspace ID to add the service account to
     * @param NoBillingWorkspaceRole|value-of<NoBillingWorkspaceRole> $workspaceRole body param: Role to assign to the service account in this workspace
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function add(
        string $serviceAccountID,
        string $workspaceID,
        NoBillingWorkspaceRole|string $workspaceRole,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): ServiceAccountWorkspaceMember {
        $params = Util::removeNulls(
            [
                'workspaceID' => $workspaceID,
                'workspaceRole' => $workspaceRole,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->add($serviceAccountID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
     * @param string $serviceAccountID path param: ID of the service account
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function remove(
        string $workspaceID,
        string $serviceAccountID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): WorkspaceRemoveResponse {
        $params = Util::removeNulls(
            ['serviceAccountID' => $serviceAccountID, 'betas' => $betas]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->remove($workspaceID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
