<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A scheduled fire recorded a failed run whose error auto-pauses the deployment.
 *
 * @phpstan-import-type BetaManagedAgentsDeploymentPausedReasonErrorObjectShape from \Anthropic\Beta\Deployments\BetaManagedAgentsDeploymentPausedReasonErrorObject
 * @phpstan-import-type BetaManagedAgentsDeploymentPausedReasonErrorObjectVariants from \Anthropic\Beta\Deployments\BetaManagedAgentsDeploymentPausedReasonErrorObject
 *
 * @phpstan-type BetaManagedAgentsErrorDeploymentPausedReasonShape = array{
 *   error: BetaManagedAgentsDeploymentPausedReasonErrorObjectShape, type: 'error'
 * }
 */
final class BetaManagedAgentsErrorDeploymentPausedReason implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsErrorDeploymentPausedReasonShape> */
    use SdkModel;

    /** @var 'error' $type */
    #[Required(type: new ConstantOf('error'))]
    public string $type = 'error';

    /**
     * The failed run's error.
     *
     * @var BetaManagedAgentsDeploymentPausedReasonErrorObjectVariants $error
     */
    #[Required(union: BetaManagedAgentsDeploymentPausedReasonErrorObject::class)]
    public BetaManagedAgentsEnvironmentArchivedDeploymentPausedReasonErrorObject|BetaManagedAgentsAgentArchivedDeploymentPausedReasonErrorObject|BetaManagedAgentsEnvironmentNotFoundDeploymentPausedReasonErrorObject|BetaManagedAgentsVaultNotFoundDeploymentPausedReasonErrorObject|BetaManagedAgentsFileNotFoundDeploymentPausedReasonErrorObject|BetaManagedAgentsSessionResourceNotFoundDeploymentPausedReasonErrorObject|BetaManagedAgentsWorkspaceArchivedDeploymentPausedReasonErrorObject|BetaManagedAgentsOrganizationDisabledDeploymentPausedReasonErrorObject|BetaManagedAgentsMemoryStoreArchivedDeploymentPausedReasonErrorObject|BetaManagedAgentsSkillNotFoundDeploymentPausedReasonErrorObject|BetaManagedAgentsVaultArchivedDeploymentPausedReasonErrorObject|BetaManagedAgentsUnknownDeploymentPausedReasonErrorObject|BetaManagedAgentsSelfHostedResourcesUnsupportedDeploymentPausedReasonErrorObject|BetaManagedAgentsMCPEgressBlockedDeploymentPausedReasonErrorObject $error;

    /**
     * `new BetaManagedAgentsErrorDeploymentPausedReason()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsErrorDeploymentPausedReason::with(error: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsErrorDeploymentPausedReason())->withError(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param BetaManagedAgentsDeploymentPausedReasonErrorObjectShape $error
     */
    public static function with(
        BetaManagedAgentsEnvironmentArchivedDeploymentPausedReasonErrorObject|array|BetaManagedAgentsAgentArchivedDeploymentPausedReasonErrorObject|BetaManagedAgentsEnvironmentNotFoundDeploymentPausedReasonErrorObject|BetaManagedAgentsVaultNotFoundDeploymentPausedReasonErrorObject|BetaManagedAgentsFileNotFoundDeploymentPausedReasonErrorObject|BetaManagedAgentsSessionResourceNotFoundDeploymentPausedReasonErrorObject|BetaManagedAgentsWorkspaceArchivedDeploymentPausedReasonErrorObject|BetaManagedAgentsOrganizationDisabledDeploymentPausedReasonErrorObject|BetaManagedAgentsMemoryStoreArchivedDeploymentPausedReasonErrorObject|BetaManagedAgentsSkillNotFoundDeploymentPausedReasonErrorObject|BetaManagedAgentsVaultArchivedDeploymentPausedReasonErrorObject|BetaManagedAgentsUnknownDeploymentPausedReasonErrorObject|BetaManagedAgentsSelfHostedResourcesUnsupportedDeploymentPausedReasonErrorObject|BetaManagedAgentsMCPEgressBlockedDeploymentPausedReasonErrorObject $error,
    ): self {
        $self = new self;

        $self['error'] = $error;

        return $self;
    }

    /**
     * The failed run's error.
     *
     * @param BetaManagedAgentsDeploymentPausedReasonErrorObjectShape $error
     */
    public function withError(
        BetaManagedAgentsEnvironmentArchivedDeploymentPausedReasonErrorObject|array|BetaManagedAgentsAgentArchivedDeploymentPausedReasonErrorObject|BetaManagedAgentsEnvironmentNotFoundDeploymentPausedReasonErrorObject|BetaManagedAgentsVaultNotFoundDeploymentPausedReasonErrorObject|BetaManagedAgentsFileNotFoundDeploymentPausedReasonErrorObject|BetaManagedAgentsSessionResourceNotFoundDeploymentPausedReasonErrorObject|BetaManagedAgentsWorkspaceArchivedDeploymentPausedReasonErrorObject|BetaManagedAgentsOrganizationDisabledDeploymentPausedReasonErrorObject|BetaManagedAgentsMemoryStoreArchivedDeploymentPausedReasonErrorObject|BetaManagedAgentsSkillNotFoundDeploymentPausedReasonErrorObject|BetaManagedAgentsVaultArchivedDeploymentPausedReasonErrorObject|BetaManagedAgentsUnknownDeploymentPausedReasonErrorObject|BetaManagedAgentsSelfHostedResourcesUnsupportedDeploymentPausedReasonErrorObject|BetaManagedAgentsMCPEgressBlockedDeploymentPausedReasonErrorObject $error,
    ): self {
        $self = clone $this;
        $self['error'] = $error;

        return $self;
    }

    /**
     * @param 'error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
