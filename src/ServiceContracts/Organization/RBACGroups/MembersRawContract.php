<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Organization\RBACGroups;

use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Organization\RBACGroups\Members\DeletedRBACGroupMember;
use Anthropic\Organization\RBACGroups\Members\MemberAddParams;
use Anthropic\Organization\RBACGroups\Members\MemberListParams;
use Anthropic\Organization\RBACGroups\Members\MemberRemoveParams;
use Anthropic\Organization\RBACGroups\Members\RBACGroupMember;
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
     * @return BaseResponse<PageCursor<RBACGroupMember>>
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
     * @return BaseResponse<RBACGroupMember>
     *
     * @throws RBACGroupGrantsOwnerAccessException
     * @throws RBACGroupOwnerAccessUnconfirmedException
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
     * @return BaseResponse<DeletedRBACGroupMember>
     *
     * @throws RBACGroupGrantsOwnerAccessException
     * @throws RBACGroupOwnerAccessUnconfirmedException
     * @throws APIException
     */
    public function remove(
        string $userID,
        array|MemberRemoveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
