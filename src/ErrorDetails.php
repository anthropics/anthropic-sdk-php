<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Beta\BetaOrganizationNotEnrolledInBetaErrorDetails;
use Anthropic\Beta\BetaUnsupportedCharsetErrorDetails;
use Anthropic\Beta\Environments\BetaEnvironmentArchivedErrorDetails;
use Anthropic\Beta\Environments\BetaEnvironmentCreateDisabledErrorDetails;
use Anthropic\Beta\Environments\BetaEnvironmentNotFoundErrorDetails;
use Anthropic\Beta\Environments\BetaEnvironmentUpdateDisabledErrorDetails;
use Anthropic\Beta\Environments\BetaInvalidConfigTypeChangeErrorDetails;
use Anthropic\Beta\Environments\BetaInvalidMetadataErrorDetails;
use Anthropic\Beta\Environments\Work\HeartbeatPreconditionFailedErrorDetails;
use Anthropic\Beta\Organization\ClaudeTag\APIKeyScopeMissingErrorDetails;
use Anthropic\Beta\Organization\ClaudeTag\ClaudeTagWritesNotEnabledErrorDetails;
use Anthropic\Beta\Organization\ClaudeTag\ComplianceConfigurationRestrictedErrorDetails;
use Anthropic\Beta\Organization\ClaudeTag\OrganizationLevelScopedAPIKeyRequiredErrorDetails;
use Anthropic\Beta\Organization\ClaudeTag\SlackChannelSetUpEnvironmentNotFoundErrorDetails;
use Anthropic\Beta\Organization\ClaudeTag\SlackChannelSetUpSettingsConflictErrorDetails;
use Anthropic\Beta\Organization\ClaudeTag\SlackChannelSetUpSettingsRefusedErrorDetails;
use Anthropic\Beta\Organization\Plugins\PluginNameTakenErrorDetails;
use Anthropic\Beta\Organization\Plugins\RegistrationPendingErrorDetails;
use Anthropic\Beta\Organization\Plugins\ScanFailedErrorDetails;
use Anthropic\Beta\Organization\Plugins\ScanPendingErrorDetails;
use Anthropic\Beta\Organization\Plugins\SkillNameTakenErrorDetails;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitsAdminAPIWritesNotEnabledErrorDetails;
use Anthropic\Beta\Organization\Users\CannotSignOutManagedMemberErrorDetails;
use Anthropic\Beta\Organization\Users\CannotSignOutMembershipAdminErrorDetails;
use Anthropic\Beta\Organization\Users\CannotSignOutOwnerErrorDetails;
use Anthropic\Beta\Organization\Users\CannotSignOutPrimaryOwnerErrorDetails;
use Anthropic\Beta\Organization\Users\CannotSignOutPrivilegedMemberErrorDetails;
use Anthropic\Beta\Organization\Users\CannotSignOutSelfErrorDetails;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Files\FileExpiredErrorDetails;
use Anthropic\Files\FileNotDownloadableErrorDetails;
use Anthropic\Files\StorageQuotaExceededErrorDetails;
use Anthropic\Messages\AvailableToolsLimitExceededErrorDetails;
use Anthropic\Messages\CompactionBlockAmbiguousErrorDetails;
use Anthropic\Messages\CompactionBlockMisplacedErrorDetails;
use Anthropic\Messages\CompactionContentMismatchErrorDetails;
use Anthropic\Messages\CompactionIncompleteTurnErrorDetails;
use Anthropic\Messages\CompactionNothingToSummarizeErrorDetails;
use Anthropic\Messages\CompactionSignatureInvalidErrorDetails;
use Anthropic\Messages\CompactionToolChangesMismatchErrorDetails;
use Anthropic\Messages\CompactionTooManyToolReferencesErrorDetails;
use Anthropic\Messages\CompactionUnavailableErrorDetails;
use Anthropic\Messages\ThreadAlreadyContinuedErrorDetails;
use Anthropic\Messages\ThreadContinueInFlightErrorDetails;
use Anthropic\Messages\ThreadFingerprintMismatchErrorDetails;
use Anthropic\Messages\ThreadNotFoundErrorDetails;
use Anthropic\Messages\ThreadUnsupportedRequestErrorDetails;
use Anthropic\Messages\ToolNameConflictErrorDetails;
use Anthropic\Messages\ToolReferenceUnresolvedErrorDetails;
use Anthropic\Organization\APIKeys\OrgAPIKeyLimitExceededErrorDetails;
use Anthropic\Organization\APIKeys\WorkspaceAPIKeyLimitExceededErrorDetails;
use Anthropic\Organization\ConcurrentMembershipChangeErrorDetails;
use Anthropic\Organization\ExternalKeys\ExternalKeyChangedErrorDetails;
use Anthropic\Organization\ExternalKeys\ExternalKeyInWorkspacePolicyErrorDetails;
use Anthropic\Organization\ExternalKeys\ExternalKeyValidationFailedErrorDetails;
use Anthropic\Organization\ExternalKeys\ExternalKeyValidationTimedOutErrorDetails;
use Anthropic\Organization\Invites\AlreadyMemberErrorDetails;
use Anthropic\Organization\Invites\CannotInviteEmailsWithUnverifiedDomainsErrorDetails;
use Anthropic\Organization\Invites\EmailDomainNotAllowedErrorDetails;
use Anthropic\Organization\Invites\InviteAlreadyExistsErrorDetails;
use Anthropic\Organization\OrgMemberLimitExceededErrorDetails;
use Anthropic\Organization\RBACGroups\RBACGroupGrantsOwnerAccessErrorDetails;
use Anthropic\Organization\RBACGroups\RBACGroupOwnerAccessUnconfirmedErrorDetails;
use Anthropic\Organization\Users\CannotRemoveLastMemberErrorDetails;
use Anthropic\Organization\Workspaces\KeyProfileMismatchErrorDetails;
use Anthropic\Organization\Workspaces\WorkspaceMemberLimitExceededErrorDetails;
use Anthropic\Organization\Workspaces\WorkspacePolicyViolationErrorDetails;
use Anthropic\Skills\SkillReadBlockedUndecryptableErrorDetails;
use Anthropic\UserProfiles\UserProfileNotFoundErrorDetails;

