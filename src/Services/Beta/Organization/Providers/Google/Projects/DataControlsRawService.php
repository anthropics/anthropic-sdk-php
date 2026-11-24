<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\Providers\Google\Projects;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\BetaCMEKNotApprovedException;
use Anthropic\Beta\BetaExternalKeyNotFoundException;
use Anthropic\Beta\BetaExternalKeyProviderMismatchException;
use Anthropic\Beta\BetaGCPProjectControlledByAnotherOrganizationException;
use Anthropic\Beta\BetaGCPProjectNotVerifiedException;
use Anthropic\Beta\BetaRegionNotSupportedException;
use Anthropic\Beta\BetaStorageInUseException;
use Anthropic\Beta\BetaStorageNotApprovedException;
use Anthropic\Beta\Organization\BetaAuthorizationCheckUnavailableException;
use Anthropic\Beta\Organization\BetaOrganizationNotEligibleException;
use Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectDataControls;
use Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\DataControlRetrieveParams;
use Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\DataControlUpdateParams;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Implementation\ApiCallInfo;
use Anthropic\Core\Util;
use Anthropic\Organization\Workspaces\KeyProfileMismatchException;
use Anthropic\RequestOptions;
use Anthropic\SandboxEgressRestrictedException;
use Anthropic\ServiceContracts\Beta\Organization\Providers\Google\Projects\DataControlsRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 * @phpstan-import-type BetaGoogleManagedProjectCMEKControlParamsShape from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectCMEKControlParams
 * @phpstan-import-type BetaGoogleManagedProjectStorageControlParamsShape from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectStorageControlParams
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
     * Get a Google Cloud project's encryption keys and storage buckets for Claude on Google Cloud's Agent Platform, with each region's status.
     *
     * Your organization must have proved that it owns the project.
     *
     * @param string $projectNumber The Google Cloud project's number, such as `123456789012`, not its project ID.
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|DataControlRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaGoogleManagedProjectDataControls>
     *
     * @throws APIException
     */
    public function retrieve(
        string $projectNumber,
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
                'v1/organizations/providers/google/projects/%1$s/data_controls',
                $projectNumber,
            ],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                [
                    'extraHeaders' => [
                        'anthropic-beta' => 'google-managed-data-controls-2026-09-01',
                    ],
                ],
                $options,
            )->withQualifiers(['beta' => 'true'])->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.providers.google.projects.data_controls.retrieve',
                route: '/v1/organizations/providers/google/projects/{project_number}/data_controls',
                attributes: [
                    'anthropic.organization.provider.google.project.id' => $projectNumber,
                ],
            )),
            convert: BetaGoogleManagedProjectDataControls::class,
        );
    }

    /**
     * @api
     *
     * Turn a control on or off, or change the key or bucket set for a region. Controls and regions that you leave out stay as they are.
     *
     * Your organization must have proved that it owns the project. Only one organization at a time can have controls turned on for a project.
     *
     * **Requires a credential that identifies a user or a service account**: an OAuth access token with the `org:admin` scope, or an organization-scoped API key that belongs to a user or service account whose organization role can update these controls. The `admin`, `owner` and `primary_owner` roles can. An Admin API key gets a `403` error.
     *
     * @param string $projectNumber Path param: The Google Cloud project's number, such as `123456789012`, not its project ID.
     * @param array{
     *   cmek?: BetaGoogleManagedProjectCMEKControlParamsShape,
     *   storage?: BetaGoogleManagedProjectStorageControlParamsShape,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|DataControlUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaGoogleManagedProjectDataControls>
     *
     * @throws BetaCMEKNotApprovedException
     * @throws BetaExternalKeyNotFoundException
     * @throws BetaExternalKeyProviderMismatchException
     * @throws BetaGCPProjectNotVerifiedException
     * @throws KeyProfileMismatchException
     * @throws BetaOrganizationNotEligibleException
     * @throws BetaRegionNotSupportedException
     * @throws BetaStorageNotApprovedException
     * @throws SandboxEgressRestrictedException
     * @throws BetaGCPProjectControlledByAnotherOrganizationException
     * @throws BetaStorageInUseException
     * @throws BetaAuthorizationCheckUnavailableException
     * @throws APIException
     */
    public function update(
        string $projectNumber,
        array|DataControlUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = DataControlUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/organizations/providers/google/projects/%1$s/data_controls',
                $projectNumber,
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
                        'anthropic-beta' => 'google-managed-data-controls-2026-09-01',
                    ],
                ],
                $options,
            )->withQualifiers(['beta' => 'true'])->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.providers.google.projects.data_controls.update',
                route: '/v1/organizations/providers/google/projects/{project_number}/data_controls',
                attributes: [
                    'anthropic.organization.provider.google.project.id' => $projectNumber,
                ],
            )),
            convert: BetaGoogleManagedProjectDataControls::class,
        );
    }
}
