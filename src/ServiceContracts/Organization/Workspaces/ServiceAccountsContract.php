<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Organization\Workspaces;

use Anthropic\Core\Exceptions\APIException;
use Anthropic\Organization\ServiceAccounts\ServiceAccountWorkspaceMember;
use Anthropic\Organization\Workspaces\NoBillingWorkspaceRole;
use Anthropic\Organization\Workspaces\ServiceAccounts\ServiceAccountRemoveResponse;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface ServiceAccountsContract
{
    /**
     * @api
     *
     * @param string $serviceAccountID ID of the service account
     * @param string $workspaceID ID of the workspace
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $serviceAccountID,
        string $workspaceID,
        RequestOptions|array|null $requestOptions = null,
    ): ServiceAccountWorkspaceMember;

    /**
     * @api
     *
     * @param string $serviceAccountID path param: ID of the service account
     * @param string $workspaceID path param: ID of the workspace
     * @param NoBillingWorkspaceRole|value-of<NoBillingWorkspaceRole> $workspaceRole body param: New role for the service account in this workspace
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $serviceAccountID,
        string $workspaceID,
        NoBillingWorkspaceRole|string $workspaceRole,
        RequestOptions|array|null $requestOptions = null,
    ): ServiceAccountWorkspaceMember;

    /**
     * @api
     *
     * @param string $workspaceID ID of the workspace
     * @param int $limit number of results per page
     * @param string|null $page opaque cursor from a previous response's `next_page`
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
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;

    /**
     * @api
     *
     * @param string $workspaceID ID of the workspace
     * @param string $serviceAccountID tagged service account ID to add
     * @param NoBillingWorkspaceRole|value-of<NoBillingWorkspaceRole> $workspaceRole role to assign to the service account in this workspace
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function add(
        string $workspaceID,
        string $serviceAccountID,
        NoBillingWorkspaceRole|string $workspaceRole,
        RequestOptions|array|null $requestOptions = null,
    ): ServiceAccountWorkspaceMember;

    /**
     * @api
     *
     * @param string $serviceAccountID ID of the service account
     * @param string $workspaceID ID of the workspace
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function remove(
        string $serviceAccountID,
        string $workspaceID,
        RequestOptions|array|null $requestOptions = null,
    ): ServiceAccountRemoveResponse;
}