/**
 * @phpstan-import-type AvailableToolsLimitExceededErrorDetailsShape from \Anthropic\Messages\AvailableToolsLimitExceededErrorDetails
 * @phpstan-import-type ClaudeCodeKeyCreatorNotMemberErrorDetailsShape from \Anthropic\ClaudeCodeKeyCreatorNotMemberErrorDetails
 * @phpstan-import-type ClaudeCodeVersionTooOldErrorDetailsShape from \Anthropic\ClaudeCodeVersionTooOldErrorDetails
 * @phpstan-import-type CMEKKeyDisabledErrorDetailsShape from \Anthropic\CMEKKeyDisabledErrorDetails
 * @phpstan-import-type CMEKKeyNetworkBlockedErrorDetailsShape from \Anthropic\CMEKKeyNetworkBlockedErrorDetails
 * @phpstan-import-type CompactionBlockAmbiguousErrorDetailsShape from \Anthropic\Messages\CompactionBlockAmbiguousErrorDetails
 * @phpstan-import-type CompactionBlockMisplacedErrorDetailsShape from \Anthropic\Messages\CompactionBlockMisplacedErrorDetails
 * @phpstan-import-type CompactionContentMismatchErrorDetailsShape from \Anthropic\Messages\CompactionContentMismatchErrorDetails
 * @phpstan-import-type CompactionIncompleteTurnErrorDetailsShape from \Anthropic\Messages\CompactionIncompleteTurnErrorDetails
 * @phpstan-import-type CompactionNothingToSummarizeErrorDetailsShape from \Anthropic\Messages\CompactionNothingToSummarizeErrorDetails
 * @phpstan-import-type CompactionSignatureInvalidErrorDetailsShape from \Anthropic\Messages\CompactionSignatureInvalidErrorDetails
 * @phpstan-import-type CompactionTooManyToolReferencesErrorDetailsShape from \Anthropic\Messages\CompactionTooManyToolReferencesErrorDetails
 * @phpstan-import-type CompactionToolChangesMismatchErrorDetailsShape from \Anthropic\Messages\CompactionToolChangesMismatchErrorDetails
 * @phpstan-import-type OrganizationOnHoldErrorDetailsShape from \Anthropic\OrganizationOnHoldErrorDetails
 * @phpstan-import-type RequestBodyEncodingInvalidErrorDetailsShape from \Anthropic\RequestBodyEncodingInvalidErrorDetails
 * @phpstan-import-type RequestBodyEncodingUnsupportedErrorDetailsShape from \Anthropic\RequestBodyEncodingUnsupportedErrorDetails
 * @phpstan-import-type ThreadAlreadyContinuedErrorDetailsShape from \Anthropic\Messages\ThreadAlreadyContinuedErrorDetails
 * @phpstan-import-type ThreadContinueInFlightErrorDetailsShape from \Anthropic\Messages\ThreadContinueInFlightErrorDetails
 * @phpstan-import-type ThreadFingerprintMismatchErrorDetailsShape from \Anthropic\Messages\ThreadFingerprintMismatchErrorDetails
 * @phpstan-import-type ThreadUnsupportedRequestErrorDetailsShape from \Anthropic\Messages\ThreadUnsupportedRequestErrorDetails
 * @phpstan-import-type ToolNameConflictErrorDetailsShape from \Anthropic\Messages\ToolNameConflictErrorDetails
 * @phpstan-import-type ToolReferenceUnresolvedErrorDetailsShape from \Anthropic\Messages\ToolReferenceUnresolvedErrorDetails
 * @phpstan-import-type ThreadNotFoundErrorDetailsShape from \Anthropic\Messages\ThreadNotFoundErrorDetails
 * @phpstan-import-type SkillReadBlockedUndecryptableErrorDetailsShape from \Anthropic\Skills\SkillReadBlockedUndecryptableErrorDetails
 * @phpstan-import-type RequestBodyTooLargeAfterDecodingErrorDetailsShape from \Anthropic\RequestBodyTooLargeAfterDecodingErrorDetails
 * @phpstan-import-type EnforcedSpendLimitReachedErrorDetailsShape from \Anthropic\EnforcedSpendLimitReachedErrorDetails
 * @phpstan-import-type RampLimitExceededErrorDetailsShape from \Anthropic\RampLimitExceededErrorDetails
 * @phpstan-import-type CMEKKeyUnreachableErrorDetailsShape from \Anthropic\CMEKKeyUnreachableErrorDetails
 * @phpstan-import-type CompactionUnavailableErrorDetailsShape from \Anthropic\Messages\CompactionUnavailableErrorDetails
 * @phpstan-import-type StorageQuotaExceededErrorDetailsShape from \Anthropic\Files\StorageQuotaExceededErrorDetails
 * @phpstan-import-type FileNotDownloadableErrorDetailsShape from \Anthropic\Files\FileNotDownloadableErrorDetails
 * @phpstan-import-type FileExpiredErrorDetailsShape from \Anthropic\Files\FileExpiredErrorDetails
 * @phpstan-import-type CMEKContextUnavailableErrorDetailsShape from \Anthropic\CMEKContextUnavailableErrorDetails
 * @phpstan-import-type OrgAPIKeyLimitExceededErrorDetailsShape from \Anthropic\Organization\APIKeys\OrgAPIKeyLimitExceededErrorDetails
 * @phpstan-import-type WorkspaceAPIKeyLimitExceededErrorDetailsShape from \Anthropic\Organization\APIKeys\WorkspaceAPIKeyLimitExceededErrorDetails
 * @phpstan-import-type SandboxEgressRestrictedErrorDetailsShape from \Anthropic\SandboxEgressRestrictedErrorDetails
 * @phpstan-import-type UserProfileNotFoundErrorDetailsShape from \Anthropic\UserProfiles\UserProfileNotFoundErrorDetails
 * @phpstan-import-type ExternalKeyInWorkspacePolicyErrorDetailsShape from \Anthropic\Organization\ExternalKeys\ExternalKeyInWorkspacePolicyErrorDetails
 * @phpstan-import-type AlreadyMemberErrorDetailsShape from \Anthropic\Organization\Invites\AlreadyMemberErrorDetails
 * @phpstan-import-type CannotInviteEmailsWithUnverifiedDomainsErrorDetailsShape from \Anthropic\Organization\Invites\CannotInviteEmailsWithUnverifiedDomainsErrorDetails
 * @phpstan-import-type EmailDomainNotAllowedErrorDetailsShape from \Anthropic\Organization\Invites\EmailDomainNotAllowedErrorDetails
 * @phpstan-import-type InviteAlreadyExistsErrorDetailsShape from \Anthropic\Organization\Invites\InviteAlreadyExistsErrorDetails
 * @phpstan-import-type OrgMemberLimitExceededErrorDetailsShape from \Anthropic\Organization\OrgMemberLimitExceededErrorDetails
 * @phpstan-import-type RBACGroupGrantsOwnerAccessErrorDetailsShape from \Anthropic\Organization\RBACGroups\RBACGroupGrantsOwnerAccessErrorDetails
 * @phpstan-import-type RBACGroupOwnerAccessUnconfirmedErrorDetailsShape from \Anthropic\Organization\RBACGroups\RBACGroupOwnerAccessUnconfirmedErrorDetails
 * @phpstan-import-type CannotRemoveLastMemberErrorDetailsShape from \Anthropic\Organization\Users\CannotRemoveLastMemberErrorDetails
 * @phpstan-import-type ConcurrentMembershipChangeErrorDetailsShape from \Anthropic\Organization\ConcurrentMembershipChangeErrorDetails
 * @phpstan-import-type ExternalKeyValidationFailedErrorDetailsShape from \Anthropic\Organization\ExternalKeys\ExternalKeyValidationFailedErrorDetails
 * @phpstan-import-type ExternalKeyValidationTimedOutErrorDetailsShape from \Anthropic\Organization\ExternalKeys\ExternalKeyValidationTimedOutErrorDetails
 * @phpstan-import-type KeyProfileMismatchErrorDetailsShape from \Anthropic\Organization\Workspaces\KeyProfileMismatchErrorDetails
 * @phpstan-import-type WorkspacePolicyViolationErrorDetailsShape from \Anthropic\Organization\Workspaces\WorkspacePolicyViolationErrorDetails
 * @phpstan-import-type ExternalKeyChangedErrorDetailsShape from \Anthropic\Organization\ExternalKeys\ExternalKeyChangedErrorDetails
 * @phpstan-import-type WorkspaceMemberLimitExceededErrorDetailsShape from \Anthropic\Organization\Workspaces\WorkspaceMemberLimitExceededErrorDetails
 * @phpstan-import-type OrganizationTypeNotSupportedErrorDetailsShape from \Anthropic\OrganizationTypeNotSupportedErrorDetails
 * @phpstan-import-type BetaEnvironmentCreateDisabledErrorDetailsShape from \Anthropic\Beta\Environments\BetaEnvironmentCreateDisabledErrorDetails
 * @phpstan-import-type BetaEnvironmentArchivedErrorDetailsShape from \Anthropic\Beta\Environments\BetaEnvironmentArchivedErrorDetails
 * @phpstan-import-type BetaInvalidConfigTypeChangeErrorDetailsShape from \Anthropic\Beta\Environments\BetaInvalidConfigTypeChangeErrorDetails
 * @phpstan-import-type BetaEnvironmentUpdateDisabledErrorDetailsShape from \Anthropic\Beta\Environments\BetaEnvironmentUpdateDisabledErrorDetails
 * @phpstan-import-type HeartbeatPreconditionFailedErrorDetailsShape from \Anthropic\Beta\Environments\Work\HeartbeatPreconditionFailedErrorDetails
 * @phpstan-import-type BetaInvalidMetadataErrorDetailsShape from \Anthropic\Beta\Environments\BetaInvalidMetadataErrorDetails
 * @phpstan-import-type CannotSignOutPrimaryOwnerErrorDetailsShape from \Anthropic\Beta\Organization\Users\CannotSignOutPrimaryOwnerErrorDetails
 * @phpstan-import-type CannotSignOutSelfErrorDetailsShape from \Anthropic\Beta\Organization\Users\CannotSignOutSelfErrorDetails
 * @phpstan-import-type BetaOrganizationNotEnrolledInBetaErrorDetailsShape from \Anthropic\Beta\BetaOrganizationNotEnrolledInBetaErrorDetails
 * @phpstan-import-type CannotSignOutManagedMemberErrorDetailsShape from \Anthropic\Beta\Organization\Users\CannotSignOutManagedMemberErrorDetails
 * @phpstan-import-type CannotSignOutMembershipAdminErrorDetailsShape from \Anthropic\Beta\Organization\Users\CannotSignOutMembershipAdminErrorDetails
 * @phpstan-import-type CannotSignOutOwnerErrorDetailsShape from \Anthropic\Beta\Organization\Users\CannotSignOutOwnerErrorDetails
 * @phpstan-import-type CannotSignOutPrivilegedMemberErrorDetailsShape from \Anthropic\Beta\Organization\Users\CannotSignOutPrivilegedMemberErrorDetails
 * @phpstan-import-type SpendLimitsAdminAPIWritesNotEnabledErrorDetailsShape from \Anthropic\Beta\Organization\SpendLimits\SpendLimitsAdminAPIWritesNotEnabledErrorDetails
 * @phpstan-import-type BetaUnsupportedCharsetErrorDetailsShape from \Anthropic\Beta\BetaUnsupportedCharsetErrorDetails
 * @phpstan-import-type PluginNameTakenErrorDetailsShape from \Anthropic\Beta\Organization\Plugins\PluginNameTakenErrorDetails
 * @phpstan-import-type SkillNameTakenErrorDetailsShape from \Anthropic\Beta\Organization\Plugins\SkillNameTakenErrorDetails
 * @phpstan-import-type RegistrationPendingErrorDetailsShape from \Anthropic\Beta\Organization\Plugins\RegistrationPendingErrorDetails
 * @phpstan-import-type ScanFailedErrorDetailsShape from \Anthropic\Beta\Organization\Plugins\ScanFailedErrorDetails
 * @phpstan-import-type ScanPendingErrorDetailsShape from \Anthropic\Beta\Organization\Plugins\ScanPendingErrorDetails
 * @phpstan-import-type SlackChannelSetUpSettingsRefusedErrorDetailsShape from \Anthropic\Beta\Organization\ClaudeTag\SlackChannelSetUpSettingsRefusedErrorDetails
 * @phpstan-import-type APIKeyScopeMissingErrorDetailsShape from \Anthropic\Beta\Organization\ClaudeTag\APIKeyScopeMissingErrorDetails
 * @phpstan-import-type ClaudeTagWritesNotEnabledErrorDetailsShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagWritesNotEnabledErrorDetails
 * @phpstan-import-type ComplianceConfigurationRestrictedErrorDetailsShape from \Anthropic\Beta\Organization\ClaudeTag\ComplianceConfigurationRestrictedErrorDetails
 * @phpstan-import-type OrganizationLevelScopedAPIKeyRequiredErrorDetailsShape from \Anthropic\Beta\Organization\ClaudeTag\OrganizationLevelScopedAPIKeyRequiredErrorDetails
 * @phpstan-import-type BetaEnvironmentNotFoundErrorDetailsShape from \Anthropic\Beta\Environments\BetaEnvironmentNotFoundErrorDetails
 * @phpstan-import-type SlackChannelSetUpEnvironmentNotFoundErrorDetailsShape from \Anthropic\Beta\Organization\ClaudeTag\SlackChannelSetUpEnvironmentNotFoundErrorDetails
 * @phpstan-import-type SlackChannelSetUpSettingsConflictErrorDetailsShape from \Anthropic\Beta\Organization\ClaudeTag\SlackChannelSetUpSettingsConflictErrorDetails
 *
 * @phpstan-type ErrorDetailsVariants = AvailableToolsLimitExceededErrorDetails|ClaudeCodeKeyCreatorNotMemberErrorDetails|ClaudeCodeVersionTooOldErrorDetails|CMEKKeyDisabledErrorDetails|CMEKKeyNetworkBlockedErrorDetails|CompactionBlockAmbiguousErrorDetails|CompactionBlockMisplacedErrorDetails|CompactionContentMismatchErrorDetails|CompactionIncompleteTurnErrorDetails|CompactionNothingToSummarizeErrorDetails|CompactionSignatureInvalidErrorDetails|CompactionTooManyToolReferencesErrorDetails|CompactionToolChangesMismatchErrorDetails|OrganizationOnHoldErrorDetails|RequestBodyEncodingInvalidErrorDetails|RequestBodyEncodingUnsupportedErrorDetails|ThreadAlreadyContinuedErrorDetails|ThreadContinueInFlightErrorDetails|ThreadFingerprintMismatchErrorDetails|ThreadUnsupportedRequestErrorDetails|ToolNameConflictErrorDetails|ToolReferenceUnresolvedErrorDetails|ThreadNotFoundErrorDetails|SkillReadBlockedUndecryptableErrorDetails|RequestBodyTooLargeAfterDecodingErrorDetails|EnforcedSpendLimitReachedErrorDetails|RampLimitExceededErrorDetails|CMEKKeyUnreachableErrorDetails|CompactionUnavailableErrorDetails|StorageQuotaExceededErrorDetails|FileNotDownloadableErrorDetails|FileExpiredErrorDetails|CMEKContextUnavailableErrorDetails|OrgAPIKeyLimitExceededErrorDetails|WorkspaceAPIKeyLimitExceededErrorDetails|SandboxEgressRestrictedErrorDetails|UserProfileNotFoundErrorDetails|ExternalKeyInWorkspacePolicyErrorDetails|AlreadyMemberErrorDetails|CannotInviteEmailsWithUnverifiedDomainsErrorDetails|EmailDomainNotAllowedErrorDetails|InviteAlreadyExistsErrorDetails|OrgMemberLimitExceededErrorDetails|RBACGroupGrantsOwnerAccessErrorDetails|RBACGroupOwnerAccessUnconfirmedErrorDetails|CannotRemoveLastMemberErrorDetails|ConcurrentMembershipChangeErrorDetails|ExternalKeyValidationFailedErrorDetails|ExternalKeyValidationTimedOutErrorDetails|KeyProfileMismatchErrorDetails|WorkspacePolicyViolationErrorDetails|ExternalKeyChangedErrorDetails|WorkspaceMemberLimitExceededErrorDetails|OrganizationTypeNotSupportedErrorDetails|BetaEnvironmentCreateDisabledErrorDetails|BetaEnvironmentArchivedErrorDetails|BetaInvalidConfigTypeChangeErrorDetails|BetaEnvironmentUpdateDisabledErrorDetails|HeartbeatPreconditionFailedErrorDetails|BetaInvalidMetadataErrorDetails|CannotSignOutPrimaryOwnerErrorDetails|CannotSignOutSelfErrorDetails|BetaOrganizationNotEnrolledInBetaErrorDetails|CannotSignOutManagedMemberErrorDetails|CannotSignOutMembershipAdminErrorDetails|CannotSignOutOwnerErrorDetails|CannotSignOutPrivilegedMemberErrorDetails|SpendLimitsAdminAPIWritesNotEnabledErrorDetails|BetaUnsupportedCharsetErrorDetails|PluginNameTakenErrorDetails|SkillNameTakenErrorDetails|RegistrationPendingErrorDetails|ScanFailedErrorDetails|ScanPendingErrorDetails|SlackChannelSetUpSettingsRefusedErrorDetails|APIKeyScopeMissingErrorDetails|ClaudeTagWritesNotEnabledErrorDetails|ComplianceConfigurationRestrictedErrorDetails|OrganizationLevelScopedAPIKeyRequiredErrorDetails|BetaEnvironmentNotFoundErrorDetails|SlackChannelSetUpEnvironmentNotFoundErrorDetails|SlackChannelSetUpSettingsConflictErrorDetails
 * @phpstan-type ErrorDetailsShape = ErrorDetailsVariants|AvailableToolsLimitExceededErrorDetailsShape|ClaudeCodeKeyCreatorNotMemberErrorDetailsShape|ClaudeCodeVersionTooOldErrorDetailsShape|CMEKKeyDisabledErrorDetailsShape|CMEKKeyNetworkBlockedErrorDetailsShape|CompactionBlockAmbiguousErrorDetailsShape|CompactionBlockMisplacedErrorDetailsShape|CompactionContentMismatchErrorDetailsShape|CompactionIncompleteTurnErrorDetailsShape|CompactionNothingToSummarizeErrorDetailsShape|CompactionSignatureInvalidErrorDetailsShape|CompactionTooManyToolReferencesErrorDetailsShape|CompactionToolChangesMismatchErrorDetailsShape|OrganizationOnHoldErrorDetailsShape|RequestBodyEncodingInvalidErrorDetailsShape|RequestBodyEncodingUnsupportedErrorDetailsShape|ThreadAlreadyContinuedErrorDetailsShape|ThreadContinueInFlightErrorDetailsShape|ThreadFingerprintMismatchErrorDetailsShape|ThreadUnsupportedRequestErrorDetailsShape|ToolNameConflictErrorDetailsShape|ToolReferenceUnresolvedErrorDetailsShape|ThreadNotFoundErrorDetailsShape|SkillReadBlockedUndecryptableErrorDetailsShape|RequestBodyTooLargeAfterDecodingErrorDetailsShape|EnforcedSpendLimitReachedErrorDetailsShape|RampLimitExceededErrorDetailsShape|CMEKKeyUnreachableErrorDetailsShape|CompactionUnavailableErrorDetailsShape|StorageQuotaExceededErrorDetailsShape|FileNotDownloadableErrorDetailsShape|FileExpiredErrorDetailsShape|CMEKContextUnavailableErrorDetailsShape|OrgAPIKeyLimitExceededErrorDetailsShape|WorkspaceAPIKeyLimitExceededErrorDetailsShape|SandboxEgressRestrictedErrorDetailsShape|UserProfileNotFoundErrorDetailsShape|ExternalKeyInWorkspacePolicyErrorDetailsShape|AlreadyMemberErrorDetailsShape|CannotInviteEmailsWithUnverifiedDomainsErrorDetailsShape|EmailDomainNotAllowedErrorDetailsShape|InviteAlreadyExistsErrorDetailsShape|OrgMemberLimitExceededErrorDetailsShape|RBACGroupGrantsOwnerAccessErrorDetailsShape|RBACGroupOwnerAccessUnconfirmedErrorDetailsShape|CannotRemoveLastMemberErrorDetailsShape|ConcurrentMembershipChangeErrorDetailsShape|ExternalKeyValidationFailedErrorDetailsShape|ExternalKeyValidationTimedOutErrorDetailsShape|KeyProfileMismatchErrorDetailsShape|WorkspacePolicyViolationErrorDetailsShape|ExternalKeyChangedErrorDetailsShape|WorkspaceMemberLimitExceededErrorDetailsShape|OrganizationTypeNotSupportedErrorDetailsShape|BetaEnvironmentCreateDisabledErrorDetailsShape|BetaEnvironmentArchivedErrorDetailsShape|BetaInvalidConfigTypeChangeErrorDetailsShape|BetaEnvironmentUpdateDisabledErrorDetailsShape|HeartbeatPreconditionFailedErrorDetailsShape|BetaInvalidMetadataErrorDetailsShape|CannotSignOutPrimaryOwnerErrorDetailsShape|CannotSignOutSelfErrorDetailsShape|BetaOrganizationNotEnrolledInBetaErrorDetailsShape|CannotSignOutManagedMemberErrorDetailsShape|CannotSignOutMembershipAdminErrorDetailsShape|CannotSignOutOwnerErrorDetailsShape|CannotSignOutPrivilegedMemberErrorDetailsShape|SpendLimitsAdminAPIWritesNotEnabledErrorDetailsShape|BetaUnsupportedCharsetErrorDetailsShape|PluginNameTakenErrorDetailsShape|SkillNameTakenErrorDetailsShape|RegistrationPendingErrorDetailsShape|ScanFailedErrorDetailsShape|ScanPendingErrorDetailsShape|SlackChannelSetUpSettingsRefusedErrorDetailsShape|APIKeyScopeMissingErrorDetailsShape|ClaudeTagWritesNotEnabledErrorDetailsShape|ComplianceConfigurationRestrictedErrorDetailsShape|OrganizationLevelScopedAPIKeyRequiredErrorDetailsShape|BetaEnvironmentNotFoundErrorDetailsShape|SlackChannelSetUpEnvironmentNotFoundErrorDetailsShape|SlackChannelSetUpSettingsConflictErrorDetailsShape
 */
