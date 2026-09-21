<?php

declare(strict_types=1);

namespace Anthropic\Beta\DeploymentRuns\BetaManagedAgentsDeploymentRun;

use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsAgentArchivedRunError;
use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsDeploymentRun\Error\Type;
use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsEnvironmentArchivedRunError;
use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsEnvironmentNotFoundRunError;
use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsFileNotFoundRunError;
use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsMCPEgressBlockedRunError;
use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsMemoryStoreArchivedRunError;
use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsOrganizationDisabledRunError;
use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsSelfHostedResourcesUnsupportedRunError;
use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsSessionCreationRejectedRunError;
use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsSessionRateLimitedRunError;
use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsSessionResourceNotFoundRunError;
use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsSkillNotFoundRunError;
use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsUnknownRunError;
use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsVaultArchivedRunError;
use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsVaultNotFoundRunError;
use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsWorkspaceArchivedRunError;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Why the run failed to create a session. The type identifies the failure; message is human-readable detail.
 *
 * @phpstan-import-type BetaManagedAgentsEnvironmentArchivedRunErrorShape from \Anthropic\Beta\DeploymentRuns\BetaManagedAgentsEnvironmentArchivedRunError
 * @phpstan-import-type BetaManagedAgentsAgentArchivedRunErrorShape from \Anthropic\Beta\DeploymentRuns\BetaManagedAgentsAgentArchivedRunError
 * @phpstan-import-type BetaManagedAgentsEnvironmentNotFoundRunErrorShape from \Anthropic\Beta\DeploymentRuns\BetaManagedAgentsEnvironmentNotFoundRunError
 * @phpstan-import-type BetaManagedAgentsVaultNotFoundRunErrorShape from \Anthropic\Beta\DeploymentRuns\BetaManagedAgentsVaultNotFoundRunError
 * @phpstan-import-type BetaManagedAgentsVaultArchivedRunErrorShape from \Anthropic\Beta\DeploymentRuns\BetaManagedAgentsVaultArchivedRunError
 * @phpstan-import-type BetaManagedAgentsFileNotFoundRunErrorShape from \Anthropic\Beta\DeploymentRuns\BetaManagedAgentsFileNotFoundRunError
 * @phpstan-import-type BetaManagedAgentsMemoryStoreArchivedRunErrorShape from \Anthropic\Beta\DeploymentRuns\BetaManagedAgentsMemoryStoreArchivedRunError
 * @phpstan-import-type BetaManagedAgentsSkillNotFoundRunErrorShape from \Anthropic\Beta\DeploymentRuns\BetaManagedAgentsSkillNotFoundRunError
 * @phpstan-import-type BetaManagedAgentsSessionResourceNotFoundRunErrorShape from \Anthropic\Beta\DeploymentRuns\BetaManagedAgentsSessionResourceNotFoundRunError
 * @phpstan-import-type BetaManagedAgentsWorkspaceArchivedRunErrorShape from \Anthropic\Beta\DeploymentRuns\BetaManagedAgentsWorkspaceArchivedRunError
 * @phpstan-import-type BetaManagedAgentsOrganizationDisabledRunErrorShape from \Anthropic\Beta\DeploymentRuns\BetaManagedAgentsOrganizationDisabledRunError
 * @phpstan-import-type BetaManagedAgentsSessionRateLimitedRunErrorShape from \Anthropic\Beta\DeploymentRuns\BetaManagedAgentsSessionRateLimitedRunError
 * @phpstan-import-type BetaManagedAgentsSessionCreationRejectedRunErrorShape from \Anthropic\Beta\DeploymentRuns\BetaManagedAgentsSessionCreationRejectedRunError
 * @phpstan-import-type BetaManagedAgentsUnknownRunErrorShape from \Anthropic\Beta\DeploymentRuns\BetaManagedAgentsUnknownRunError
 * @phpstan-import-type BetaManagedAgentsSelfHostedResourcesUnsupportedRunErrorShape from \Anthropic\Beta\DeploymentRuns\BetaManagedAgentsSelfHostedResourcesUnsupportedRunError
 * @phpstan-import-type BetaManagedAgentsMCPEgressBlockedRunErrorShape from \Anthropic\Beta\DeploymentRuns\BetaManagedAgentsMCPEgressBlockedRunError
 *
 * @phpstan-type ErrorVariants = BetaManagedAgentsEnvironmentArchivedRunError|BetaManagedAgentsAgentArchivedRunError|BetaManagedAgentsEnvironmentNotFoundRunError|BetaManagedAgentsVaultNotFoundRunError|BetaManagedAgentsVaultArchivedRunError|BetaManagedAgentsFileNotFoundRunError|BetaManagedAgentsMemoryStoreArchivedRunError|BetaManagedAgentsSkillNotFoundRunError|BetaManagedAgentsSessionResourceNotFoundRunError|BetaManagedAgentsWorkspaceArchivedRunError|BetaManagedAgentsOrganizationDisabledRunError|BetaManagedAgentsSessionRateLimitedRunError|BetaManagedAgentsSessionCreationRejectedRunError|BetaManagedAgentsUnknownRunError|BetaManagedAgentsSelfHostedResourcesUnsupportedRunError|BetaManagedAgentsMCPEgressBlockedRunError
 * @phpstan-type ErrorShape = ErrorVariants|BetaManagedAgentsEnvironmentArchivedRunErrorShape|BetaManagedAgentsAgentArchivedRunErrorShape|BetaManagedAgentsEnvironmentNotFoundRunErrorShape|BetaManagedAgentsVaultNotFoundRunErrorShape|BetaManagedAgentsVaultArchivedRunErrorShape|BetaManagedAgentsFileNotFoundRunErrorShape|BetaManagedAgentsMemoryStoreArchivedRunErrorShape|BetaManagedAgentsSkillNotFoundRunErrorShape|BetaManagedAgentsSessionResourceNotFoundRunErrorShape|BetaManagedAgentsWorkspaceArchivedRunErrorShape|BetaManagedAgentsOrganizationDisabledRunErrorShape|BetaManagedAgentsSessionRateLimitedRunErrorShape|BetaManagedAgentsSessionCreationRejectedRunErrorShape|BetaManagedAgentsUnknownRunErrorShape|BetaManagedAgentsSelfHostedResourcesUnsupportedRunErrorShape|BetaManagedAgentsMCPEgressBlockedRunErrorShape
 */
