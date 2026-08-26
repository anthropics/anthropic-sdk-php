<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\Workspaces;

use Anthropic\Beta\Organization\Workspaces\Members\MemberRemoveResponse;
use Anthropic\Beta\Organization\Workspaces\NoBillingWorkspaceRole;
use Anthropic\Beta\Organization\Workspaces\WorkspaceMember;
use Anthropic\Beta\Organization\Workspaces\WorkspaceRole;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Page;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface MembersContract
{
    /**
     * @api
     *
     * @param string $userID ID of the User
     * @param string $workspaceID ID of the Workspace
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $userID,
        string $workspaceID,
        RequestOptions|array|null $requestOptions = null,
    ): WorkspaceMember;

    /**
     * @api
     *
     * @param string $userID path param: ID of the User
     * @param string $workspaceID path param: ID of the Workspace
     * @param WorkspaceRole|value-of<WorkspaceRole> $workspaceRole body param: New workspace role for the User
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $userID,
        string $workspaceID,
        WorkspaceRole|string $workspaceRole,
        RequestOptions|array|null $requestOptions = null,
    ): WorkspaceMember;

    /**
     * @api
     *
     * @param string $workspaceID ID of the Workspace
     * @param string $afterID ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately after this object.
     * @param string $beforeID ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately before this object.
     * @param int $limit Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     * @param RequestOpts|null $requestOptions
     *
     * @return Page<WorkspaceMember>
     *
     * @throws APIException
     */
    public function list(
        string $workspaceID,
        ?string $afterID = null,
        ?string $beforeID = null,
        ?int $limit = null,
        RequestOptions|array|null $requestOptions = null,
    ): Page;

    /**
     * @api
     *
     * @param string $workspaceID ID of the Workspace
     * @param string $userID ID of the User
     * @param NoBillingWorkspaceRole|value-of<NoBillingWorkspaceRole> $workspaceRole Role of the new Workspace Member. Cannot be `workspace_billing`.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function add(
        string $workspaceID,
        string $userID,
        NoBillingWorkspaceRole|string $workspaceRole,
        RequestOptions|array|null $requestOptions = null,
    ): WorkspaceMember;

    /**
     * @api
     *
     * @param string $userID ID of the User
     * @param string $workspaceID ID of the Workspace
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function remove(
        string $userID,
        string $workspaceID,
        RequestOptions|array|null $requestOptions = null,
    ): MemberRemoveResponse;
}