final class ErrorDetails implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'error_code';
    }

    public static function discriminatorProperty(): string
    {
        return 'errorCode';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            'available_tools_limit_exceeded' => AvailableToolsLimitExceededErrorDetails::class,
            'claude_code_key_creator_not_member' => ClaudeCodeKeyCreatorNotMemberErrorDetails::class,
            'claude_code_version_too_old' => ClaudeCodeVersionTooOldErrorDetails::class,
            'cmek_key_disabled' => CMEKKeyDisabledErrorDetails::class,
            'cmek_key_network_blocked' => CMEKKeyNetworkBlockedErrorDetails::class,
            'compaction_block_ambiguous' => CompactionBlockAmbiguousErrorDetails::class,
            'compaction_block_misplaced' => CompactionBlockMisplacedErrorDetails::class,
            'compaction_content_mismatch' => CompactionContentMismatchErrorDetails::class,
            'compaction_incomplete_turn' => CompactionIncompleteTurnErrorDetails::class,
            'compaction_nothing_to_summarize' => CompactionNothingToSummarizeErrorDetails::class,
            'compaction_signature_invalid' => CompactionSignatureInvalidErrorDetails::class,
            'compaction_too_many_tool_references' => CompactionTooManyToolReferencesErrorDetails::class,
            'compaction_tool_changes_mismatch' => CompactionToolChangesMismatchErrorDetails::class,
            'organization_on_hold' => OrganizationOnHoldErrorDetails::class,
            'request_body_encoding_invalid' => RequestBodyEncodingInvalidErrorDetails::class,
            'request_body_encoding_unsupported' => RequestBodyEncodingUnsupportedErrorDetails::class,
            'thread_already_continued' => ThreadAlreadyContinuedErrorDetails::class,
            'thread_continue_in_flight' => ThreadContinueInFlightErrorDetails::class,
            'thread_fingerprint_mismatch' => ThreadFingerprintMismatchErrorDetails::class,
            'thread_unsupported_request' => ThreadUnsupportedRequestErrorDetails::class,
            'tool_name_conflict' => ToolNameConflictErrorDetails::class,
            'tool_reference_unresolved' => ToolReferenceUnresolvedErrorDetails::class,
            'thread_not_found' => ThreadNotFoundErrorDetails::class,
            'skill_read_blocked_undecryptable' => SkillReadBlockedUndecryptableErrorDetails::class,
            'request_body_too_large_after_decoding' => RequestBodyTooLargeAfterDecodingErrorDetails::class,
            'enforced_spend_limit_reached' => EnforcedSpendLimitReachedErrorDetails::class,
            'ramp_limit_exceeded' => RampLimitExceededErrorDetails::class,
            'cmek_key_unreachable' => CMEKKeyUnreachableErrorDetails::class,
            'compaction_unavailable' => CompactionUnavailableErrorDetails::class,
            'storage_quota_exceeded' => StorageQuotaExceededErrorDetails::class,
            'file_not_downloadable' => FileNotDownloadableErrorDetails::class,
            'file_expired' => FileExpiredErrorDetails::class,
            'cmek_context_unavailable' => CMEKContextUnavailableErrorDetails::class,
            'org_api_key_limit_exceeded' => OrgAPIKeyLimitExceededErrorDetails::class,
            'workspace_api_key_limit_exceeded' => WorkspaceAPIKeyLimitExceededErrorDetails::class,
            'sandbox_egress_restricted' => SandboxEgressRestrictedErrorDetails::class,
            'user_profile_not_found' => UserProfileNotFoundErrorDetails::class,
            'external_key_in_workspace_policy' => ExternalKeyInWorkspacePolicyErrorDetails::class,
            'already_member' => AlreadyMemberErrorDetails::class,
            'cannot_invite_emails_with_unverified_domains' => CannotInviteEmailsWithUnverifiedDomainsErrorDetails::class,
            'email_domain_not_allowed' => EmailDomainNotAllowedErrorDetails::class,
            'invite_already_exists' => InviteAlreadyExistsErrorDetails::class,
            'org_member_limit_exceeded' => OrgMemberLimitExceededErrorDetails::class,
            'rbac_group_grants_owner_access' => RBACGroupGrantsOwnerAccessErrorDetails::class,
            'rbac_group_owner_access_unconfirmed' => RBACGroupOwnerAccessUnconfirmedErrorDetails::class,
            'cannot_remove_last_member' => CannotRemoveLastMemberErrorDetails::class,
            'concurrent_membership_change' => ConcurrentMembershipChangeErrorDetails::class,
            'external_key_validation_failed' => ExternalKeyValidationFailedErrorDetails::class,
            'external_key_validation_timed_out' => ExternalKeyValidationTimedOutErrorDetails::class,
            'key_profile_mismatch' => KeyProfileMismatchErrorDetails::class,
            'workspace_policy_violation' => WorkspacePolicyViolationErrorDetails::class,
            'external_key_changed' => ExternalKeyChangedErrorDetails::class,
            'workspace_member_limit_exceeded' => WorkspaceMemberLimitExceededErrorDetails::class,
            'organization_type_not_supported' => OrganizationTypeNotSupportedErrorDetails::class,
            'environment_create_disabled' => BetaEnvironmentCreateDisabledErrorDetails::class,
            'environment_archived' => BetaEnvironmentArchivedErrorDetails::class,
            'invalid_config_type_change' => BetaInvalidConfigTypeChangeErrorDetails::class,
            'environment_update_disabled' => BetaEnvironmentUpdateDisabledErrorDetails::class,
            'heartbeat_precondition_failed' => HeartbeatPreconditionFailedErrorDetails::class,
            'invalid_metadata' => BetaInvalidMetadataErrorDetails::class,
            'cannot_sign_out_primary_owner' => CannotSignOutPrimaryOwnerErrorDetails::class,
            'cannot_sign_out_self' => CannotSignOutSelfErrorDetails::class,
            'organization_not_enrolled_in_beta' => BetaOrganizationNotEnrolledInBetaErrorDetails::class,
            'cannot_sign_out_managed_member' => CannotSignOutManagedMemberErrorDetails::class,
            'cannot_sign_out_membership_admin' => CannotSignOutMembershipAdminErrorDetails::class,
            'cannot_sign_out_owner' => CannotSignOutOwnerErrorDetails::class,
            'cannot_sign_out_privileged_member' => CannotSignOutPrivilegedMemberErrorDetails::class,
            'spend_limits_admin_api_writes_not_enabled' => SpendLimitsAdminAPIWritesNotEnabledErrorDetails::class,
            'unsupported_charset' => BetaUnsupportedCharsetErrorDetails::class,
            'plugin_name_taken' => PluginNameTakenErrorDetails::class,
            'skill_name_taken' => SkillNameTakenErrorDetails::class,
            'registration_pending' => RegistrationPendingErrorDetails::class,
            'scan_failed' => ScanFailedErrorDetails::class,
            'scan_pending' => ScanPendingErrorDetails::class,
            'slack_channel_set_up_settings_refused' => SlackChannelSetUpSettingsRefusedErrorDetails::class,
            'api_key_scope_missing' => APIKeyScopeMissingErrorDetails::class,
            'claude_tag_writes_not_enabled' => ClaudeTagWritesNotEnabledErrorDetails::class,
            'compliance_configuration_restricted' => ComplianceConfigurationRestrictedErrorDetails::class,
            'organization_level_scoped_api_key_required' => OrganizationLevelScopedAPIKeyRequiredErrorDetails::class,
            'environment_not_found' => BetaEnvironmentNotFoundErrorDetails::class,
            'slack_channel_set_up_environment_not_found' => SlackChannelSetUpEnvironmentNotFoundErrorDetails::class,
            'slack_channel_set_up_settings_conflict' => SlackChannelSetUpSettingsConflictErrorDetails::class,
        ];
    }
}
