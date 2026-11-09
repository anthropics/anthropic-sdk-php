<?php

declare(strict_types=1);

namespace Anthropic\ErrorDetails;

enum ErrorCode: string
{
    case AVAILABLE_TOOLS_LIMIT_EXCEEDED = 'available_tools_limit_exceeded';

    case CLAUDE_CODE_KEY_CREATOR_NOT_MEMBER = 'claude_code_key_creator_not_member';

    case CLAUDE_CODE_VERSION_TOO_OLD = 'claude_code_version_too_old';

    case CMEK_KEY_DISABLED = 'cmek_key_disabled';

    case CMEK_KEY_NETWORK_BLOCKED = 'cmek_key_network_blocked';

    case COMPACTION_BLOCK_AMBIGUOUS = 'compaction_block_ambiguous';

    case COMPACTION_BLOCK_MISPLACED = 'compaction_block_misplaced';

    case COMPACTION_CONTENT_MISMATCH = 'compaction_content_mismatch';

    case COMPACTION_INCOMPLETE_TURN = 'compaction_incomplete_turn';

    case COMPACTION_NOTHING_TO_SUMMARIZE = 'compaction_nothing_to_summarize';

    case COMPACTION_SIGNATURE_INVALID = 'compaction_signature_invalid';

    case COMPACTION_TOO_MANY_TOOL_REFERENCES = 'compaction_too_many_tool_references';

    case COMPACTION_TOOL_CHANGES_MISMATCH = 'compaction_tool_changes_mismatch';

    case ORGANIZATION_ON_HOLD = 'organization_on_hold';

    case REQUEST_BODY_ENCODING_INVALID = 'request_body_encoding_invalid';

    case REQUEST_BODY_ENCODING_UNSUPPORTED = 'request_body_encoding_unsupported';

    case THREAD_ALREADY_CONTINUED = 'thread_already_continued';

    case THREAD_CONTINUE_IN_FLIGHT = 'thread_continue_in_flight';

    case THREAD_FINGERPRINT_MISMATCH = 'thread_fingerprint_mismatch';

    case THREAD_UNSUPPORTED_REQUEST = 'thread_unsupported_request';

    case TOOL_NAME_CONFLICT = 'tool_name_conflict';

    case TOOL_REFERENCE_UNRESOLVED = 'tool_reference_unresolved';

    case THREAD_NOT_FOUND = 'thread_not_found';

    case SKILL_READ_BLOCKED_UNDECRYPTABLE = 'skill_read_blocked_undecryptable';

    case REQUEST_BODY_TOO_LARGE_AFTER_DECODING = 'request_body_too_large_after_decoding';

    case ENFORCED_SPEND_LIMIT_REACHED = 'enforced_spend_limit_reached';

    case RAMP_LIMIT_EXCEEDED = 'ramp_limit_exceeded';

    case CMEK_KEY_UNREACHABLE = 'cmek_key_unreachable';

    case COMPACTION_UNAVAILABLE = 'compaction_unavailable';

    case STORAGE_QUOTA_EXCEEDED = 'storage_quota_exceeded';

    case FILE_NOT_DOWNLOADABLE = 'file_not_downloadable';

    case FILE_EXPIRED = 'file_expired';

    case CMEK_CONTEXT_UNAVAILABLE = 'cmek_context_unavailable';

    case ORG_API_KEY_LIMIT_EXCEEDED = 'org_api_key_limit_exceeded';

    case WORKSPACE_API_KEY_LIMIT_EXCEEDED = 'workspace_api_key_limit_exceeded';

    case SANDBOX_EGRESS_RESTRICTED = 'sandbox_egress_restricted';

    case USER_PROFILE_NOT_FOUND = 'user_profile_not_found';

    case EXTERNAL_KEY_IN_WORKSPACE_POLICY = 'external_key_in_workspace_policy';

    case ALREADY_MEMBER = 'already_member';

    case CANNOT_INVITE_EMAILS_WITH_UNVERIFIED_DOMAINS = 'cannot_invite_emails_with_unverified_domains';

    case EMAIL_DOMAIN_NOT_ALLOWED = 'email_domain_not_allowed';

