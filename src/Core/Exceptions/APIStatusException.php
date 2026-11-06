<?php

namespace Anthropic\Core\Exceptions;

use Anthropic\Beta\BetaOrganizationNotEnrolledInBetaException;
use Anthropic\Beta\BetaUnsupportedCharsetException;
use Anthropic\Beta\Environments\BetaEnvironmentArchivedException;
use Anthropic\Beta\Environments\BetaEnvironmentCreateDisabledException;
use Anthropic\Beta\Environments\BetaEnvironmentNotFoundException;
use Anthropic\Beta\Environments\BetaEnvironmentUpdateDisabledException;
use Anthropic\Beta\Environments\BetaInvalidConfigTypeChangeException;
use Anthropic\Beta\Environments\BetaInvalidMetadataException;
use Anthropic\Beta\Environments\Work\HeartbeatPreconditionFailedException;
use Anthropic\Beta\Organization\ClaudeTag\APIKeyScopeMissingException;
use Anthropic\Beta\Organization\ClaudeTag\ClaudeTagWritesNotEnabledException;
use Anthropic\Beta\Organization\ClaudeTag\ComplianceConfigurationRestrictedException;
use Anthropic\Beta\Organization\ClaudeTag\OrganizationLevelScopedAPIKeyRequiredException;
use Anthropic\Beta\Organization\ClaudeTag\SlackChannelSetUpEnvironmentNotFoundException;
use Anthropic\Beta\Organization\ClaudeTag\SlackChannelSetUpSettingsConflictException;
use Anthropic\Beta\Organization\ClaudeTag\SlackChannelSetUpSettingsRefusedException;
use Anthropic\Beta\Organization\Plugins\PluginNameTakenException;
use Anthropic\Beta\Organization\Plugins\RegistrationPendingException;
use Anthropic\Beta\Organization\Plugins\ScanFailedException;
use Anthropic\Beta\Organization\Plugins\ScanPendingException;
use Anthropic\Beta\Organization\Plugins\SkillNameTakenException;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitsAdminAPIWritesNotEnabledException;
use Anthropic\Beta\Organization\Users\CannotSignOutManagedMemberException;
use Anthropic\Beta\Organization\Users\CannotSignOutMembershipAdminException;
use Anthropic\Beta\Organization\Users\CannotSignOutOwnerException;
use Anthropic\Beta\Organization\Users\CannotSignOutPrimaryOwnerException;
use Anthropic\Beta\Organization\Users\CannotSignOutPrivilegedMemberException;
use Anthropic\Beta\Organization\Users\CannotSignOutSelfException;
use Anthropic\ClaudeCodeKeyCreatorNotMemberException;
use Anthropic\ClaudeCodeVersionTooOldException;
use Anthropic\CMEKContextUnavailableException;
use Anthropic\CMEKKeyDisabledException;
use Anthropic\CMEKKeyNetworkBlockedException;
use Anthropic\CMEKKeyUnreachableException;
use Anthropic\Core\Conversion;
use Anthropic\Core\Util;
use Anthropic\EnforcedSpendLimitReachedException;
use Anthropic\ErrorDetails;
use Anthropic\ErrorType;
use Anthropic\Files\FileExpiredException;
use Anthropic\Files\FileNotDownloadableException;
use Anthropic\Files\StorageQuotaExceededException;
use Anthropic\Messages\AvailableToolsLimitExceededException;
use Anthropic\Messages\CompactionBlockAmbiguousException;
use Anthropic\Messages\CompactionBlockMisplacedException;
use Anthropic\Messages\CompactionContentMismatchException;
use Anthropic\Messages\CompactionIncompleteTurnException;
use Anthropic\Messages\CompactionNothingToSummarizeException;
use Anthropic\Messages\CompactionSignatureInvalidException;
use Anthropic\Messages\CompactionToolChangesMismatchException;
use Anthropic\Messages\CompactionTooManyToolReferencesException;
use Anthropic\Messages\CompactionUnavailableException;
use Anthropic\Messages\ThreadAlreadyContinuedException;
use Anthropic\Messages\ThreadContinueInFlightException;
use Anthropic\Messages\ThreadFingerprintMismatchException;
use Anthropic\Messages\ThreadNotFoundException;
use Anthropic\Messages\ThreadUnsupportedRequestException;
use Anthropic\Messages\ToolNameConflictException;
use Anthropic\Messages\ToolReferenceUnresolvedException;
use Anthropic\Organization\APIKeys\OrgAPIKeyLimitExceededException;
use Anthropic\Organization\APIKeys\WorkspaceAPIKeyLimitExceededException;
use Anthropic\Organization\ConcurrentMembershipChangeException;
use Anthropic\Organization\ExternalKeys\ExternalKeyChangedException;
use Anthropic\Organization\ExternalKeys\ExternalKeyInWorkspacePolicyException;
use Anthropic\Organization\ExternalKeys\ExternalKeyValidationFailedException;
use Anthropic\Organization\ExternalKeys\ExternalKeyValidationTimedOutException;
use Anthropic\Organization\Invites\AlreadyMemberException;
use Anthropic\Organization\Invites\CannotInviteEmailsWithUnverifiedDomainsException;
use Anthropic\Organization\Invites\EmailDomainNotAllowedException;
use Anthropic\Organization\Invites\InviteAlreadyExistsException;
use Anthropic\Organization\OrgMemberLimitExceededException;
use Anthropic\Organization\RBACGroups\RBACGroupGrantsOwnerAccessException;
use Anthropic\Organization\RBACGroups\RBACGroupOwnerAccessUnconfirmedException;
use Anthropic\Organization\Users\CannotRemoveLastMemberException;
use Anthropic\Organization\Workspaces\KeyProfileMismatchException;
use Anthropic\Organization\Workspaces\WorkspaceMemberLimitExceededException;
use Anthropic\Organization\Workspaces\WorkspacePolicyViolationException;
use Anthropic\OrganizationOnHoldException;
use Anthropic\OrganizationTypeNotSupportedException;
use Anthropic\RampLimitExceededException;
use Anthropic\RequestBodyEncodingInvalidException;
use Anthropic\RequestBodyEncodingUnsupportedException;
use Anthropic\RequestBodyTooLargeAfterDecodingException;
use Anthropic\SandboxEgressRestrictedException;
use Anthropic\Skills\SkillReadBlockedUndecryptableException;
use Anthropic\UserProfiles\UserProfileNotFoundException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @phpstan-import-type ErrorDetailsVariants from \Anthropic\ErrorDetails
 */
