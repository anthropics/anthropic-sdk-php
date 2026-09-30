<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Organization\ServiceAccounts;

use Anthropic\Core\Exceptions\APIException;
use Anthropic\Organization\ServiceAccounts\ServiceAccountWorkspaceMember;
use Anthropic\Organization\ServiceAccounts\Workspaces\WorkspaceRemoveResponse;
use Anthropic\Organization\Workspaces\NoBillingWorkspaceRole;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface WorkspacesContract
{
    /**
     * @api
     *
     * @param string $serviceAccountID ID of the service account
     * @param int $limit number of results per page
     * @param string|null $page opaque cursor from a previous response's `next_page`
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
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;

    /**
     * @api
     *
     * @param string $serviceAccountID ID of the service account
     * @param string $workspaceID tagged workspace ID to add the service account to
     * @param NoBillingWorkspaceRole|value-of<NoBillingWorkspaceRole> $workspaceRole role to assign to the service account in this workspace
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function add(
        string $serviceAccountID,
        string $workspaceID,
        NoBillingWorkspaceRole|string $workspaceRole,
        RequestOptions|array|null $requestOptions = null,
    ): ServiceAccountWorkspaceMember;

    /**
     * @api
     *
     * @param string $workspaceID ID of the workspace
     * @param string $serviceAccountID ID of the service account
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function remove(
        string $workspaceID,
        string $serviceAccountID,
        RequestOptions|array|null $requestOptions = null,
    ): WorkspaceRemoveResponse;
}
