<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * The error that triggered an auto-pause. Matches the failed run's `error.type`.
 *
 * @phpstan-import-type BetaManagedAgentsEnvironmentArchivedDeploymentPausedReasonErrorObjectShape from \Anthropic\Beta\Deployments\BetaManagedAgentsEnvironmentArchivedDeploymentPausedReasonErrorObject
 * @phpstan-import-type BetaManagedAgentsAgentArchivedDeploymentPausedReasonErrorObjectShape from \Anthropic\Beta\Deployments\BetaManagedAgentsAgentArchivedDeploymentPausedReasonErrorObject
 * @phpstan-import-type BetaManagedAgentsEnvironmentNotFoundDeploymentPausedReasonErrorObjectShape from \Anthropic\Beta\Deployments\BetaManagedAgentsEnvironmentNotFoundDeploymentPausedReasonErrorObject
 * @phpstan-import-type BetaManagedAgentsVaultNotFoundDeploymentPausedReasonErrorObjectShape from \Anthropic\Beta\Deployments\BetaManagedAgentsVaultNotFoundDeploymentPausedReasonErrorObject
 * @phpstan-import-type BetaManagedAgentsFileNotFoundDeploymentPausedReasonErrorObjectShape from \Anthropic\Beta\Deployments\BetaManagedAgentsFileNotFoundDeploymentPausedReasonErrorObject
 * @phpstan-import-type BetaManagedAgentsSessionResourceNotFoundDeploymentPausedReasonErrorObjectShape from \Anthropic\Beta\Deployments\BetaManagedAgentsSessionResourceNotFoundDeploymentPausedReasonErrorObject
 * @phpstan-import-type BetaManagedAgentsWorkspaceArchivedDeploymentPausedReasonErrorObjectShape from \Anthropic\Beta\Deployments\BetaManagedAgentsWorkspaceArchivedDeploymentPausedReasonErrorObject
 * @phpstan-import-type BetaManagedAgentsOrganizationDisabledDeploymentPausedReasonErrorObjectShape from \Anthropic\Beta\Deployments\BetaManagedAgentsOrganizationDisabledDeploymentPausedReasonErrorObject
 * @phpstan-import-type BetaManagedAgentsMemoryStoreArchivedDeploymentPausedReasonErrorObjectShape from \Anthropic\Beta\Deployments\BetaManagedAgentsMemoryStoreArchivedDeploymentPausedReasonErrorObject
 * @phpstan-import-type BetaManagedAgentsSkillNotFoundDeploymentPausedReasonErrorObjectShape from \Anthropic\Beta\Deployments\BetaManagedAgentsSkillNotFoundDeploymentPausedReasonErrorObject
 * @phpstan-import-type BetaManagedAgentsVaultArchivedDeploymentPausedReasonErrorObjectShape from \Anthropic\Beta\Deployments\BetaManagedAgentsVaultArchivedDeploymentPausedReasonErrorObject
 * @phpstan-import-type BetaManagedAgentsUnknownDeploymentPausedReasonErrorObjectShape from \Anthropic\Beta\Deployments\BetaManagedAgentsUnknownDeploymentPausedReasonErrorObject
 * @phpstan-import-type BetaManagedAgentsSelfHostedResourcesUnsupportedDeploymentPausedReasonErrorObjectShape from \Anthropic\Beta\Deployments\BetaManagedAgentsSelfHostedResourcesUnsupportedDeploymentPausedReasonErrorObject
 * @phpstan-import-type BetaManagedAgentsMCPEgressBlockedDeploymentPausedReasonErrorObjectShape from \Anthropic\Beta\Deployments\BetaManagedAgentsMCPEgressBlockedDeploymentPausedReasonErrorObject
 *
 * @phpstan-type BetaManagedAgentsDeploymentPausedReasonErrorObjectVariants = BetaManagedAgentsEnvironmentArchivedDeploymentPausedReasonErrorObject|BetaManagedAgentsAgentArchivedDeploymentPausedReasonErrorObject|BetaManagedAgentsEnvironmentNotFoundDeploymentPausedReasonErrorObject|BetaManagedAgentsVaultNotFoundDeploymentPausedReasonErrorObject|BetaManagedAgentsFileNotFoundDeploymentPausedReasonErrorObject|BetaManagedAgentsSessionResourceNotFoundDeploymentPausedReasonErrorObject|BetaManagedAgentsWorkspaceArchivedDeploymentPausedReasonErrorObject|BetaManagedAgentsOrganizationDisabledDeploymentPausedReasonErrorObject|BetaManagedAgentsMemoryStoreArchivedDeploymentPausedReasonErrorObject|BetaManagedAgentsSkillNotFoundDeploymentPausedReasonErrorObject|BetaManagedAgentsVaultArchivedDeploymentPausedReasonErrorObject|BetaManagedAgentsUnknownDeploymentPausedReasonErrorObject|BetaManagedAgentsSelfHostedResourcesUnsupportedDeploymentPausedReasonErrorObject|BetaManagedAgentsMCPEgressBlockedDeploymentPausedReasonErrorObject
 * @phpstan-type BetaManagedAgentsDeploymentPausedReasonErrorObjectShape = BetaManagedAgentsDeploymentPausedReasonErrorObjectVariants|BetaManagedAgentsEnvironmentArchivedDeploymentPausedReasonErrorObjectShape|BetaManagedAgentsAgentArchivedDeploymentPausedReasonErrorObjectShape|BetaManagedAgentsEnvironmentNotFoundDeploymentPausedReasonErrorObjectShape|BetaManagedAgentsVaultNotFoundDeploymentPausedReasonErrorObjectShape|BetaManagedAgentsFileNotFoundDeploymentPausedReasonErrorObjectShape|BetaManagedAgentsSessionResourceNotFoundDeploymentPausedReasonErrorObjectShape|BetaManagedAgentsWorkspaceArchivedDeploymentPausedReasonErrorObjectShape|BetaManagedAgentsOrganizationDisabledDeploymentPausedReasonErrorObjectShape|BetaManagedAgentsMemoryStoreArchivedDeploymentPausedReasonErrorObjectShape|BetaManagedAgentsSkillNotFoundDeploymentPausedReasonErrorObjectShape|BetaManagedAgentsVaultArchivedDeploymentPausedReasonErrorObjectShape|BetaManagedAgentsUnknownDeploymentPausedReasonErrorObjectShape|BetaManagedAgentsSelfHostedResourcesUnsupportedDeploymentPausedReasonErrorObjectShape|BetaManagedAgentsMCPEgressBlockedDeploymentPausedReasonErrorObjectShape
 */