class APIStatusException extends APIException
{
    /** @var string */
    protected const DESC = 'Anthropic API Status Error';

    private const ERROR_CLASSES = [
        400 => BadRequestException::class,
        401 => AuthenticationException::class,
        403 => PermissionDeniedException::class,
        404 => NotFoundException::class,
        408 => RequestTimeoutException::class,
        409 => ConflictException::class,
        412 => PreconditionFailedException::class,
        413 => ContentTooLargeException::class,
        422 => UnprocessableEntityException::class,
        429 => RateLimitException::class,
        431 => RequestHeaderFieldsTooLargeException::class,
        499 => ClientClosedRequestException::class,
        501 => NotImplementedException::class,
        503 => ServiceUnavailableException::class,
        504 => GatewayTimeoutException::class,
        529 => OverloadedException::class,
        '400 already_member' => AlreadyMemberException::class,
        '400 available_tools_limit_exceeded' => AvailableToolsLimitExceededException::class,
        '400 cannot_invite_emails_with_unverified_domains' => CannotInviteEmailsWithUnverifiedDomainsException::class,
        '400 cannot_remove_last_member' => CannotRemoveLastMemberException::class,
        '400 cannot_sign_out_primary_owner' => CannotSignOutPrimaryOwnerException::class,
        '400 cannot_sign_out_self' => CannotSignOutSelfException::class,
        '400 claude_code_key_creator_not_member' => ClaudeCodeKeyCreatorNotMemberException::class,
        '400 claude_code_version_too_old' => ClaudeCodeVersionTooOldException::class,
        '400 cmek_key_disabled' => CMEKKeyDisabledException::class,
        '400 cmek_key_network_blocked' => CMEKKeyNetworkBlockedException::class,
        '400 compaction_block_ambiguous' => CompactionBlockAmbiguousException::class,
        '400 compaction_block_misplaced' => CompactionBlockMisplacedException::class,
        '400 compaction_content_mismatch' => CompactionContentMismatchException::class,
        '400 compaction_incomplete_turn' => CompactionIncompleteTurnException::class,
        '400 compaction_nothing_to_summarize' => CompactionNothingToSummarizeException::class,
        '400 compaction_signature_invalid' => CompactionSignatureInvalidException::class,
        '400 compaction_too_many_tool_references' => CompactionTooManyToolReferencesException::class,
        '400 compaction_tool_changes_mismatch' => CompactionToolChangesMismatchException::class,
        '400 email_domain_not_allowed' => EmailDomainNotAllowedException::class,
        '400 environment_archived' => BetaEnvironmentArchivedException::class,
        '400 external_key_in_workspace_policy' => ExternalKeyInWorkspacePolicyException::class,
        '400 external_key_validation_failed' => ExternalKeyValidationFailedException::class,
        '400 external_key_validation_timed_out' => ExternalKeyValidationTimedOutException::class,
        '400 file_not_downloadable' => FileNotDownloadableException::class,
        '400 invalid_config_type_change' => BetaInvalidConfigTypeChangeException::class,
        '400 invalid_metadata' => BetaInvalidMetadataException::class,
        '400 invite_already_exists' => InviteAlreadyExistsException::class,
        '400 key_profile_mismatch' => KeyProfileMismatchException::class,
        '400 org_api_key_limit_exceeded' => OrgAPIKeyLimitExceededException::class,
        '400 org_member_limit_exceeded' => OrgMemberLimitExceededException::class,
        '400 organization_not_enrolled_in_beta' => BetaOrganizationNotEnrolledInBetaException::class,
        '400 organization_on_hold' => OrganizationOnHoldException::class,
        '400 organization_type_not_supported' => OrganizationTypeNotSupportedException::class,
        '400 rbac_group_grants_owner_access' => RBACGroupGrantsOwnerAccessException::class,
        '400 rbac_group_owner_access_unconfirmed' => RBACGroupOwnerAccessUnconfirmedException::class,
        '400 request_body_encoding_invalid' => RequestBodyEncodingInvalidException::class,
        '400 request_body_encoding_unsupported' => RequestBodyEncodingUnsupportedException::class,
        '400 scan_failed' => ScanFailedException::class,
        '400 slack_channel_set_up_settings_refused' => SlackChannelSetUpSettingsRefusedException::class,
        '400 storage_quota_exceeded' => StorageQuotaExceededException::class,
        '400 thread_already_continued' => ThreadAlreadyContinuedException::class,
        '400 thread_continue_in_flight' => ThreadContinueInFlightException::class,
        '400 thread_fingerprint_mismatch' => ThreadFingerprintMismatchException::class,
        '400 thread_unsupported_request' => ThreadUnsupportedRequestException::class,
        '400 tool_name_conflict' => ToolNameConflictException::class,
        '400 tool_reference_unresolved' => ToolReferenceUnresolvedException::class,
        '400 unsupported_charset' => BetaUnsupportedCharsetException::class,
        '400 user_profile_not_found' => UserProfileNotFoundException::class,
        '400 workspace_api_key_limit_exceeded' => WorkspaceAPIKeyLimitExceededException::class,
        '400 workspace_member_limit_exceeded' => WorkspaceMemberLimitExceededException::class,
        '400 workspace_policy_violation' => WorkspacePolicyViolationException::class,
        '403 api_key_scope_missing' => APIKeyScopeMissingException::class,
        '403 cannot_sign_out_managed_member' => CannotSignOutManagedMemberException::class,
        '403 cannot_sign_out_membership_admin' => CannotSignOutMembershipAdminException::class,
        '403 cannot_sign_out_owner' => CannotSignOutOwnerException::class,
        '403 cannot_sign_out_privileged_member' => CannotSignOutPrivilegedMemberException::class,
        '403 claude_tag_writes_not_enabled' => ClaudeTagWritesNotEnabledException::class,
        '403 compliance_configuration_restricted' => ComplianceConfigurationRestrictedException::class,
        '403 environment_create_disabled' => BetaEnvironmentCreateDisabledException::class,
        '403 environment_update_disabled' => BetaEnvironmentUpdateDisabledException::class,
        '403 organization_level_scoped_api_key_required' => OrganizationLevelScopedAPIKeyRequiredException::class,
        '403 sandbox_egress_restricted' => SandboxEgressRestrictedException::class,
        '403 spend_limits_admin_api_writes_not_enabled' => SpendLimitsAdminAPIWritesNotEnabledException::class,
        '404 environment_not_found' => BetaEnvironmentNotFoundException::class,
        '404 file_expired' => FileExpiredException::class,
        '404 slack_channel_set_up_environment_not_found' => SlackChannelSetUpEnvironmentNotFoundException::class,
        '404 thread_not_found' => ThreadNotFoundException::class,
        '409 concurrent_membership_change' => ConcurrentMembershipChangeException::class,
        '409 external_key_changed' => ExternalKeyChangedException::class,
        '409 plugin_name_taken' => PluginNameTakenException::class,
        '409 scan_pending' => ScanPendingException::class,
        '409 skill_name_taken' => SkillNameTakenException::class,
        '409 skill_read_blocked_undecryptable' => SkillReadBlockedUndecryptableException::class,
        '409 slack_channel_set_up_settings_conflict' => SlackChannelSetUpSettingsConflictException::class,
        '412 heartbeat_precondition_failed' => HeartbeatPreconditionFailedException::class,
        '413 request_body_too_large_after_decoding' => RequestBodyTooLargeAfterDecodingException::class,
        '429 enforced_spend_limit_reached' => EnforcedSpendLimitReachedException::class,
        '429 ramp_limit_exceeded' => RampLimitExceededException::class,
        '503 cmek_context_unavailable' => CMEKContextUnavailableException::class,
        '503 cmek_key_unreachable' => CMEKKeyUnreachableException::class,
        '503 registration_pending' => RegistrationPendingException::class,
        '529 compaction_unavailable' => CompactionUnavailableException::class,
    ];

