<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\Workspaces;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\ServiceAccounts\ServiceAccountWorkspaceMember;
use Anthropic\Beta\Organization\Workspaces\NoBillingWorkspaceRole;
use Anthropic\Beta\Organization\Workspaces\ServiceAccounts\ServiceAccountRemoveResponse;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\Workspaces\ServiceAccountsContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class ServiceAccountsService implements ServiceAccountsContract
{
    /**
     * @api
     */
    public ServiceAccountsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ServiceAccountsRawService($client);
    }

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
     * @param string $workspaceID path param: ID of the workspace
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $serviceAccountID,
        string $workspaceID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): ServiceAccountWorkspaceMember {
        $params = Util::removeNulls(
            ['workspaceID' => $workspaceID, 'betas' => $betas]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($serviceAccountID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
     * @param string $workspaceID path param: ID of the workspace
     * @param NoBillingWorkspaceRole|value-of<NoBillingWorkspaceRole> $workspaceRole body param: New role for the service account in this workspace
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
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
        $response = $this->raw->update($serviceAccountID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
        string $workspaceID,
        ?int $limit = null,
        ?string $page = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor {
        $params = Util::removeNulls(
            ['limit' => $limit, 'page' => $page, 'betas' => $betas]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list($workspaceID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
     * @param string $serviceAccountID body param: Tagged service account ID to add
     * @param NoBillingWorkspaceRole|value-of<NoBillingWorkspaceRole> $workspaceRole body param: Role to assign to the service account in this workspace
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function add(
        string $workspaceID,
        string $serviceAccountID,
        NoBillingWorkspaceRole|string $workspaceRole,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): ServiceAccountWorkspaceMember {
        $params = Util::removeNulls(
            [
                'serviceAccountID' => $serviceAccountID,
                'workspaceRole' => $workspaceRole,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->add($workspaceID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
     * @param string $workspaceID path param: ID of the workspace
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function remove(
        string $serviceAccountID,
        string $workspaceID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): ServiceAccountRemoveResponse {
        $params = Util::removeNulls(
            ['workspaceID' => $workspaceID, 'betas' => $betas]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->remove($serviceAccountID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
