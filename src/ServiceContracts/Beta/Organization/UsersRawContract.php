<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization;

use Anthropic\Beta\Organization\Users\OrganizationUser;
use Anthropic\Beta\Organization\Users\UserListParams;
use Anthropic\Beta\Organization\Users\UserRemoveResponse;
use Anthropic\Beta\Organization\Users\UserUpdateParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
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
     * @param string $userID ID of the User
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
     * @param string $userID ID of the User
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
     * @param string $userID ID of the User
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserRemoveResponse>
     *
     * @throws APIException
     */
    public function remove(
        string $userID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;
}