final class Error implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            'environment_archived_error' => BetaManagedAgentsEnvironmentArchivedRunError::class,
            'agent_archived_error' => BetaManagedAgentsAgentArchivedRunError::class,
            'environment_not_found_error' => BetaManagedAgentsEnvironmentNotFoundRunError::class,
            'vault_not_found_error' => BetaManagedAgentsVaultNotFoundRunError::class,
            'vault_archived_error' => BetaManagedAgentsVaultArchivedRunError::class,
            'file_not_found_error' => BetaManagedAgentsFileNotFoundRunError::class,
            'memory_store_archived_error' => BetaManagedAgentsMemoryStoreArchivedRunError::class,
            'skill_not_found_error' => BetaManagedAgentsSkillNotFoundRunError::class,
            'session_resource_not_found_error' => BetaManagedAgentsSessionResourceNotFoundRunError::class,
            'workspace_archived_error' => BetaManagedAgentsWorkspaceArchivedRunError::class,
            'organization_disabled_error' => BetaManagedAgentsOrganizationDisabledRunError::class,
            'session_rate_limited_error' => BetaManagedAgentsSessionRateLimitedRunError::class,
            'session_creation_rejected_error' => BetaManagedAgentsSessionCreationRejectedRunError::class,
            'unknown_error' => BetaManagedAgentsUnknownRunError::class,
            'self_hosted_resources_unsupported_error' => BetaManagedAgentsSelfHostedResourcesUnsupportedRunError::class,
            'mcp_egress_blocked_error' => BetaManagedAgentsMCPEgressBlockedRunError::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::ENVIRONMENT_ARCHIVED_ERROR|'environment_archived_error' ? BetaManagedAgentsEnvironmentArchivedRunError : ($type is Type::AGENT_ARCHIVED_ERROR|'agent_archived_error' ? BetaManagedAgentsAgentArchivedRunError : ($type is Type::ENVIRONMENT_NOT_FOUND_ERROR|'environment_not_found_error' ? BetaManagedAgentsEnvironmentNotFoundRunError : ($type is Type::VAULT_NOT_FOUND_ERROR|'vault_not_found_error' ? BetaManagedAgentsVaultNotFoundRunError : ($type is Type::VAULT_ARCHIVED_ERROR|'vault_archived_error' ? BetaManagedAgentsVaultArchivedRunError : ($type is Type::FILE_NOT_FOUND_ERROR|'file_not_found_error' ? BetaManagedAgentsFileNotFoundRunError : ($type is Type::MEMORY_STORE_ARCHIVED_ERROR|'memory_store_archived_error' ? BetaManagedAgentsMemoryStoreArchivedRunError : ($type is Type::SKILL_NOT_FOUND_ERROR|'skill_not_found_error' ? BetaManagedAgentsSkillNotFoundRunError : ($type is Type::SESSION_RESOURCE_NOT_FOUND_ERROR|'session_resource_not_found_error' ? BetaManagedAgentsSessionResourceNotFoundRunError : ($type is Type::WORKSPACE_ARCHIVED_ERROR|'workspace_archived_error' ? BetaManagedAgentsWorkspaceArchivedRunError : ($type is Type::ORGANIZATION_DISABLED_ERROR|'organization_disabled_error' ? BetaManagedAgentsOrganizationDisabledRunError : ($type is Type::SESSION_RATE_LIMITED_ERROR|'session_rate_limited_error' ? BetaManagedAgentsSessionRateLimitedRunError : ($type is Type::SESSION_CREATION_REJECTED_ERROR|'session_creation_rejected_error' ? BetaManagedAgentsSessionCreationRejectedRunError : ($type is Type::UNKNOWN_ERROR|'unknown_error' ? BetaManagedAgentsUnknownRunError : ($type is Type::SELF_HOSTED_RESOURCES_UNSUPPORTED_ERROR|'self_hosted_resources_unsupported_error' ? BetaManagedAgentsSelfHostedResourcesUnsupportedRunError : ($type is Type::MCP_EGRESS_BLOCKED_ERROR|'mcp_egress_blocked_error' ? BetaManagedAgentsMCPEgressBlockedRunError : BetaManagedAgentsEnvironmentArchivedRunError|BetaManagedAgentsAgentArchivedRunError|BetaManagedAgentsEnvironmentNotFoundRunError|BetaManagedAgentsVaultNotFoundRunError|BetaManagedAgentsVaultArchivedRunError|BetaManagedAgentsFileNotFoundRunError|BetaManagedAgentsMemoryStoreArchivedRunError|BetaManagedAgentsSkillNotFoundRunError|BetaManagedAgentsSessionResourceNotFoundRunError|BetaManagedAgentsWorkspaceArchivedRunError|BetaManagedAgentsOrganizationDisabledRunError|BetaManagedAgentsSessionRateLimitedRunError|BetaManagedAgentsSessionCreationRejectedRunError|BetaManagedAgentsUnknownRunError|BetaManagedAgentsSelfHostedResourcesUnsupportedRunError|BetaManagedAgentsMCPEgressBlockedRunError))))))))))))))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        string $message,
    ): BetaManagedAgentsEnvironmentArchivedRunError|BetaManagedAgentsAgentArchivedRunError|BetaManagedAgentsEnvironmentNotFoundRunError|BetaManagedAgentsVaultNotFoundRunError|BetaManagedAgentsVaultArchivedRunError|BetaManagedAgentsFileNotFoundRunError|BetaManagedAgentsMemoryStoreArchivedRunError|BetaManagedAgentsSkillNotFoundRunError|BetaManagedAgentsSessionResourceNotFoundRunError|BetaManagedAgentsWorkspaceArchivedRunError|BetaManagedAgentsOrganizationDisabledRunError|BetaManagedAgentsSessionRateLimitedRunError|BetaManagedAgentsSessionCreationRejectedRunError|BetaManagedAgentsUnknownRunError|BetaManagedAgentsSelfHostedResourcesUnsupportedRunError|BetaManagedAgentsMCPEgressBlockedRunError {
        return match ($type) {
            Type::ENVIRONMENT_ARCHIVED_ERROR, 'environment_archived_error' => BetaManagedAgentsEnvironmentArchivedRunError::with(
                type: 'environment_archived_error',
                message: $message
            ),
            Type::AGENT_ARCHIVED_ERROR, 'agent_archived_error' => BetaManagedAgentsAgentArchivedRunError::with(
                type: 'agent_archived_error',
                message: $message
            ),
            Type::ENVIRONMENT_NOT_FOUND_ERROR, 'environment_not_found_error' => BetaManagedAgentsEnvironmentNotFoundRunError::with(
                type: 'environment_not_found_error',
                message: $message
            ),
            Type::VAULT_NOT_FOUND_ERROR, 'vault_not_found_error' => BetaManagedAgentsVaultNotFoundRunError::with(
                type: 'vault_not_found_error',
                message: $message
            ),
            Type::VAULT_ARCHIVED_ERROR, 'vault_archived_error' => BetaManagedAgentsVaultArchivedRunError::with(
                type: 'vault_archived_error',
                message: $message
            ),
            Type::FILE_NOT_FOUND_ERROR, 'file_not_found_error' => BetaManagedAgentsFileNotFoundRunError::with(
                type: 'file_not_found_error',
                message: $message
            ),
            Type::MEMORY_STORE_ARCHIVED_ERROR, 'memory_store_archived_error' => BetaManagedAgentsMemoryStoreArchivedRunError::with(
                type: 'memory_store_archived_error',
                message: $message
            ),
            Type::SKILL_NOT_FOUND_ERROR, 'skill_not_found_error' => BetaManagedAgentsSkillNotFoundRunError::with(
                type: 'skill_not_found_error',
                message: $message
            ),
            Type::SESSION_RESOURCE_NOT_FOUND_ERROR, 'session_resource_not_found_error' => BetaManagedAgentsSessionResourceNotFoundRunError::with(
                type: 'session_resource_not_found_error',
                message: $message
            ),
            Type::WORKSPACE_ARCHIVED_ERROR, 'workspace_archived_error' => BetaManagedAgentsWorkspaceArchivedRunError::with(
                type: 'workspace_archived_error',
                message: $message
            ),
            Type::ORGANIZATION_DISABLED_ERROR, 'organization_disabled_error' => BetaManagedAgentsOrganizationDisabledRunError::with(
                type: 'organization_disabled_error',
                message: $message
            ),
            Type::SESSION_RATE_LIMITED_ERROR, 'session_rate_limited_error' => BetaManagedAgentsSessionRateLimitedRunError::with(
                type: 'session_rate_limited_error',
                message: $message
            ),
            Type::SESSION_CREATION_REJECTED_ERROR, 'session_creation_rejected_error' => BetaManagedAgentsSessionCreationRejectedRunError::with(
                type: 'session_creation_rejected_error',
                message: $message
            ),
            Type::UNKNOWN_ERROR, 'unknown_error' => BetaManagedAgentsUnknownRunError::with(
                type: 'unknown_error',
                message: $message
            ),
            Type::SELF_HOSTED_RESOURCES_UNSUPPORTED_ERROR, 'self_hosted_resources_unsupported_error' => BetaManagedAgentsSelfHostedResourcesUnsupportedRunError::with(
                type: 'self_hosted_resources_unsupported_error',
                message: $message
            ),
            Type::MCP_EGRESS_BLOCKED_ERROR, 'mcp_egress_blocked_error' => BetaManagedAgentsMCPEgressBlockedRunError::with(
                type: 'mcp_egress_blocked_error',
                message: $message
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
