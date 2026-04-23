<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\UserProfiles\BetaUserProfile;
use Anthropic\Beta\UserProfiles\BetaUserProfileEnrollmentURL;
use Anthropic\Beta\UserProfiles\UserProfileCreateEnrollmentURLParams;
use Anthropic\Beta\UserProfiles\UserProfileCreateParams;
use Anthropic\Beta\UserProfiles\UserProfileListParams;
use Anthropic\Beta\UserProfiles\UserProfileListParams\Order;
use Anthropic\Beta\UserProfiles\UserProfileRetrieveParams;
use Anthropic\Beta\UserProfiles\UserProfileUpdateParams;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\UserProfilesRawContract;

/**
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
     *   externalID?: string|null,
     *   metadata?: array<string,string>,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|UserProfileCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaUserProfile>
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
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/user_profiles?beta=true',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'user-profiles-2026-03-24']],
                $options,
            ),
            convert: BetaUserProfile::class,
        );
    }

    /**
     * @api
     *
     * Get User Profile
     *
     * @param string $userProfileID Path parameter user_profile_id
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|UserProfileRetrieveParams $params
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
    ): BaseResponse {
        [$parsed, $options] = UserProfileRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/user_profiles/%1$s?beta=true', $userProfileID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'user-profiles-2026-03-24']],
                $options,
            ),
            convert: BetaUserProfile::class,
        );
    }

    /**
     * @api
     *
     * Update User Profile
     *
     * @param string $userProfileID Path param: Path parameter user_profile_id
     * @param array{
     *   externalID?: string|null,
     *   metadata?: array<string,string>,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|UserProfileUpdateParams $params
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
    ): BaseResponse {
        [$parsed, $options] = UserProfileUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/user_profiles/%1$s?beta=true', $userProfileID],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'user-profiles-2026-03-24']],
                $options,
            ),
            convert: BetaUserProfile::class,
        );
    }

    /**
     * @api
     *
     * List User Profiles
     *
     * @param array{
     *   limit?: int,
     *   order?: Order|value-of<Order>,
     *   page?: string,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|UserProfileListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaUserProfile>>
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
        $query_params = array_flip(['limit', 'order', 'page']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/user_profiles?beta=true',
            query: array_intersect_key($parsed, $query_params),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'user-profiles-2026-03-24']],
                $options,
            ),
            convert: BetaUserProfile::class,
            page: PageCursor::class,
        );
    }

    /**
     * @api
     *
     * Create Enrollment URL
     *
     * @param string $userProfileID Path parameter user_profile_id
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|UserProfileCreateEnrollmentURLParams $params
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
    ): BaseResponse {
        [$parsed, $options] = UserProfileCreateEnrollmentURLParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/user_profiles/%1$s/enrollment_url?beta=true', $userProfileID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'user-profiles-2026-03-24']],
                $options,
            ),
            convert: BetaUserProfileEnrollmentURL::class,
        );
    }
}
