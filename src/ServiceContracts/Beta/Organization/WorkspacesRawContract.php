<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization;

use Anthropic\Beta\Organization\BetaApprovalRequiredException;
use Anthropic\Beta\Organization\BetaAuthorizationCheckUnavailableException;
use Anthropic\Beta\Organization\BetaHumanReviewNotAvailableException;
use Anthropic\Beta\Organization\BetaOrganizationNotEligibleException;
use Anthropic\Beta\Organization\ExternalStorage\ExternalStorageNotAvailableException;
use Anthropic\Beta\Organization\ExternalStorage\GrantRequiredException;
use Anthropic\Beta\Organization\ExternalStorage\InvalidStorageARNException;
use Anthropic\Beta\Organization\ExternalStorage\StorageAttachLimitReachedException;
use Anthropic\Beta\Organization\ExternalStorage\StorageChangedConcurrentlyException;
use Anthropic\Beta\Organization\ExternalStorage\StorageNotAttachableException;
use Anthropic\Beta\Organization\ExternalStorage\StorageProfileStillRequiredException;
use Anthropic\Beta\Organization\ExternalStorage\StorageVerificationFailedException;
use Anthropic\Beta\Organization\Workspaces\HumanReviewOnWithExternalStorageException;
use Anthropic\Beta\Organization\Workspaces\TranscriptsStorageRequiredException;
use Anthropic\Beta\Organization\Workspaces\Workspace;
use Anthropic\Beta\Organization\Workspaces\WorkspaceArchiveParams;
use Anthropic\Beta\Organization\Workspaces\WorkspaceChangedConcurrentlyException;
use Anthropic\Beta\Organization\Workspaces\WorkspaceCreateParams;
use Anthropic\Beta\Organization\Workspaces\WorkspaceListParams;
use Anthropic\Beta\Organization\Workspaces\WorkspaceRetrieveParams;
use Anthropic\Beta\Organization\Workspaces\WorkspaceUpdateParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Organization\ChangeOutcomeUnknownException;
use Anthropic\Organization\ExternalKeys\ExternalKeyChangedException;
use Anthropic\Organization\ExternalKeys\ExternalKeyValidationFailedException;
use Anthropic\Organization\ExternalKeys\ExternalKeyValidationTimedOutException;
use Anthropic\Organization\Workspaces\KeyProfileMismatchException;
use Anthropic\Organization\Workspaces\StorageAttachedDuringArchiveException;
use Anthropic\Organization\Workspaces\StorageProfileMismatchException;
use Anthropic\Organization\Workspaces\WorkspaceCreatedIncompleteException;
use Anthropic\Organization\Workspaces\WorkspacePolicyViolationException;
use Anthropic\Page;
use Anthropic\RequestOptions;
use Anthropic\SandboxEgressRestrictedException;
use Anthropic\UserProfiles\UserProfileNotFoundException;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface WorkspacesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|WorkspaceCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Workspace>
     *
     * @throws BetaApprovalRequiredException
     * @throws ExternalKeyValidationFailedException
     * @throws ExternalKeyValidationTimedOutException
     * @throws ExternalStorageNotAvailableException
     * @throws GrantRequiredException
     * @throws BetaHumanReviewNotAvailableException
     * @throws HumanReviewOnWithExternalStorageException
     * @throws InvalidStorageARNException
     * @throws KeyProfileMismatchException
     * @throws BetaOrganizationNotEligibleException
     * @throws StorageNotAttachableException
     * @throws StorageProfileMismatchException
     * @throws StorageVerificationFailedException
     * @throws TranscriptsStorageRequiredException
     * @throws UserProfileNotFoundException
     * @throws WorkspacePolicyViolationException
     * @throws SandboxEgressRestrictedException
     * @throws ExternalKeyChangedException
     * @throws BetaAuthorizationCheckUnavailableException
     * @throws WorkspaceCreatedIncompleteException
     * @throws APIException
     */
    public function create(
        array|WorkspaceCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $workspaceID ID of the Workspace.
     * @param array<string,mixed>|WorkspaceRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Workspace>
     *
     * @throws APIException
     */
    public function retrieve(
        string $workspaceID,
        array|WorkspaceRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $workspaceID Path param
     * @param array<string,mixed>|WorkspaceUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Workspace>
     *
     * @throws BetaApprovalRequiredException
     * @throws ExternalKeyValidationFailedException
     * @throws ExternalKeyValidationTimedOutException
     * @throws ExternalStorageNotAvailableException
     * @throws GrantRequiredException
     * @throws BetaHumanReviewNotAvailableException
     * @throws HumanReviewOnWithExternalStorageException
     * @throws InvalidStorageARNException
     * @throws KeyProfileMismatchException
     * @throws BetaOrganizationNotEligibleException
     * @throws StorageAttachLimitReachedException
     * @throws StorageNotAttachableException
     * @throws StorageProfileMismatchException
     * @throws StorageProfileStillRequiredException
     * @throws StorageVerificationFailedException
     * @throws TranscriptsStorageRequiredException
     * @throws UserProfileNotFoundException
     * @throws WorkspacePolicyViolationException
     * @throws SandboxEgressRestrictedException
     * @throws ExternalKeyChangedException
     * @throws StorageChangedConcurrentlyException
     * @throws WorkspaceChangedConcurrentlyException
     * @throws BetaAuthorizationCheckUnavailableException
     * @throws ChangeOutcomeUnknownException
     * @throws APIException
     */
    public function update(
        string $workspaceID,
        array|WorkspaceUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|WorkspaceListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Page<Workspace>>
     *
     * @throws APIException
     */
    public function list(
        array|WorkspaceListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|WorkspaceArchiveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Workspace>
     *
     * @throws SandboxEgressRestrictedException
     * @throws StorageAttachedDuringArchiveException
     * @throws APIException
     */
    public function archive(
        string $workspaceID,
        array|WorkspaceArchiveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
