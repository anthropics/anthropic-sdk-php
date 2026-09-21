<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments;

use Anthropic\Beta\Deployments\BetaManagedAgentsDeploymentPausedReasonError\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * The error that triggered an auto-pause. Matches the failed run's `error.type`.
 *
 * @phpstan-import-type BetaManagedAgentsEnvironmentArchivedDeploymentPausedReasonErrorShape from \Anthropic\Beta\Deployments\BetaManagedAgentsEnvironmentArchivedDeploymentPausedReasonError
 * @phpstan-import-type BetaManagedAgentsAgentArchivedDeploymentPausedReasonErrorShape from \Anthropic\Beta\Deployments\BetaManagedAgentsAgentArchivedDeploymentPausedReasonError
 * @phpstan-import-type BetaManagedAgentsEnvironmentNotFoundDeploymentPausedReasonErrorShape from \Anthropic\Beta\Deployments\BetaManagedAgentsEnvironmentNotFoundDeploymentPausedReasonError
 * @phpstan-import-type BetaManagedAgentsVaultNotFoundDeploymentPausedReasonErrorShape from \Anthropic\Beta\Deployments\BetaManagedAgentsVaultNotFoundDeploymentPausedReasonError
 * @phpstan-import-type BetaManagedAgentsFileNotFoundDeploymentPausedReasonErrorShape from \Anthropic\Beta\Deployments\BetaManagedAgentsFileNotFoundDeploymentPausedReasonError
 * @phpstan-import-type BetaManagedAgentsSessionResourceNotFoundDeploymentPausedReasonErrorShape from \Anthropic\Beta\Deployments\BetaManagedAgentsSessionResourceNotFoundDeploymentPausedReasonError
 * @phpstan-import-type BetaManagedAgentsWorkspaceArchivedDeploymentPausedReasonErrorShape from \Anthropic\Beta\Deployments\BetaManagedAgentsWorkspaceArchivedDeploymentPausedReasonError
 * @phpstan-import-type BetaManagedAgentsOrganizationDisabledDeploymentPausedReasonErrorShape from \Anthropic\Beta\Deployments\BetaManagedAgentsOrganizationDisabledDeploymentPausedReasonError
 * @phpstan-import-type BetaManagedAgentsMemoryStoreArchivedDeploymentPausedReasonErrorShape from \Anthropic\Beta\Deployments\BetaManagedAgentsMemoryStoreArchivedDeploymentPausedReasonError
 * @phpstan-import-type BetaManagedAgentsSkillNotFoundDeploymentPausedReasonErrorShape from \Anthropic\Beta\Deployments\BetaManagedAgentsSkillNotFoundDeploymentPausedReasonError
 * @phpstan-import-type BetaManagedAgentsVaultArchivedDeploymentPausedReasonErrorShape from \Anthropic\Beta\Deployments\BetaManagedAgentsVaultArchivedDeploymentPausedReasonError
 * @phpstan-import-type BetaManagedAgentsUnknownDeploymentPausedReasonErrorShape from \Anthropic\Beta\Deployments\BetaManagedAgentsUnknownDeploymentPausedReasonError
 * @phpstan-import-type BetaManagedAgentsSelfHostedResourcesUnsupportedDeploymentPausedReasonErrorShape from \Anthropic\Beta\Deployments\BetaManagedAgentsSelfHostedResourcesUnsupportedDeploymentPausedReasonError
 * @phpstan-import-type BetaManagedAgentsMCPEgressBlockedDeploymentPausedReasonErrorShape from \Anthropic\Beta\Deployments\BetaManagedAgentsMCPEgressBlockedDeploymentPausedReasonError
 *
 * @phpstan-type BetaManagedAgentsDeploymentPausedReasonErrorVariants = BetaManagedAgentsEnvironmentArchivedDeploymentPausedReasonError|BetaManagedAgentsAgentArchivedDeploymentPausedReasonError|BetaManagedAgentsEnvironmentNotFoundDeploymentPausedReasonError|BetaManagedAgentsVaultNotFoundDeploymentPausedReasonError|BetaManagedAgentsFileNotFoundDeploymentPausedReasonError|BetaManagedAgentsSessionResourceNotFoundDeploymentPausedReasonError|BetaManagedAgentsWorkspaceArchivedDeploymentPausedReasonError|BetaManagedAgentsOrganizationDisabledDeploymentPausedReasonError|BetaManagedAgentsMemoryStoreArchivedDeploymentPausedReasonError|BetaManagedAgentsSkillNotFoundDeploymentPausedReasonError|BetaManagedAgentsVaultArchivedDeploymentPausedReasonError|BetaManagedAgentsUnknownDeploymentPausedReasonError|BetaManagedAgentsSelfHostedResourcesUnsupportedDeploymentPausedReasonError|BetaManagedAgentsMCPEgressBlockedDeploymentPausedReasonError
 * @phpstan-type BetaManagedAgentsDeploymentPausedReasonErrorShape = BetaManagedAgentsDeploymentPausedReasonErrorVariants|BetaManagedAgentsEnvironmentArchivedDeploymentPausedReasonErrorShape|BetaManagedAgentsAgentArchivedDeploymentPausedReasonErrorShape|BetaManagedAgentsEnvironmentNotFoundDeploymentPausedReasonErrorShape|BetaManagedAgentsVaultNotFoundDeploymentPausedReasonErrorShape|BetaManagedAgentsFileNotFoundDeploymentPausedReasonErrorShape|BetaManagedAgentsSessionResourceNotFoundDeploymentPausedReasonErrorShape|BetaManagedAgentsWorkspaceArchivedDeploymentPausedReasonErrorShape|BetaManagedAgentsOrganizationDisabledDeploymentPausedReasonErrorShape|BetaManagedAgentsMemoryStoreArchivedDeploymentPausedReasonErrorShape|BetaManagedAgentsSkillNotFoundDeploymentPausedReasonErrorShape|BetaManagedAgentsVaultArchivedDeploymentPausedReasonErrorShape|BetaManagedAgentsUnknownDeploymentPausedReasonErrorShape|BetaManagedAgentsSelfHostedResourcesUnsupportedDeploymentPausedReasonErrorShape|BetaManagedAgentsMCPEgressBlockedDeploymentPausedReasonErrorShape
 */
