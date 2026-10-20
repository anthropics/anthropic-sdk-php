<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts;

use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\UserProfiles\DeletedUserProfile;
use Anthropic\UserProfiles\UserProfile;
use Anthropic\UserProfiles\UserProfileCreateParams;
use Anthropic\UserProfiles\UserProfileDeleteParams;
use Anthropic\UserProfiles\UserProfileListParams;
use Anthropic\UserProfiles\UserProfileRetrieveParams;
use Anthropic\UserProfiles\UserProfileUpdateParams;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface UserProfilesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|UserProfileCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserProfile>
     *
     * @throws APIException
     */
    public function create(
        array|UserProfileCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $userProfileID The ID of the user profile to get (`uprof_...`).
     * @param array<string,mixed>|UserProfileRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserProfile>
     *
     * @throws APIException
     */
    public function retrieve(
        string $userProfileID,
        array|UserProfileRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $userProfileID Path param: The ID of the user profile to update (`uprof_...`).
     * @param array<string,mixed>|UserProfileUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserProfile>
     *
     * @throws APIException
     */
    public function update(
        string $userProfileID,
        array|UserProfileUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|UserProfileListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<UserProfile>>
     *
     * @throws APIException
     */
    public function list(
        array|UserProfileListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $userProfileID The ID of the user profile to delete (`uprof_...`).
     * @param array<string,mixed>|UserProfileDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<DeletedUserProfile>
     *
     * @throws APIException
     */
    public function delete(
        string $userProfileID,
        array|UserProfileDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