    public ?int $status;

    /** @deprecated use `getType()` instead */
    public readonly ?ErrorType $type;

    public function __construct(
        public RequestInterface $request,
        ResponseInterface $response,
        ?\Throwable $previous = null,
        string $message = '',
        ?ErrorType $type = null,
        mixed $body = null,
    ) {
        $this->response = $response;
        $this->status = $response->getStatusCode();
        $this->body = $body ?? self::decodeBody($response);

        $summary = Util::prettyEncodeJson(['status' => $this->status, 'body' => $this->body]);

        $this->type = $type ?? ErrorType::tryFrom($this->getType() ?? '');

        if ('' != $message) {
            $summary = $message.PHP_EOL.$summary;
        }

        parent::__construct(request: $request, message: $summary, previous: $previous);
    }

    public static function from(
        RequestInterface $request,
        ResponseInterface $response,
        string $message = '',
        ?ErrorType $type = null,
        mixed $body = null,
    ): self {
        $status = $response->getStatusCode();
        $body ??= self::decodeBody($response);
        $errorCode = Util::dig(Util::dig(Util::dig($body, 'error'), 'details'), 'error_code');

        $cls = self::ERROR_CLASSES[is_string($errorCode) ? "{$status} {$errorCode}" : $status]
            ?? self::ERROR_CLASSES[$status]
            ?? ($status >= 500 ? InternalServerException::class : APIStatusException::class);

        return new $cls(
            request: $request,
            response: $response,
            message: $message,
            type: $type,
            body: $body
        );
    }

