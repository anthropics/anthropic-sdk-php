<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\UserProfiles\Providers\Google;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedDataControls;
use Anthropic\Beta\UserProfiles\Providers\Google\DataControls\DataControlRetrieveParams;
use Anthropic\Beta\UserProfiles\Providers\Google\DataControls\DataControlUpdateParams;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Implementation\ApiCallInfo;
use Anthropic\Core\Util;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\UserProfiles\Providers\Google\DataControlsRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 * @phpstan-import-type BetaGoogleManagedCMEKControlParamsShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedCMEKControlParams
 * @phpstan-import-type BetaGoogleManagedStorageControlParamsShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedStorageControlParams
 */
final class DataControlsRawService implements DataControlsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Get the profile's encryption keys and storage buckets for Claude on Google Cloud's Agent Platform, with each region's status.
     *
     * @param string $userProfileID The ID of the user profile whose Google-managed data controls to retrieve (`uprof_...`).
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     *   workspaceID?: string,
     * }|DataControlRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaGoogleManagedDataControls>
     *
     * @throws APIException
     */
    public function retrieve(
        string $userProfileID,
        array|DataControlRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = DataControlRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: [
                'v1/user_profiles/%1$s/providers/google/data_controls', $userProfileID,
            ],
            headers: Util::array_transform_keys(
                $parsed,
                [
                    'betas' => 'anthropic-beta', 'workspaceID' => 'anthropic-workspace-id',
                ],
            ),
            options: RequestOptions::parse(
                [
                    'extraHeaders' => [
                        'anthropic-beta' => 'user-profiles-2026-09-04,google-managed-data-controls-2026-09-01',
                    ],
                ],
                $options,
            )->withQualifiers(['beta' => 'true'])->withApiCall(new ApiCallInfo(
                name: 'anthropic.user_profiles.providers.google.data_controls.retrieve',
                route: '/v1/user_profiles/{user_profile_id}/providers/google/data_controls',
                attributes: ['anthropic.user_profile.id' => $userProfileID],
            )),
            convert: BetaGoogleManagedDataControls::class,
        );
    }

    /**
     * @api
     *
     * Turn a control on or off, or change the key or bucket set for a region. Controls and regions that you leave out stay as they are.
     *
     * @param string $userProfileID Path param: The ID of the user profile whose Google-managed data controls to update (`uprof_...`).
     * @param array{
     *   cmek?: BetaGoogleManagedCMEKControlParamsShape,
     *   storage?: BetaGoogleManagedStorageControlParamsShape,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     *   workspaceID?: string,
     * }|DataControlUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaGoogleManagedDataControls>
     *
     * @throws APIException
     */
    public function update(
        string $userProfileID,
        array|DataControlUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = DataControlUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = [
            'betas' => 'anthropic-beta', 'workspaceID' => 'anthropic-workspace-id',
        ];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/user_profiles/%1$s/providers/google/data_controls', $userProfileID,
            ],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: RequestOptions::parse(
                [
                    'extraHeaders' => [
                        'anthropic-beta' => 'user-profiles-2026-09-04,google-managed-data-controls-2026-09-01',
                    ],
                ],
                $options,
            )->withQualifiers(['beta' => 'true'])->withApiCall(new ApiCallInfo(
                name: 'anthropic.user_profiles.providers.google.data_controls.update',
                route: '/v1/user_profiles/{user_profile_id}/providers/google/data_controls',
                attributes: ['anthropic.user_profile.id' => $userProfileID],
            )),
            convert: BetaGoogleManagedDataControls::class,
        );
    }
}
