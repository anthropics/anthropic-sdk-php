<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\RBACGroups;

use Anthropic\Beta\Organization\RBACGroups\Members\BetaDeletedRBACGroupMember;
use Anthropic\Beta\Organization\RBACGroups\Members\BetaRBACGroupMember;
use Anthropic\Beta\Organization\RBACGroups\Members\MemberAddParams;
use Anthropic\Beta\Organization\RBACGroups\Members\MemberListParams;
use Anthropic\Beta\Organization\RBACGroups\Members\MemberRemoveParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Organization\RBACGroups\RBACGroupGrantsOwnerAccessException;
use Anthropic\Organization\RBACGroups\RBACGroupOwnerAccessUnconfirmedException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface MembersRawContract
{
    /**
     * @api
     *
     * @param string $rbacGroupID ID of the RBAC Group.
     * @param array<string,mixed>|MemberListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaRBACGroupMember>>
     *
     * @throws APIException
     */
    public function list(
        string $rbacGroupID,
        array|MemberListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $rbacGroupID ID of the RBAC Group.
     * @param array<string,mixed>|MemberAddParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaRBACGroupMember>
     *
     * @throws RBACGroupGrantsOwnerAccessException A role attached to an RBAC Group in the request grants owner access, so this API does not add members to that group (directly or through an invite), remove its members, or delete it. Make the change in the organization's admin settings in Claude.
     * @throws RBACGroupOwnerAccessUnconfirmedException The API could not finish checking whether an RBAC Group in the request grants owner access, so it made no change. Retrying the same request will not help. Make the change in the organization's admin settings in Claude.
     * @throws APIException
     */
    public function add(
        string $rbacGroupID,
        array|MemberAddParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $userID ID of the User.
     * @param array<string,mixed>|MemberRemoveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaDeletedRBACGroupMember>
     *
     * @throws RBACGroupGrantsOwnerAccessException A role attached to an RBAC Group in the request grants owner access, so this API does not add members to that group (directly or through an invite), remove its members, or delete it. Make the change in the organization's admin settings in Claude.
     * @throws RBACGroupOwnerAccessUnconfirmedException The API could not finish checking whether an RBAC Group in the request grants owner access, so it made no change. Retrying the same request will not help. Make the change in the organization's admin settings in Claude.
     * @throws APIException
     */
    public function remove(
        string $userID,
        array|MemberRemoveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