    /**
     * A human-readable explanation of the error. Its wording can change, so don't match on it.
     *
     * `error.message` from the response body, if present.
     */
    public function getAPIMessage(): ?string
    {
        try {
            // @phpstan-ignore return.type
            return Conversion::coerce(
                'string',
                value: Util::dig(Util::dig($this->body, 'error'), 'message')
            );
        } catch (\TypeError) {
            return null;
        }
    }

    /**
     * The broad category of the error.
     *
     * `error.type` from the response body, if present.
     *
     * @return value-of<ErrorType>|null
     */
    public function getType(): ?string
    {
        try {
            // @phpstan-ignore return.type
            return Conversion::coerce(
                ErrorType::class,
                value: Util::dig(Util::dig($this->body, 'error'), 'type'),
            );
        } catch (\TypeError) {
            return null;
        }
    }

    /**
     * A stable code that names the cause.
     *
     * `error.details.error_code` from the response body, if present and a string.
     */
    public function getErrorCode(): ?string
    {
        $errorCode = Util::dig(Util::dig(Util::dig($this->body, 'error'), 'details'), 'error_code');

        return is_string($errorCode) ? $errorCode : null;
    }

    /**
     * Machine-readable detail about the cause of the error. `error_code` names the cause; branch on it rather than on `message`. Absent when the error has no code. Treat an unrecognized `error_code` as the bare `type`.
     *
     * `error.details` from the response body, if present.
     *
     * @return ErrorDetailsVariants|null
     */
    public function getDetails(): mixed
    {
        // @phpstan-ignore return.type
        return Conversion::coerce(
            ErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );
    }

    private static function decodeBody(ResponseInterface $response): mixed
    {
        $body = (string) $response->getBody();

        try {
            return Util::decodeJson($body);
        } catch (\JsonException) {
            return '' == $body ? null : $body;
        }
    }
}
