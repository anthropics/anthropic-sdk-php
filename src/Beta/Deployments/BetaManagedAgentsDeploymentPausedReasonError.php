<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments;

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
}