    case INVITE_ALREADY_EXISTS = 'invite_already_exists';

    case ORG_MEMBER_LIMIT_EXCEEDED = 'org_member_limit_exceeded';

    case RBAC_GROUP_GRANTS_OWNER_ACCESS = 'rbac_group_grants_owner_access';

    case RBAC_GROUP_OWNER_ACCESS_UNCONFIRMED = 'rbac_group_owner_access_unconfirmed';

    case CANNOT_REMOVE_LAST_MEMBER = 'cannot_remove_last_member';

    case CONCURRENT_MEMBERSHIP_CHANGE = 'concurrent_membership_change';

    case EXTERNAL_KEY_VALIDATION_FAILED = 'external_key_validation_failed';

    case EXTERNAL_KEY_VALIDATION_TIMED_OUT = 'external_key_validation_timed_out';

    case KEY_PROFILE_MISMATCH = 'key_profile_mismatch';

    case WORKSPACE_POLICY_VIOLATION = 'workspace_policy_violation';

    case EXTERNAL_KEY_CHANGED = 'external_key_changed';

    case WORKSPACE_MEMBER_LIMIT_EXCEEDED = 'workspace_member_limit_exceeded';

    case ORGANIZATION_TYPE_NOT_SUPPORTED = 'organization_type_not_supported';

    case ENVIRONMENT_CREATE_DISABLED = 'environment_create_disabled';

    case ENVIRONMENT_ARCHIVED = 'environment_archived';

    case INVALID_CONFIG_TYPE_CHANGE = 'invalid_config_type_change';

    case ENVIRONMENT_UPDATE_DISABLED = 'environment_update_disabled';

    case HEARTBEAT_PRECONDITION_FAILED = 'heartbeat_precondition_failed';

    case INVALID_METADATA = 'invalid_metadata';

    case CANNOT_SIGN_OUT_PRIMARY_OWNER = 'cannot_sign_out_primary_owner';

    case CANNOT_SIGN_OUT_SELF = 'cannot_sign_out_self';

    case ORGANIZATION_NOT_ENROLLED_IN_BETA = 'organization_not_enrolled_in_beta';

    case CANNOT_SIGN_OUT_MANAGED_MEMBER = 'cannot_sign_out_managed_member';

    case CANNOT_SIGN_OUT_MEMBERSHIP_ADMIN = 'cannot_sign_out_membership_admin';

    case CANNOT_SIGN_OUT_OWNER = 'cannot_sign_out_owner';

    case CANNOT_SIGN_OUT_PRIVILEGED_MEMBER = 'cannot_sign_out_privileged_member';

    case SPEND_LIMITS_ADMIN_API_WRITES_NOT_ENABLED = 'spend_limits_admin_api_writes_not_enabled';

    case UNSUPPORTED_CHARSET = 'unsupported_charset';

    case PLUGIN_NAME_TAKEN = 'plugin_name_taken';

    case SKILL_NAME_TAKEN = 'skill_name_taken';

    case REGISTRATION_PENDING = 'registration_pending';

    case SCAN_FAILED = 'scan_failed';

    case SCAN_PENDING = 'scan_pending';

    case SLACK_CHANNEL_SET_UP_SETTINGS_REFUSED = 'slack_channel_set_up_settings_refused';

    case API_KEY_SCOPE_MISSING = 'api_key_scope_missing';

    case CLAUDE_TAG_WRITES_NOT_ENABLED = 'claude_tag_writes_not_enabled';

    case COMPLIANCE_CONFIGURATION_RESTRICTED = 'compliance_configuration_restricted';

    case ORGANIZATION_LEVEL_SCOPED_API_KEY_REQUIRED = 'organization_level_scoped_api_key_required';

    case ENVIRONMENT_NOT_FOUND = 'environment_not_found';

    case SLACK_CHANNEL_SET_UP_ENVIRONMENT_NOT_FOUND = 'slack_channel_set_up_environment_not_found';

    case SLACK_CHANNEL_SET_UP_SETTINGS_CONFLICT = 'slack_channel_set_up_settings_conflict';
}
