<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\RBACGroups;

use Anthropic\Beta\Organization\RBACGroups\Members\BetaDeletedRBACGroupMember;
use Anthropic\Beta\Organization\RBACGroups\Members\BetaRBACGroupMember;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Organization\RBACGroups\RBACGroupGrantsOwnerAccessException;
use Anthropic\Organization\RBACGroups\RBACGroupOwnerAccessUnconfirmedException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface MembersContract
{
    /**
     * @api
     *
     * @param string $rbacGroupID ID of the RBAC Group.
     * @param int $limit Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     * @param string|null $page Optionally set to the `next_page` token from the previous response.
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<BetaRBACGroupMember>
     *
     * @throws APIException
     */
    public function list(
        string $rbacGroupID,
        ?int $limit = null,
        ?string $page = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;

    /**
     * @api
     *
     * @param string $rbacGroupID ID of the RBAC Group.
     * @param string $userID ID of the User.
     * @param RequestOpts|null $requestOptions
     *
     * @throws RBACGroupGrantsOwnerAccessException A role attached to an RBAC Group in the request grants owner access, so this API does not add members to that group (directly or through an invite), remove its members, or delete it. Make the change in the organization's admin settings in Claude.
     * @throws RBACGroupOwnerAccessUnconfirmedException The API could not finish checking whether an RBAC Group in the request grants owner access, so it made no change. Retrying the same request will not help. Make the change in the organization's admin settings in Claude.
     * @throws APIException
     */
    public function add(
        string $rbacGroupID,
        string $userID,
        RequestOptions|array|null $requestOptions = null,
    ): BetaRBACGroupMember;

    /**
     * @api
     *
     * @param string $userID ID of the User.
     * @param string $rbacGroupID ID of the RBAC Group.
     * @param RequestOpts|null $requestOptions
     *
     * @throws RBACGroupGrantsOwnerAccessException A role attached to an RBAC Group in the request grants owner access, so this API does not add members to that group (directly or through an invite), remove its members, or delete it. Make the change in the organization's admin settings in Claude.
     * @throws RBACGroupOwnerAccessUnconfirmedException The API could not finish checking whether an RBAC Group in the request grants owner access, so it made no change. Retrying the same request will not help. Make the change in the organization's admin settings in Claude.
     * @throws APIException
     */
    public function remove(
        string $userID,
        string $rbacGroupID,
        RequestOptions|array|null $requestOptions = null,
    ): BetaDeletedRBACGroupMember;
}
