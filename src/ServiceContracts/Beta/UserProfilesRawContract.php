<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta;

use Anthropic\Beta\UserProfiles\BetaUserProfile;
use Anthropic\Beta\UserProfiles\BetaUserProfileEnrollmentURL;
use Anthropic\Beta\UserProfiles\UserProfileCreateEnrollmentURLParams;
use Anthropic\Beta\UserProfiles\UserProfileCreateParams;
use Anthropic\Beta\UserProfiles\UserProfileListParams;
use Anthropic\Beta\UserProfiles\UserProfileRetrieveParams;
use Anthropic\Beta\UserProfiles\UserProfileUpdateParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

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
     * @return BaseResponse<BetaUserProfile>
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
     * @param string $userProfileID Path parameter user_profile_id
     * @param array<string,mixed>|UserProfileRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaUserProfile>
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
     * @param string $userProfileID Path param: Path parameter user_profile_id
     * @param array<string,mixed>|UserProfileUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaUserProfile>
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
     * @return BaseResponse<PageCursor<BetaUserProfile>>
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
     * @param string $userProfileID Path parameter user_profile_id
     * @param array<string,mixed>|UserProfileCreateEnrollmentURLParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaUserProfileEnrollmentURL>
     *
     * @throws APIException
     */
    public function createEnrollmentURL(
        string $userProfileID,
        array|UserProfileCreateEnrollmentURLParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