final class BetaManagedAgentsDeploymentPausedReasonError implements ConverterSource
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
            'environment_archived_error' => BetaManagedAgentsEnvironmentArchivedDeploymentPausedReasonError::class,
            'agent_archived_error' => BetaManagedAgentsAgentArchivedDeploymentPausedReasonError::class,
            'environment_not_found_error' => BetaManagedAgentsEnvironmentNotFoundDeploymentPausedReasonError::class,
            'vault_not_found_error' => BetaManagedAgentsVaultNotFoundDeploymentPausedReasonError::class,
            'file_not_found_error' => BetaManagedAgentsFileNotFoundDeploymentPausedReasonError::class,
            'session_resource_not_found_error' => BetaManagedAgentsSessionResourceNotFoundDeploymentPausedReasonError::class,
            'workspace_archived_error' => BetaManagedAgentsWorkspaceArchivedDeploymentPausedReasonError::class,
            'organization_disabled_error' => BetaManagedAgentsOrganizationDisabledDeploymentPausedReasonError::class,
            'memory_store_archived_error' => BetaManagedAgentsMemoryStoreArchivedDeploymentPausedReasonError::class,
            'skill_not_found_error' => BetaManagedAgentsSkillNotFoundDeploymentPausedReasonError::class,
            'vault_archived_error' => BetaManagedAgentsVaultArchivedDeploymentPausedReasonError::class,
            'unknown_error' => BetaManagedAgentsUnknownDeploymentPausedReasonError::class,
            'self_hosted_resources_unsupported_error' => BetaManagedAgentsSelfHostedResourcesUnsupportedDeploymentPausedReasonError::class,
            'mcp_egress_blocked_error' => BetaManagedAgentsMCPEgressBlockedDeploymentPausedReasonError::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::ENVIRONMENT_ARCHIVED_ERROR|'environment_archived_error' ? BetaManagedAgentsEnvironmentArchivedDeploymentPausedReasonError : ($type is Type::AGENT_ARCHIVED_ERROR|'agent_archived_error' ? BetaManagedAgentsAgentArchivedDeploymentPausedReasonError : ($type is Type::ENVIRONMENT_NOT_FOUND_ERROR|'environment_not_found_error' ? BetaManagedAgentsEnvironmentNotFoundDeploymentPausedReasonError : ($type is Type::VAULT_NOT_FOUND_ERROR|'vault_not_found_error' ? BetaManagedAgentsVaultNotFoundDeploymentPausedReasonError : ($type is Type::FILE_NOT_FOUND_ERROR|'file_not_found_error' ? BetaManagedAgentsFileNotFoundDeploymentPausedReasonError : ($type is Type::SESSION_RESOURCE_NOT_FOUND_ERROR|'session_resource_not_found_error' ? BetaManagedAgentsSessionResourceNotFoundDeploymentPausedReasonError : ($type is Type::WORKSPACE_ARCHIVED_ERROR|'workspace_archived_error' ? BetaManagedAgentsWorkspaceArchivedDeploymentPausedReasonError : ($type is Type::ORGANIZATION_DISABLED_ERROR|'organization_disabled_error' ? BetaManagedAgentsOrganizationDisabledDeploymentPausedReasonError : ($type is Type::MEMORY_STORE_ARCHIVED_ERROR|'memory_store_archived_error' ? BetaManagedAgentsMemoryStoreArchivedDeploymentPausedReasonError : ($type is Type::SKILL_NOT_FOUND_ERROR|'skill_not_found_error' ? BetaManagedAgentsSkillNotFoundDeploymentPausedReasonError : ($type is Type::VAULT_ARCHIVED_ERROR|'vault_archived_error' ? BetaManagedAgentsVaultArchivedDeploymentPausedReasonError : ($type is Type::UNKNOWN_ERROR|'unknown_error' ? BetaManagedAgentsUnknownDeploymentPausedReasonError : ($type is Type::SELF_HOSTED_RESOURCES_UNSUPPORTED_ERROR|'self_hosted_resources_unsupported_error' ? BetaManagedAgentsSelfHostedResourcesUnsupportedDeploymentPausedReasonError : ($type is Type::MCP_EGRESS_BLOCKED_ERROR|'mcp_egress_blocked_error' ? BetaManagedAgentsMCPEgressBlockedDeploymentPausedReasonError : BetaManagedAgentsEnvironmentArchivedDeploymentPausedReasonError|BetaManagedAgentsAgentArchivedDeploymentPausedReasonError|BetaManagedAgentsEnvironmentNotFoundDeploymentPausedReasonError|BetaManagedAgentsVaultNotFoundDeploymentPausedReasonError|BetaManagedAgentsFileNotFoundDeploymentPausedReasonError|BetaManagedAgentsSessionResourceNotFoundDeploymentPausedReasonError|BetaManagedAgentsWorkspaceArchivedDeploymentPausedReasonError|BetaManagedAgentsOrganizationDisabledDeploymentPausedReasonError|BetaManagedAgentsMemoryStoreArchivedDeploymentPausedReasonError|BetaManagedAgentsSkillNotFoundDeploymentPausedReasonError|BetaManagedAgentsVaultArchivedDeploymentPausedReasonError|BetaManagedAgentsUnknownDeploymentPausedReasonError|BetaManagedAgentsSelfHostedResourcesUnsupportedDeploymentPausedReasonError|BetaManagedAgentsMCPEgressBlockedDeploymentPausedReasonError))))))))))))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type
    ): BetaManagedAgentsEnvironmentArchivedDeploymentPausedReasonError|BetaManagedAgentsAgentArchivedDeploymentPausedReasonError|BetaManagedAgentsEnvironmentNotFoundDeploymentPausedReasonError|BetaManagedAgentsVaultNotFoundDeploymentPausedReasonError|BetaManagedAgentsFileNotFoundDeploymentPausedReasonError|BetaManagedAgentsSessionResourceNotFoundDeploymentPausedReasonError|BetaManagedAgentsWorkspaceArchivedDeploymentPausedReasonError|BetaManagedAgentsOrganizationDisabledDeploymentPausedReasonError|BetaManagedAgentsMemoryStoreArchivedDeploymentPausedReasonError|BetaManagedAgentsSkillNotFoundDeploymentPausedReasonError|BetaManagedAgentsVaultArchivedDeploymentPausedReasonError|BetaManagedAgentsUnknownDeploymentPausedReasonError|BetaManagedAgentsSelfHostedResourcesUnsupportedDeploymentPausedReasonError|BetaManagedAgentsMCPEgressBlockedDeploymentPausedReasonError {
        return match ($type) {
            Type::ENVIRONMENT_ARCHIVED_ERROR, 'environment_archived_error' => BetaManagedAgentsEnvironmentArchivedDeploymentPausedReasonError::with(
                type: 'environment_archived_error'
            ),
            Type::AGENT_ARCHIVED_ERROR, 'agent_archived_error' => BetaManagedAgentsAgentArchivedDeploymentPausedReasonError::with(
                type: 'agent_archived_error'
            ),
            Type::ENVIRONMENT_NOT_FOUND_ERROR, 'environment_not_found_error' => BetaManagedAgentsEnvironmentNotFoundDeploymentPausedReasonError::with(
                type: 'environment_not_found_error'
            ),
            Type::VAULT_NOT_FOUND_ERROR, 'vault_not_found_error' => BetaManagedAgentsVaultNotFoundDeploymentPausedReasonError::with(
                type: 'vault_not_found_error'
            ),
            Type::FILE_NOT_FOUND_ERROR, 'file_not_found_error' => BetaManagedAgentsFileNotFoundDeploymentPausedReasonError::with(
                type: 'file_not_found_error'
            ),
            Type::SESSION_RESOURCE_NOT_FOUND_ERROR, 'session_resource_not_found_error' => BetaManagedAgentsSessionResourceNotFoundDeploymentPausedReasonError::with(
                type: 'session_resource_not_found_error'
            ),
            Type::WORKSPACE_ARCHIVED_ERROR, 'workspace_archived_error' => BetaManagedAgentsWorkspaceArchivedDeploymentPausedReasonError::with(
                type: 'workspace_archived_error'
            ),
            Type::ORGANIZATION_DISABLED_ERROR, 'organization_disabled_error' => BetaManagedAgentsOrganizationDisabledDeploymentPausedReasonError::with(
                type: 'organization_disabled_error'
            ),
            Type::MEMORY_STORE_ARCHIVED_ERROR, 'memory_store_archived_error' => BetaManagedAgentsMemoryStoreArchivedDeploymentPausedReasonError::with(
                type: 'memory_store_archived_error'
            ),
            Type::SKILL_NOT_FOUND_ERROR, 'skill_not_found_error' => BetaManagedAgentsSkillNotFoundDeploymentPausedReasonError::with(
                type: 'skill_not_found_error'
            ),
            Type::VAULT_ARCHIVED_ERROR, 'vault_archived_error' => BetaManagedAgentsVaultArchivedDeploymentPausedReasonError::with(
                type: 'vault_archived_error'
            ),
            Type::UNKNOWN_ERROR, 'unknown_error' => BetaManagedAgentsUnknownDeploymentPausedReasonError::with(
                type: 'unknown_error'
            ),
            Type::SELF_HOSTED_RESOURCES_UNSUPPORTED_ERROR, 'self_hosted_resources_unsupported_error' => BetaManagedAgentsSelfHostedResourcesUnsupportedDeploymentPausedReasonError::with(
                type: 'self_hosted_resources_unsupported_error'
            ),
            Type::MCP_EGRESS_BLOCKED_ERROR, 'mcp_egress_blocked_error' => BetaManagedAgentsMCPEgressBlockedDeploymentPausedReasonError::with(
                type: 'mcp_egress_blocked_error'
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
