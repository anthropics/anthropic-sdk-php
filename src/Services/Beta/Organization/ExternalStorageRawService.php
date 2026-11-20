<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\BetaAuthorizationCheckUnavailableException;
use Anthropic\Beta\Organization\BetaOrganizationNotEligibleException;
use Anthropic\Beta\Organization\ExternalStorage\DeletedExternalStorage;
use Anthropic\Beta\Organization\ExternalStorage\ExternalStorage;
use Anthropic\Beta\Organization\ExternalStorage\ExternalStorageActivateParams;
use Anthropic\Beta\Organization\ExternalStorage\ExternalStorageCreateParams;
use Anthropic\Beta\Organization\ExternalStorage\ExternalStorageDeleteParams;
use Anthropic\Beta\Organization\ExternalStorage\ExternalStorageInUseException;
use Anthropic\Beta\Organization\ExternalStorage\ExternalStorageInWorkspacePolicyException;
use Anthropic\Beta\Organization\ExternalStorage\ExternalStorageListParams;
use Anthropic\Beta\Organization\ExternalStorage\ExternalStorageRetrieveParams;
use Anthropic\Beta\Organization\ExternalStorage\ExternalStorageUpdateParams;
use Anthropic\Beta\Organization\ExternalStorage\GrantRequiredException;
use Anthropic\Beta\Organization\ExternalStorage\InvalidStorageARNException;
use Anthropic\Beta\Organization\ExternalStorage\ProviderNotAllowedException;
use Anthropic\Beta\Organization\ExternalStorage\StorageAlreadyRegisteredException;
use Anthropic\Beta\Organization\ExternalStorage\StorageVerificationFailedException;
use Anthropic\Beta\Organization\ExternalStorage\UnsupportedRegionException;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Implementation\ApiCallInfo;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\SandboxEgressRestrictedException;
use Anthropic\ServiceContracts\Beta\Organization\ExternalStorageRawContract;
use Anthropic\UserProfiles\UserProfileNotFoundException;

