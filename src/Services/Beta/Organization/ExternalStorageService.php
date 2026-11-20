<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\BetaAuthorizationCheckUnavailableException;
use Anthropic\Beta\Organization\BetaOrganizationNotEligibleException;
use Anthropic\Beta\Organization\ExternalStorage\AWSExternalStorageConfigParam;
use Anthropic\Beta\Organization\ExternalStorage\DeletedExternalStorage;
use Anthropic\Beta\Organization\ExternalStorage\ExternalStorage;
use Anthropic\Beta\Organization\ExternalStorage\ExternalStorageInUseException;
use Anthropic\Beta\Organization\ExternalStorage\ExternalStorageInWorkspacePolicyException;
use Anthropic\Beta\Organization\ExternalStorage\GCPExternalStorageConfigParam;
use Anthropic\Beta\Organization\ExternalStorage\GrantRequiredException;
use Anthropic\Beta\Organization\ExternalStorage\InvalidStorageARNException;
use Anthropic\Beta\Organization\ExternalStorage\ProviderNotAllowedException;
use Anthropic\Beta\Organization\ExternalStorage\StorageAlreadyRegisteredException;
use Anthropic\Beta\Organization\ExternalStorage\StorageVerificationFailedException;
use Anthropic\Beta\Organization\ExternalStorage\UnsupportedRegionException;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\SandboxEgressRestrictedException;
use Anthropic\ServiceContracts\Beta\Organization\ExternalStorageContract;
use Anthropic\UserProfiles\UserProfileNotFoundException;

/**
 * @phpstan-import-type ProviderConfigShape from \Anthropic\Beta\Organization\ExternalStorage\ExternalStorageCreateParams\ProviderConfig
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class ExternalStorageService implements ExternalStorageContract
{
    /**
     * @api
     */
    public ExternalStorageRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ExternalStorageRawService($client);
    }

    /**
     * @api
     *
     * Register a bucket in the organization's own cloud account. It is saved
     * as `pending_configuration` and verified when activated.
     *
     * @param ProviderConfigShape $providerConfig Body param
     * @param string|null $displayName Body param: Human-friendly display name.
     * @param string|null $userProfileID Body param: The user profile to bind the storage to. It can't be changed later. The storage can be attached only to Workspaces with this profile, and the bucket's setup must name the same ID.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas Header param: This endpoint is in beta: requests must send `efs-2026-10-01` in this header.
     * @param RequestOpts|null $requestOptions
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
        AWSExternalStorageConfigParam|array|GCPExternalStorageConfigParam $providerConfig,
        ?string $displayName = null,
        ?string $userProfileID = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): ExternalStorage {
        $params = Util::removeNulls(
            [
                'providerConfig' => $providerConfig,
                'displayName' => $displayName,
                'userProfileID' => $userProfileID,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get one External Storage in the organization.
     *
     * @param string $externalStorageID The External Storage ID, which starts with `estrg_`. Through Claude Platform on AWS, storage whose `provider_config.type` is `aws` has its bucket ARN as its ID instead: `arn:<partition>:s3:::<bucket_name>`, where `<partition>` is the partition of the bucket's region.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas This endpoint is in beta: requests must send `efs-2026-10-01` in this header.
     * @param RequestOpts|null $requestOptions
     *
     * @throws InvalidStorageARNException
     * @throws APIException
     */
    public function retrieve(
        string $externalStorageID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): ExternalStorage {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($externalStorageID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Rename External Storage or clear its name, in any status.
     *
     * @param string $externalStorageID Path param: The External Storage ID, which starts with `estrg_`. Through Claude Platform on AWS, storage whose `provider_config.type` is `aws` has its bucket ARN as its ID instead: `arn:<partition>:s3:::<bucket_name>`, where `<partition>` is the partition of the bucket's region.
     * @param string|null $displayName Body param: Human-friendly display name; null clears it.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas Header param: This endpoint is in beta: requests must send `efs-2026-10-01` in this header.
     * @param RequestOpts|null $requestOptions
     *
     * @throws InvalidStorageARNException
     * @throws SandboxEgressRestrictedException
     * @throws APIException
     */
    public function update(
        string $externalStorageID,
        ?string $displayName,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): ExternalStorage {
        $params = Util::removeNulls(
            ['displayName' => $displayName, 'betas' => $betas],
            except: ['displayName'],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($externalStorageID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List the organization's External Storage, newest first.
     *
     * @param int $limit Query param: Number of results per page.
     * @param string|null $page Query param: Opaque cursor from a previous response's `next_page`.
     * @param list<string>|null $userProfileIDs Query param: Returns only External Storage bound to one of these user profile IDs (`uprof_...`). An empty entry matches storage bound to no user profile. At most 10 entries, counting repeats.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas Header param: This endpoint is in beta: requests must send `efs-2026-10-01` in this header.
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<ExternalStorage>
     *
     * @throws APIException
     */
    public function list(
        ?int $limit = null,
        ?string $page = null,
        ?array $userProfileIDs = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor {
        $params = Util::removeNulls(
            [
                'limit' => $limit,
                'page' => $page,
                'userProfileIDs' => $userProfileIDs,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas This endpoint is in beta: requests must send `efs-2026-10-01` in this header.
     * @param RequestOpts|null $requestOptions
     *
     * @throws ExternalStorageInUseException
     * @throws ExternalStorageInWorkspacePolicyException
     * @throws InvalidStorageARNException
     * @throws SandboxEgressRestrictedException
     * @throws APIException
     */
    public function delete(
        string $externalStorageID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): DeletedExternalStorage {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($externalStorageID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Verify pending External Storage and make it available. Storage that is
     * already available, active or draining comes back unchanged, without any
     * check.
     *
     * @param string $externalStorageID The External Storage ID, which starts with `estrg_`. Through Claude Platform on AWS, storage whose `provider_config.type` is `aws` has its bucket ARN as its ID instead: `arn:<partition>:s3:::<bucket_name>`, where `<partition>` is the partition of the bucket's region.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas This endpoint is in beta: requests must send `efs-2026-10-01` in this header.
     * @param RequestOpts|null $requestOptions
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
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): ExternalStorage {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->activate($externalStorageID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
