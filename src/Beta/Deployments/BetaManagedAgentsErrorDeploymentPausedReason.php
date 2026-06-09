<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments;

use Anthropic\Beta\Deployments\BetaManagedAgentsErrorDeploymentPausedReason\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A scheduled fire recorded a failed run whose error auto-pauses the deployment.
 *
 * @phpstan-import-type BetaManagedAgentsDeploymentPausedReasonErrorVariants from \Anthropic\Beta\Deployments\BetaManagedAgentsDeploymentPausedReasonError
 * @phpstan-import-type BetaManagedAgentsDeploymentPausedReasonErrorShape from \Anthropic\Beta\Deployments\BetaManagedAgentsDeploymentPausedReasonError
 *
 * @phpstan-type BetaManagedAgentsErrorDeploymentPausedReasonShape = array{
 *   error: BetaManagedAgentsDeploymentPausedReasonErrorShape,
 *   type: Type|value-of<Type>,
 * }
 */
final class BetaManagedAgentsErrorDeploymentPausedReason implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsErrorDeploymentPausedReasonShape> */
    use SdkModel;

    /**
     * The error that triggered an auto-pause. Matches the failed run's `error.type`.
     *
     * @var BetaManagedAgentsDeploymentPausedReasonErrorVariants $error
     */
    #[Required(union: BetaManagedAgentsDeploymentPausedReasonError::class)]
    public BetaManagedAgentsEnvironmentArchivedDeploymentPausedReasonError|BetaManagedAgentsAgentArchivedDeploymentPausedReasonError|BetaManagedAgentsEnvironmentNotFoundDeploymentPausedReasonError|BetaManagedAgentsVaultNotFoundDeploymentPausedReasonError|BetaManagedAgentsFileNotFoundDeploymentPausedReasonError|BetaManagedAgentsSessionResourceNotFoundDeploymentPausedReasonError|BetaManagedAgentsWorkspaceArchivedDeploymentPausedReasonError|BetaManagedAgentsOrganizationDisabledDeploymentPausedReasonError|BetaManagedAgentsMemoryStoreArchivedDeploymentPausedReasonError|BetaManagedAgentsSkillNotFoundDeploymentPausedReasonError|BetaManagedAgentsVaultArchivedDeploymentPausedReasonError|BetaManagedAgentsUnknownDeploymentPausedReasonError|BetaManagedAgentsSelfHostedResourcesUnsupportedDeploymentPausedReasonError|BetaManagedAgentsMCPEgressBlockedDeploymentPausedReasonError $error;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new BetaManagedAgentsErrorDeploymentPausedReason()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsErrorDeploymentPausedReason::with(error: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsErrorDeploymentPausedReason)
     *   ->withError(...)
     *   ->withType(...)
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
     * @param BetaManagedAgentsDeploymentPausedReasonErrorShape $error
     * @param Type|value-of<Type> $type
     */
    public static function with(
        BetaManagedAgentsEnvironmentArchivedDeploymentPausedReasonError|array|BetaManagedAgentsAgentArchivedDeploymentPausedReasonError|BetaManagedAgentsEnvironmentNotFoundDeploymentPausedReasonError|BetaManagedAgentsVaultNotFoundDeploymentPausedReasonError|BetaManagedAgentsFileNotFoundDeploymentPausedReasonError|BetaManagedAgentsSessionResourceNotFoundDeploymentPausedReasonError|BetaManagedAgentsWorkspaceArchivedDeploymentPausedReasonError|BetaManagedAgentsOrganizationDisabledDeploymentPausedReasonError|BetaManagedAgentsMemoryStoreArchivedDeploymentPausedReasonError|BetaManagedAgentsSkillNotFoundDeploymentPausedReasonError|BetaManagedAgentsVaultArchivedDeploymentPausedReasonError|BetaManagedAgentsUnknownDeploymentPausedReasonError|BetaManagedAgentsSelfHostedResourcesUnsupportedDeploymentPausedReasonError|BetaManagedAgentsMCPEgressBlockedDeploymentPausedReasonError $error,
        Type|string $type,
    ): self {
        $self = new self;

        $self['error'] = $error;
        $self['type'] = $type;

        return $self;
    }

    /**
     * The error that triggered an auto-pause. Matches the failed run's `error.type`.
     *
     * @param BetaManagedAgentsDeploymentPausedReasonErrorShape $error
     */
    public function withError(
        BetaManagedAgentsEnvironmentArchivedDeploymentPausedReasonError|array|BetaManagedAgentsAgentArchivedDeploymentPausedReasonError|BetaManagedAgentsEnvironmentNotFoundDeploymentPausedReasonError|BetaManagedAgentsVaultNotFoundDeploymentPausedReasonError|BetaManagedAgentsFileNotFoundDeploymentPausedReasonError|BetaManagedAgentsSessionResourceNotFoundDeploymentPausedReasonError|BetaManagedAgentsWorkspaceArchivedDeploymentPausedReasonError|BetaManagedAgentsOrganizationDisabledDeploymentPausedReasonError|BetaManagedAgentsMemoryStoreArchivedDeploymentPausedReasonError|BetaManagedAgentsSkillNotFoundDeploymentPausedReasonError|BetaManagedAgentsVaultArchivedDeploymentPausedReasonError|BetaManagedAgentsUnknownDeploymentPausedReasonError|BetaManagedAgentsSelfHostedResourcesUnsupportedDeploymentPausedReasonError|BetaManagedAgentsMCPEgressBlockedDeploymentPausedReasonError $error,
    ): self {
        $self = clone $this;
        $self['error'] = $error;

        return $self;
    }

    /**
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