/**
 * @phpstan-import-type ProviderConfigShape from \Anthropic\Beta\Organization\ExternalStorage\ExternalStorageCreateParams\ProviderConfig
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class ExternalStorageRawService implements ExternalStorageRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Register a bucket in the organization's own cloud account. It is saved
     * as `pending_configuration` and verified when activated.
     *
     * @param array{
     *   providerConfig: ProviderConfigShape,
     *   displayName?: string|null,
     *   userProfileID?: string|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|ExternalStorageCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ExternalStorage>
     *
     * @throws GrantRequiredException
     * @throws BetaOrganizationNotEligibleException
     * @throws ProviderNotAllowedException
     * @throws UnsupportedRegionException
     * @throws UserProfileNotFoundException
     * @throws SandboxEgressRestrictedException
     * @throws StorageAlreadyRegisteredException
     * @throws BetaAuthorizationCheckUnavailableException
     * @throws APIException
     */
    public function create(
        array|ExternalStorageCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ExternalStorageCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/organizations/external_storage',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'efs-2026-10-01']],
                $options
            )->withQualifiers(['beta' => 'true'])->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.external_storage.create',
                route: '/v1/organizations/external_storage',
                createdId: 'anthropic.organization.external_storage.id',
            )),
            convert: ExternalStorage::class,
        );
    }

    /**
     * @api
     *
     * Get one External Storage in the organization.
     *
     * @param string $externalStorageID The External Storage ID, which starts with `estrg_`. Through Claude Platform on AWS, storage whose `provider_config.type` is `aws` has its bucket ARN as its ID instead: `arn:<partition>:s3:::<bucket_name>`, where `<partition>` is the partition of the bucket's region.
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|ExternalStorageRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ExternalStorage>
     *
     * @throws InvalidStorageARNException
     * @throws APIException
     */
    public function retrieve(
        string $externalStorageID,
        array|ExternalStorageRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ExternalStorageRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/organizations/external_storage/%1$s', $externalStorageID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'efs-2026-10-01']],
                $options
            )->withQualifiers(['beta' => 'true'])->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.external_storage.retrieve',
                route: '/v1/organizations/external_storage/{external_storage_id}',
                attributes: [
                    'anthropic.organization.external_storage.id' => $externalStorageID,
                ],
            )),
            convert: ExternalStorage::class,
        );
    }

    /**
     * @api
     *
     * Rename External Storage or clear its name, in any status.
     *
     * @param string $externalStorageID Path param: The External Storage ID, which starts with `estrg_`. Through Claude Platform on AWS, storage whose `provider_config.type` is `aws` has its bucket ARN as its ID instead: `arn:<partition>:s3:::<bucket_name>`, where `<partition>` is the partition of the bucket's region.
     * @param array{
     *   displayName: string|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|ExternalStorageUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ExternalStorage>
     *
     * @throws InvalidStorageARNException
     * @throws SandboxEgressRestrictedException
     * @throws APIException
     */
    public function update(
        string $externalStorageID,
        array|ExternalStorageUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ExternalStorageUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/organizations/external_storage/%1$s', $externalStorageID],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'efs-2026-10-01']],
                $options
            )->withQualifiers(['beta' => 'true'])->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.external_storage.update',
                route: '/v1/organizations/external_storage/{external_storage_id}',
                attributes: [
                    'anthropic.organization.external_storage.id' => $externalStorageID,
                ],
            )),
            convert: ExternalStorage::class,
        );
    }

    /**
     * @api
     *
     * List the organization's External Storage, newest first.
     *
     * @param array{
     *   limit?: int,
     *   page?: string|null,
     *   userProfileIDs?: list<string>|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|ExternalStorageListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<ExternalStorage>>
     *
     * @throws APIException
     */
    public function list(
        array|ExternalStorageListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ExternalStorageListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(['limit', 'page', 'userProfileIDs']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/organizations/external_storage',
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                ['userProfileIDs' => 'user_profile_ids'],
            ),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'efs-2026-10-01']],
                $options
            )->withQualifiers(['beta' => 'true'])->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.external_storage.list',
                route: '/v1/organizations/external_storage',
                query: ['limit', 'page', 'user_profile_ids'],
            )),
            convert: ExternalStorage::class,
            page: PageCursor::class,
        );
    }

    /**
     * @api
     *
     * Delete External Storage. Storage that is pending configuration, available, or active
     * but never attached is deleted at once, unless an Enterprise Frontier Safeguards workspace
     * policy lists it. Other storage gets a 400 that says what to do next. On `draining`
     * storage that 400 can mean this delete started a removal that can't be undone. To check,
     * get the storage: if `status.removal_started` is true, delete it again later to finish.
     *
     * @param string $externalStorageID The External Storage ID, which starts with `estrg_`. Through Claude Platform on AWS, storage whose `provider_config.type` is `aws` has its bucket ARN as its ID instead: `arn:<partition>:s3:::<bucket_name>`, where `<partition>` is the partition of the bucket's region.
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|ExternalStorageDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<DeletedExternalStorage>
     *
     * @throws ExternalStorageInUseException
     * @throws ExternalStorageInWorkspacePolicyException
     * @throws InvalidStorageARNException
     * @throws SandboxEgressRestrictedException
     * @throws APIException
     */
    public function delete(
        string $externalStorageID,
        array|ExternalStorageDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ExternalStorageDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/organizations/external_storage/%1$s', $externalStorageID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'efs-2026-10-01']],
                $options
            )->withQualifiers(['beta' => 'true'])->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.external_storage.delete',
                route: '/v1/organizations/external_storage/{external_storage_id}',
                attributes: [
                    'anthropic.organization.external_storage.id' => $externalStorageID,
                ],
            )),
            convert: DeletedExternalStorage::class,
        );
    }

    /**
     * @api
     *
     * Verify pending External Storage and make it available. Storage that is
     * already available, active or draining comes back unchanged, without any
     * check.
     *
     * @param string $externalStorageID The External Storage ID, which starts with `estrg_`. Through Claude Platform on AWS, storage whose `provider_config.type` is `aws` has its bucket ARN as its ID instead: `arn:<partition>:s3:::<bucket_name>`, where `<partition>` is the partition of the bucket's region.
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|ExternalStorageActivateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ExternalStorage>
     *
     * @throws GrantRequiredException
     * @throws InvalidStorageARNException
     * @throws BetaOrganizationNotEligibleException
     * @throws ProviderNotAllowedException
     * @throws StorageVerificationFailedException
     * @throws UserProfileNotFoundException
     * @throws SandboxEgressRestrictedException
     * @throws BetaAuthorizationCheckUnavailableException
     * @throws APIException
     */
    public function activate(
        string $externalStorageID,
        array|ExternalStorageActivateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ExternalStorageActivateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/organizations/external_storage/%1$s/activate', $externalStorageID,
            ],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'efs-2026-10-01']],
                $options
            )->withQualifiers(['beta' => 'true'])->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.external_storage.activate',
                route: '/v1/organizations/external_storage/{external_storage_id}/activate',
                attributes: [
                    'anthropic.organization.external_storage.id' => $externalStorageID,
                ],
            )),
            convert: ExternalStorage::class,
        );
    }
}
