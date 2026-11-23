<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization;

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
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\SandboxEgressRestrictedException;
use Anthropic\UserProfiles\UserProfileNotFoundException;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface ExternalStorageRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|ExternalStorageCreateParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $externalStorageID The External Storage ID, which starts with `estrg_`. Through Claude Platform on AWS, storage whose `provider_config.type` is `aws` has its bucket ARN as its ID instead: `arn:<partition>:s3:::<bucket_name>`, where `<partition>` is the partition of the bucket's region.
     * @param array<string,mixed>|ExternalStorageRetrieveParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $externalStorageID Path param: The External Storage ID, which starts with `estrg_`. Through Claude Platform on AWS, storage whose `provider_config.type` is `aws` has its bucket ARN as its ID instead: `arn:<partition>:s3:::<bucket_name>`, where `<partition>` is the partition of the bucket's region.
     * @param array<string,mixed>|ExternalStorageUpdateParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|ExternalStorageListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<ExternalStorage>>
     *
     * @throws APIException
     */
    public function list(
        array|ExternalStorageListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $externalStorageID The External Storage ID, which starts with `estrg_`. Through Claude Platform on AWS, storage whose `provider_config.type` is `aws` has its bucket ARN as its ID instead: `arn:<partition>:s3:::<bucket_name>`, where `<partition>` is the partition of the bucket's region.
     * @param array<string,mixed>|ExternalStorageDeleteParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $externalStorageID The External Storage ID, which starts with `estrg_`. Through Claude Platform on AWS, storage whose `provider_config.type` is `aws` has its bucket ARN as its ID instead: `arn:<partition>:s3:::<bucket_name>`, where `<partition>` is the partition of the bucket's region.
     * @param array<string,mixed>|ExternalStorageActivateParams $params
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
    ): BaseResponse;
}
