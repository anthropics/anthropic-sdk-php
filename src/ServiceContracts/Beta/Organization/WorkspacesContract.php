<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization;

use Anthropic\Beta\AnthropicBeta;
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
use Anthropic\Beta\Organization\Workspaces\DataResidencyCreateConfig;
use Anthropic\Beta\Organization\Workspaces\DataResidencyUpdateConfig;
use Anthropic\Beta\Organization\Workspaces\HumanReviewOnWithExternalStorageException;
use Anthropic\Beta\Organization\Workspaces\InferenceDataPrivacyCreateParam;
use Anthropic\Beta\Organization\Workspaces\InferenceDataPrivacyUpdateParam;
use Anthropic\Beta\Organization\Workspaces\TranscriptsStorageRequiredException;
use Anthropic\Beta\Organization\Workspaces\Workspace;
use Anthropic\Beta\Organization\Workspaces\WorkspaceChangedConcurrentlyException;
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
 * @phpstan-import-type DataResidencyCreateConfigShape from \Anthropic\Beta\Organization\Workspaces\DataResidencyCreateConfig
 * @phpstan-import-type InferenceDataPrivacyCreateParamShape from \Anthropic\Beta\Organization\Workspaces\InferenceDataPrivacyCreateParam
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 * @phpstan-import-type DataResidencyUpdateConfigShape from \Anthropic\Beta\Organization\Workspaces\DataResidencyUpdateConfig
 * @phpstan-import-type InferenceDataPrivacyUpdateParamShape from \Anthropic\Beta\Organization\Workspaces\InferenceDataPrivacyUpdateParam
 */
