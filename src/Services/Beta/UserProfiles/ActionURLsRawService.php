<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\UserProfiles;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\UserProfiles\ActionURLs\ActionURLCreateParams;
use Anthropic\Beta\UserProfiles\ActionURLs\UserProfileActionURL;
use Anthropic\Beta\UserProfiles\ActionURLs\UserProfileEnrollEndUserAction;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Implementation\ApiCallInfo;
use Anthropic\Core\Util;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\UserProfiles\ActionURLsRawContract;

/**
 * @phpstan-import-type UserProfileEnrollEndUserActionShape from \Anthropic\Beta\UserProfiles\ActionURLs\UserProfileEnrollEndUserAction
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class ActionURLsRawService implements ActionURLsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create Action URL
     *
     * @param string $userProfileID Path param: The ID of the user profile the action is for (`uprof_...`).
     * @param array{
     *   action: UserProfileEnrollEndUserAction|UserProfileEnrollEndUserActionShape,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     *   workspaceID?: string,
     * }|ActionURLCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserProfileActionURL>
     *
     * @throws APIException
     */
    public function create(
        string $userProfileID,
        array|ActionURLCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ActionURLCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = [
            'betas' => 'anthropic-beta', 'workspaceID' => 'anthropic-workspace-id',
        ];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/user_profiles/%1$s/action_urls', $userProfileID],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'user-profiles-2026-08-18']],
                $options,
            )->withQualifiers(['beta' => 'true'])->withApiCall(new ApiCallInfo(
                name: 'anthropic.user_profiles.action_urls.create',
                route: '/v1/user_profiles/{user_profile_id}/action_urls',
                attributes: ['anthropic.user_profile.id' => $userProfileID],
            )),
            convert: UserProfileActionURL::class,
        );
    }
}
