<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\RBACGroups;

use Anthropic\Beta\Organization\RBACGroups\Members\BetaRBACGroupMember;
use Anthropic\Beta\Organization\RBACGroups\Members\MemberAddParams;
use Anthropic\Beta\Organization\RBACGroups\Members\MemberListParams;
use Anthropic\Beta\Organization\RBACGroups\Members\MemberRemoveParams;
use Anthropic\Beta\Organization\RBACGroups\Members\MemberRemoveResponse;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
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
     * @param string $rbacGroupID ID of the RBAC Group
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
     * @param string $rbacGroupID ID of the RBAC Group
     * @param array<string,mixed>|MemberAddParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaRBACGroupMember>
     *
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
     * @param string $userID ID of the User
     * @param array<string,mixed>|MemberRemoveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<MemberRemoveResponse>
     *
     * @throws APIException
     */
    public function remove(
        string $userID,
        array|MemberRemoveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