interface WorkspacesContract
{
    /**
     * @api
     *
     * @param string $name Body param: Name of the Workspace.
     * @param DataResidencyCreateConfig|DataResidencyCreateConfigShape|null $dataResidency Body param: Data residency configuration for the workspace. If omitted, defaults to `workspace_geo: "us"`, `allowed_inference_geos: "unrestricted"`, and `default_inference_geo: "global"`.
     * @param string|null $displayColor Body param: Hex color code representing the Workspace in the Anthropic Console.
     * @param string|null $externalKeyID Body param: ID of the customer-managed encryption key (CMEK) configuration to use for this
     * Workspace. Setting this field requires CMEK to be enabled for your
     * organization. When set, data stored for this Workspace is encrypted with the
     * referenced key. Create key configurations with the External Keys API. On
     * Claude Platform on AWS the value for an AWS KMS key is the key's ARN, and your
     * organization's own key must be a single-Region key in the same Region as the
     * Workspace. If that key is outside the Workspace's AWS account, it can be attached
     * only by updating an active Workspace. On that platform the key is validated
     * against this Workspace when it is attached, so a key-policy problem is reported
     * as an error on this request. This field is write-once: once a key is attached to
     * a Workspace it cannot be detached or replaced. To rotate key material, rotate
     * the underlying key on your cloud KMS; the `external_key_id` stays the same.
     * @param InferenceDataPrivacyCreateParam|InferenceDataPrivacyCreateParamShape|null $inferenceDataPrivacy Body param: Where the Workspace's retained inference data and transcript copies go, and whether Anthropic's human review applies. Requires the `efs-2026-10-01` `anthropic-beta` value. When omitted, `safeguards_storage` and `transcripts_storage` are `internal` and `human_review` is `enabled`. Cannot be null. An Admin API key can't set this field, because it doesn't belong to a user or a service account. Use an API key that belongs to one, or an OAuth token.
     * @param array<string,string>|null $tags Body param: User-defined tags as string key-value pairs. Keys may not begin with `anthropic`.
     * @param string|null $userProfileID Body param: ID of a user profile to attach to the Workspace. Every inference request through the Workspace must then name this user profile; the API rejects a request that names none or a different one. The user profile can't be replaced or removed later; only deleting the user profile clears it.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas Header param: Optional header to specify the beta version(s) you want to use.
     * @param RequestOpts|null $requestOptions
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
        string $name,
        DataResidencyCreateConfig|array|null $dataResidency = null,
        ?string $displayColor = null,
        ?string $externalKeyID = null,
        InferenceDataPrivacyCreateParam|array|null $inferenceDataPrivacy = null,
        ?array $tags = null,
        ?string $userProfileID = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): Workspace;

    /**
     * @api
     *
     * @param string $workspaceID ID of the Workspace.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas Optional. Send `efs-2026-10-01` in this header to use this endpoint's beta features: additional parameters, accepted values and response fields.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $workspaceID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): Workspace;

    /**
     * @api
     *
     * @param string $workspaceID Path param
     * @param DataResidencyUpdateConfig|DataResidencyUpdateConfigShape|null $dataResidency Body param: Data residency configuration for the workspace.
     * @param string $displayColor Body param: Hex color code representing the Workspace in the Anthropic Console.
     * @param string $externalKeyID Body param: ID of the customer-managed encryption key (CMEK) configuration to use for this
     * Workspace. Setting this field requires CMEK to be enabled for your
     * organization. When set, data stored for this Workspace is encrypted with the
     * referenced key. Create key configurations with the External Keys API. On
     * Claude Platform on AWS the value for an AWS KMS key is the key's ARN, and your
     * organization's own key must be a single-Region key in the same Region as the
     * Workspace. If that key is outside the Workspace's AWS account, it can be attached
     * only by updating an active Workspace. On that platform the key is validated
     * against this Workspace when it is attached, so a key-policy problem is reported
     * as an error on this request. This field is write-once: once a key is attached to
     * a Workspace it cannot be detached or replaced. To rotate key material, rotate
     * the underlying key on your cloud KMS; the `external_key_id` stays the same.
     * @param InferenceDataPrivacyUpdateParam|InferenceDataPrivacyUpdateParamShape|null $inferenceDataPrivacy Body param: Changes to where the Workspace's retained inference data and transcript copies go, and to whether Anthropic's human review applies. Requires the `efs-2026-10-01` `anthropic-beta` value. An omitted member is unchanged. Cannot be null. An Admin API key can't set this field, because it doesn't belong to a user or a service account. Use an API key that belongs to one, or an OAuth token.
     * @param string $name Body param: Name of the Workspace.
     * @param array<string,string|null>|null $tags Body param: User-defined tags as string key-value pairs. Keys may not begin with `anthropic`.
     * @param string $userProfileID Body param: ID of a user profile to attach to the Workspace. Every inference request through the Workspace must then name this user profile; the API rejects a request that names none or a different one. Once set, it can't be replaced or removed (sending the same ID again changes nothing); only deleting the user profile clears it. It can't be set on a Workspace whose External Key isn't bound to this user profile. The default Workspace can't have a user profile.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas Header param: Optional. Send `efs-2026-10-01` in this header to use this endpoint's beta features: additional parameters, accepted values and response fields.
     * @param RequestOpts|null $requestOptions
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
        DataResidencyUpdateConfig|array|null $dataResidency = null,
        ?string $displayColor = null,
        ?string $externalKeyID = null,
        InferenceDataPrivacyUpdateParam|array|null $inferenceDataPrivacy = null,
        ?string $name = null,
        ?array $tags = null,
        ?string $userProfileID = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): Workspace;

    /**
     * @api
     *
     * @param string $afterID Query param: ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately after this object.
     * @param string $beforeID Query param: ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately before this object.
     * @param list<string> $ids Query param: Only the Workspaces with these IDs, at most 100. `include_archived` and `include_default` still apply, and IDs of Workspaces the caller can't list are left out.
     * @param bool $includeArchived Query param: Whether to include Workspaces that have been archived in the response
     * @param bool $includeDefault Query param: Whether to include the organization's default Workspace in the response
     * @param int $limit Query param: Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas Header param: Optional. Send `efs-2026-10-01` in this header to use this endpoint's beta features: additional parameters, accepted values and response fields.
     * @param RequestOpts|null $requestOptions
     *
     * @return Page<Workspace>
     *
     * @throws APIException
     */
    public function list(
        ?string $afterID = null,
        ?string $beforeID = null,
        ?array $ids = null,
        ?bool $includeArchived = null,
        ?bool $includeDefault = null,
        ?int $limit = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): Page;

    /**
     * @api
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas Optional. Send `efs-2026-10-01` in this header to use this endpoint's beta features: additional parameters, accepted values and response fields.
     * @param RequestOpts|null $requestOptions
     *
     * @throws SandboxEgressRestrictedException
     * @throws StorageAttachedDuringArchiveException
     * @throws APIException
     */
    public function archive(
        string $workspaceID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): Workspace;
}
