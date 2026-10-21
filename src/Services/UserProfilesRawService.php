<?php

declare(strict_types=1);

namespace Anthropic\Services;

use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Implementation\ApiCallInfo;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\UserProfilesRawContract;
use Anthropic\UserProfiles\DeletedUserProfile;
use Anthropic\UserProfiles\UserProfile;
use Anthropic\UserProfiles\UserProfileAccessType;
use Anthropic\UserProfiles\UserProfileCreateParams;
use Anthropic\UserProfiles\UserProfileDeleteParams;
use Anthropic\UserProfiles\UserProfileEnforcementStatus;
use Anthropic\UserProfiles\UserProfileExternalUserDetailsParams;
use Anthropic\UserProfiles\UserProfileListOrder;
use Anthropic\UserProfiles\UserProfileListOrderBy;
use Anthropic\UserProfiles\UserProfileListParams;
use Anthropic\UserProfiles\UserProfileRetrieveParams;
use Anthropic\UserProfiles\UserProfileUpdateParams;

/**
 * @phpstan-import-type UserProfileExternalUserDetailsParamsShape from \Anthropic\UserProfiles\UserProfileExternalUserDetailsParams
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class UserProfilesRawService implements UserProfilesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create User Profile
     *
     * @param array{
     *   accessType?: UserProfileAccessType|value-of<UserProfileAccessType>,
     *   externalUserDetails?: UserProfileExternalUserDetailsParams|UserProfileExternalUserDetailsParamsShape,
     *   metadata?: array<string,string>,
     *   name?: string|null,
     *   workspaceID?: string,
     * }|UserProfileCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserProfile>
     *
     * @throws APIException
     */
    public function create(
        array|UserProfileCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = UserProfileCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['workspaceID' => 'anthropic-workspace-id'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/user_profiles',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options->withApiCall(new ApiCallInfo(
                name: 'anthropic.user_profiles.create',
                route: '/v1/user_profiles',
                createdId: 'anthropic.user_profile.id',
            )),
            convert: UserProfile::class,
        );
    }

    /**
     * @api
     *
     * Get User Profile
     *
     * @param string $userProfileID The ID of the user profile to get (`uprof_...`).
     * @param array{workspaceID?: string}|UserProfileRetrieveParams $params
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
    ): BaseResponse {
        [$parsed, $options] = UserProfileRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/user_profiles/%1$s', $userProfileID],
            headers: Util::array_transform_keys(
                $parsed,
                ['workspaceID' => 'anthropic-workspace-id']
            ),
            options: $options->withApiCall(new ApiCallInfo(
                name: 'anthropic.user_profiles.retrieve',
                route: '/v1/user_profiles/{user_profile_id}',
                attributes: ['anthropic.user_profile.id' => $userProfileID],
            )),
            convert: UserProfile::class,
        );
    }

    /**
     * @api
     *
     * Update User Profile
     *
     * @param string $userProfileID Path param: The ID of the user profile to update (`uprof_...`).
     * @param array{
     *   accessType?: UserProfileAccessType|value-of<UserProfileAccessType>|null,
     *   externalUserDetails?: UserProfileExternalUserDetailsParams|UserProfileExternalUserDetailsParamsShape,
     *   metadata?: array<string,string>,
     *   name?: string|null,
     *   workspaceID?: string,
     * }|UserProfileUpdateParams $params
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
    ): BaseResponse {
        [$parsed, $options] = UserProfileUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['workspaceID' => 'anthropic-workspace-id'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/user_profiles/%1$s', $userProfileID],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options->withApiCall(new ApiCallInfo(
                name: 'anthropic.user_profiles.update',
                route: '/v1/user_profiles/{user_profile_id}',
                attributes: ['anthropic.user_profile.id' => $userProfileID],
            )),
            convert: UserProfile::class,
        );
    }

    /**
     * @api
     *
     * List User Profiles
     *
     * @param array{
     *   enforcementStatus?: list<UserProfileEnforcementStatus|value-of<UserProfileEnforcementStatus>>,
     *   limit?: int,
     *   order?: UserProfileListOrder|value-of<UserProfileListOrder>,
     *   orderBy?: UserProfileListOrderBy|value-of<UserProfileListOrderBy>,
     *   page?: string,
     *   workspaceID?: string,
     * }|UserProfileListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<UserProfile>>
     *
     * @throws APIException
     */
    public function list(
        array|UserProfileListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = UserProfileListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(
            ['enforcementStatus', 'limit', 'order', 'orderBy', 'page']
        );

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/user_profiles',
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                ['enforcementStatus' => 'enforcement_status', 'orderBy' => 'order_by'],
            ),
            headers: Util::array_transform_keys(
                $header_params,
                ['workspaceID' => 'anthropic-workspace-id']
            ),
            options: $options->withApiCall(new ApiCallInfo(
                name: 'anthropic.user_profiles.list',
                route: '/v1/user_profiles',
                query: ['enforcement_status', 'limit', 'order', 'order_by', 'page'],
            )),
            convert: UserProfile::class,
            page: PageCursor::class,
        );
    }

    /**
     * @api
     *
     * Delete User Profile
     *
     * @param string $userProfileID The ID of the user profile to delete (`uprof_...`).
     * @param array{workspaceID?: string}|UserProfileDeleteParams $params
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
    ): BaseResponse {
        [$parsed, $options] = UserProfileDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/user_profiles/%1$s', $userProfileID],
            headers: Util::array_transform_keys(
                $parsed,
                ['workspaceID' => 'anthropic-workspace-id']
            ),
            options: $options->withApiCall(new ApiCallInfo(
                name: 'anthropic.user_profiles.delete',
                route: '/v1/user_profiles/{user_profile_id}',
                attributes: ['anthropic.user_profile.id' => $userProfileID],
            )),
            convert: DeletedUserProfile::class,
        );
    }
}