class BetaManagedAgentsDeploymentPausedReasonErrorObject implements ConverterSource
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
            'environment_archived_error' => BetaManagedAgentsEnvironmentArchivedDeploymentPausedReasonErrorObject::class,
            'agent_archived_error' => BetaManagedAgentsAgentArchivedDeploymentPausedReasonErrorObject::class,
            'environment_not_found_error' => BetaManagedAgentsEnvironmentNotFoundDeploymentPausedReasonErrorObject::class,
            'vault_not_found_error' => BetaManagedAgentsVaultNotFoundDeploymentPausedReasonErrorObject::class,
            'file_not_found_error' => BetaManagedAgentsFileNotFoundDeploymentPausedReasonErrorObject::class,
            'session_resource_not_found_error' => BetaManagedAgentsSessionResourceNotFoundDeploymentPausedReasonErrorObject::class,
            'workspace_archived_error' => BetaManagedAgentsWorkspaceArchivedDeploymentPausedReasonErrorObject::class,
            'organization_disabled_error' => BetaManagedAgentsOrganizationDisabledDeploymentPausedReasonErrorObject::class,
            'memory_store_archived_error' => BetaManagedAgentsMemoryStoreArchivedDeploymentPausedReasonErrorObject::class,
            'skill_not_found_error' => BetaManagedAgentsSkillNotFoundDeploymentPausedReasonErrorObject::class,
            'vault_archived_error' => BetaManagedAgentsVaultArchivedDeploymentPausedReasonErrorObject::class,
            'unknown_error' => BetaManagedAgentsUnknownDeploymentPausedReasonErrorObject::class,
            'self_hosted_resources_unsupported_error' => BetaManagedAgentsSelfHostedResourcesUnsupportedDeploymentPausedReasonErrorObject::class,
            'mcp_egress_blocked_error' => BetaManagedAgentsMCPEgressBlockedDeploymentPausedReasonErrorObject::class,
        ];
    }
}

class_alias(
    BetaManagedAgentsDeploymentPausedReasonErrorObject::class,
    'Anthropic\Beta\Deployments\BetaManagedAgentsDeploymentPausedReasonError',
);
