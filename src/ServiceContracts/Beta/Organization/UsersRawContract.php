<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization;

use Anthropic\Beta\BetaOrganizationNotEnrolledInBetaException;
use Anthropic\Beta\Organization\Users\CannotSignOutManagedMemberException;
use Anthropic\Beta\Organization\Users\CannotSignOutMembershipAdminException;
use Anthropic\Beta\Organization\Users\CannotSignOutOwnerException;
use Anthropic\Beta\Organization\Users\CannotSignOutPrimaryOwnerException;
use Anthropic\Beta\Organization\Users\CannotSignOutPrivilegedMemberException;
use Anthropic\Beta\Organization\Users\CannotSignOutSelfException;
use Anthropic\Beta\Organization\Users\OrganizationUser;
use Anthropic\Beta\Organization\Users\UserListParams;
use Anthropic\Beta\Organization\Users\UserRemoveResponse;
use Anthropic\Beta\Organization\Users\UserSignOutParams;
use Anthropic\Beta\Organization\Users\UserUpdateParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Organization\ConcurrentMembershipChangeException;
use Anthropic\Organization\Users\CannotRemoveLastMemberException;
use Anthropic\Page;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface UsersRawContract
{
    /**
     * @api
     *
     * @param string $userID ID of the User.
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<OrganizationUser>
     *
     * @throws APIException
     */
    public function retrieve(
        string $userID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $userID ID of the User.
     * @param array<string,mixed>|UserUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<OrganizationUser>
     *
     * @throws APIException
     */
    public function update(
        string $userID,
        array|UserUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|UserListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Page<OrganizationUser>>
     *
     * @throws APIException
     */
    public function list(
        array|UserListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $userID ID of the User.
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserRemoveResponse>
     *
     * @throws CannotRemoveLastMemberException
     * @throws ConcurrentMembershipChangeException
     * @throws APIException
     */
    public function remove(
        string $userID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $userID ID of the User.
     * @param array<string,mixed>|UserSignOutParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<OrganizationUser>
     *
     * @throws CannotSignOutPrimaryOwnerException
     * @throws CannotSignOutSelfException
     * @throws BetaOrganizationNotEnrolledInBetaException
     * @throws CannotSignOutManagedMemberException
     * @throws CannotSignOutMembershipAdminException
     * @throws CannotSignOutOwnerException
     * @throws CannotSignOutPrivilegedMemberException
     * @throws APIException
     */
    public function signOut(
        string $userID,
        array|UserSignOutParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
