<?php

declare(strict_types=1);

namespace Anthropic\Beta\DeploymentRuns\BetaManagedAgentsDeploymentRun;

use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsAgentArchivedRunErrorObject;
use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsEnvironmentArchivedRunErrorObject;
use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsEnvironmentNotFoundRunErrorObject;
use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsFileNotFoundRunErrorObject;
use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsMCPEgressBlockedRunErrorObject;
use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsMemoryStoreArchivedRunErrorObject;
use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsOrganizationDisabledRunErrorObject;
use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsSelfHostedResourcesUnsupportedRunErrorObject;
use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsSessionCreationRejectedRunErrorObject;
use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsSessionRateLimitedRunErrorObject;
use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsSessionResourceNotFoundRunErrorObject;
use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsSkillNotFoundRunErrorObject;
use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsUnknownRunErrorObject;
use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsVaultArchivedRunErrorObject;
use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsVaultNotFoundRunErrorObject;
use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsWorkspaceArchivedRunErrorObject;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Populated on creation failure. Null on success. Exactly one of `session_id` or `error` is non-null.
 *
 * @phpstan-import-type BetaManagedAgentsEnvironmentArchivedRunErrorObjectShape from \Anthropic\Beta\DeploymentRuns\BetaManagedAgentsEnvironmentArchivedRunErrorObject
 * @phpstan-import-type BetaManagedAgentsAgentArchivedRunErrorObjectShape from \Anthropic\Beta\DeploymentRuns\BetaManagedAgentsAgentArchivedRunErrorObject
 * @phpstan-import-type BetaManagedAgentsEnvironmentNotFoundRunErrorObjectShape from \Anthropic\Beta\DeploymentRuns\BetaManagedAgentsEnvironmentNotFoundRunErrorObject
 * @phpstan-import-type BetaManagedAgentsVaultNotFoundRunErrorObjectShape from \Anthropic\Beta\DeploymentRuns\BetaManagedAgentsVaultNotFoundRunErrorObject
 * @phpstan-import-type BetaManagedAgentsVaultArchivedRunErrorObjectShape from \Anthropic\Beta\DeploymentRuns\BetaManagedAgentsVaultArchivedRunErrorObject
 * @phpstan-import-type BetaManagedAgentsFileNotFoundRunErrorObjectShape from \Anthropic\Beta\DeploymentRuns\BetaManagedAgentsFileNotFoundRunErrorObject
 * @phpstan-import-type BetaManagedAgentsMemoryStoreArchivedRunErrorObjectShape from \Anthropic\Beta\DeploymentRuns\BetaManagedAgentsMemoryStoreArchivedRunErrorObject
 * @phpstan-import-type BetaManagedAgentsSkillNotFoundRunErrorObjectShape from \Anthropic\Beta\DeploymentRuns\BetaManagedAgentsSkillNotFoundRunErrorObject
 * @phpstan-import-type BetaManagedAgentsSessionResourceNotFoundRunErrorObjectShape from \Anthropic\Beta\DeploymentRuns\BetaManagedAgentsSessionResourceNotFoundRunErrorObject
 * @phpstan-import-type BetaManagedAgentsWorkspaceArchivedRunErrorObjectShape from \Anthropic\Beta\DeploymentRuns\BetaManagedAgentsWorkspaceArchivedRunErrorObject
 * @phpstan-import-type BetaManagedAgentsOrganizationDisabledRunErrorObjectShape from \Anthropic\Beta\DeploymentRuns\BetaManagedAgentsOrganizationDisabledRunErrorObject
 * @phpstan-import-type BetaManagedAgentsSessionRateLimitedRunErrorObjectShape from \Anthropic\Beta\DeploymentRuns\BetaManagedAgentsSessionRateLimitedRunErrorObject
 * @phpstan-import-type BetaManagedAgentsSessionCreationRejectedRunErrorObjectShape from \Anthropic\Beta\DeploymentRuns\BetaManagedAgentsSessionCreationRejectedRunErrorObject
 * @phpstan-import-type BetaManagedAgentsUnknownRunErrorObjectShape from \Anthropic\Beta\DeploymentRuns\BetaManagedAgentsUnknownRunErrorObject
 * @phpstan-import-type BetaManagedAgentsSelfHostedResourcesUnsupportedRunErrorObjectShape from \Anthropic\Beta\DeploymentRuns\BetaManagedAgentsSelfHostedResourcesUnsupportedRunErrorObject
 * @phpstan-import-type BetaManagedAgentsMCPEgressBlockedRunErrorObjectShape from \Anthropic\Beta\DeploymentRuns\BetaManagedAgentsMCPEgressBlockedRunErrorObject
 *
 * @phpstan-type ErrorVariants = BetaManagedAgentsEnvironmentArchivedRunErrorObject|BetaManagedAgentsAgentArchivedRunErrorObject|BetaManagedAgentsEnvironmentNotFoundRunErrorObject|BetaManagedAgentsVaultNotFoundRunErrorObject|BetaManagedAgentsVaultArchivedRunErrorObject|BetaManagedAgentsFileNotFoundRunErrorObject|BetaManagedAgentsMemoryStoreArchivedRunErrorObject|BetaManagedAgentsSkillNotFoundRunErrorObject|BetaManagedAgentsSessionResourceNotFoundRunErrorObject|BetaManagedAgentsWorkspaceArchivedRunErrorObject|BetaManagedAgentsOrganizationDisabledRunErrorObject|BetaManagedAgentsSessionRateLimitedRunErrorObject|BetaManagedAgentsSessionCreationRejectedRunErrorObject|BetaManagedAgentsUnknownRunErrorObject|BetaManagedAgentsSelfHostedResourcesUnsupportedRunErrorObject|BetaManagedAgentsMCPEgressBlockedRunErrorObject
 * @phpstan-type ErrorShape = ErrorVariants|BetaManagedAgentsEnvironmentArchivedRunErrorObjectShape|BetaManagedAgentsAgentArchivedRunErrorObjectShape|BetaManagedAgentsEnvironmentNotFoundRunErrorObjectShape|BetaManagedAgentsVaultNotFoundRunErrorObjectShape|BetaManagedAgentsVaultArchivedRunErrorObjectShape|BetaManagedAgentsFileNotFoundRunErrorObjectShape|BetaManagedAgentsMemoryStoreArchivedRunErrorObjectShape|BetaManagedAgentsSkillNotFoundRunErrorObjectShape|BetaManagedAgentsSessionResourceNotFoundRunErrorObjectShape|BetaManagedAgentsWorkspaceArchivedRunErrorObjectShape|BetaManagedAgentsOrganizationDisabledRunErrorObjectShape|BetaManagedAgentsSessionRateLimitedRunErrorObjectShape|BetaManagedAgentsSessionCreationRejectedRunErrorObjectShape|BetaManagedAgentsUnknownRunErrorObjectShape|BetaManagedAgentsSelfHostedResourcesUnsupportedRunErrorObjectShape|BetaManagedAgentsMCPEgressBlockedRunErrorObjectShape
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
            'environment_archived_error' => BetaManagedAgentsEnvironmentArchivedRunErrorObject::class,
            'agent_archived_error' => BetaManagedAgentsAgentArchivedRunErrorObject::class,
            'environment_not_found_error' => BetaManagedAgentsEnvironmentNotFoundRunErrorObject::class,
            'vault_not_found_error' => BetaManagedAgentsVaultNotFoundRunErrorObject::class,
            'vault_archived_error' => BetaManagedAgentsVaultArchivedRunErrorObject::class,
            'file_not_found_error' => BetaManagedAgentsFileNotFoundRunErrorObject::class,
            'memory_store_archived_error' => BetaManagedAgentsMemoryStoreArchivedRunErrorObject::class,
            'skill_not_found_error' => BetaManagedAgentsSkillNotFoundRunErrorObject::class,
            'session_resource_not_found_error' => BetaManagedAgentsSessionResourceNotFoundRunErrorObject::class,
            'workspace_archived_error' => BetaManagedAgentsWorkspaceArchivedRunErrorObject::class,
            'organization_disabled_error' => BetaManagedAgentsOrganizationDisabledRunErrorObject::class,
            'session_rate_limited_error' => BetaManagedAgentsSessionRateLimitedRunErrorObject::class,
            'session_creation_rejected_error' => BetaManagedAgentsSessionCreationRejectedRunErrorObject::class,
            'unknown_error' => BetaManagedAgentsUnknownRunErrorObject::class,
            'self_hosted_resources_unsupported_error' => BetaManagedAgentsSelfHostedResourcesUnsupportedRunErrorObject::class,
            'mcp_egress_blocked_error' => BetaManagedAgentsMCPEgressBlockedRunErrorObject::class,
        ];
    }
}
