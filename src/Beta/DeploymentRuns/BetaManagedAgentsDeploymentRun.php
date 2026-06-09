<?php

declare(strict_types=1);

namespace Anthropic\Beta\DeploymentRuns;

use Anthropic\Beta\Agents\BetaManagedAgentsAgentReference;
use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsDeploymentRun\Error;
use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsDeploymentRun\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A persistent, append-only record of a single deployment execution. Records session creation success or failure — no session lifecycle tracking.
 *
 * @phpstan-import-type ErrorVariants from \Anthropic\Beta\DeploymentRuns\BetaManagedAgentsDeploymentRun\Error
 * @phpstan-import-type BetaManagedAgentsTriggerContextVariants from \Anthropic\Beta\DeploymentRuns\BetaManagedAgentsTriggerContext
 * @phpstan-import-type BetaManagedAgentsAgentReferenceShape from \Anthropic\Beta\Agents\BetaManagedAgentsAgentReference
 * @phpstan-import-type ErrorShape from \Anthropic\Beta\DeploymentRuns\BetaManagedAgentsDeploymentRun\Error
 * @phpstan-import-type BetaManagedAgentsTriggerContextShape from \Anthropic\Beta\DeploymentRuns\BetaManagedAgentsTriggerContext
 *
 * @phpstan-type BetaManagedAgentsDeploymentRunShape = array{
 *   id: string,
 *   agent: BetaManagedAgentsAgentReference|BetaManagedAgentsAgentReferenceShape,
 *   createdAt: \DateTimeInterface,
 *   deploymentID: string,
 *   error: ErrorShape|null,
 *   sessionID: string|null,
 *   triggerContext: BetaManagedAgentsTriggerContextShape,
 *   type: Type|value-of<Type>,
 * }
 */
final class BetaManagedAgentsDeploymentRun implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsDeploymentRunShape> */
    use SdkModel;

    /**
     * Unique identifier for this run (`drun_...`).
     */
    #[Required]
    public string $id;

    /**
     * A resolved agent reference with a concrete version.
     */
    #[Required]
    public BetaManagedAgentsAgentReference $agent;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * ID of the deployment that produced this run.
     */
    #[Required('deployment_id')]
    public string $deploymentID;

    /**
     * Why the run failed to create a session. The type identifies the failure; message is human-readable detail.
     *
     * @var ErrorVariants|null $error
     */
    #[Required(union: Error::class)]
    public BetaManagedAgentsEnvironmentArchivedRunError|BetaManagedAgentsAgentArchivedRunError|BetaManagedAgentsEnvironmentNotFoundRunError|BetaManagedAgentsVaultNotFoundRunError|BetaManagedAgentsVaultArchivedRunError|BetaManagedAgentsFileNotFoundRunError|BetaManagedAgentsMemoryStoreArchivedRunError|BetaManagedAgentsSkillNotFoundRunError|BetaManagedAgentsSessionResourceNotFoundRunError|BetaManagedAgentsWorkspaceArchivedRunError|BetaManagedAgentsOrganizationDisabledRunError|BetaManagedAgentsSessionRateLimitedRunError|BetaManagedAgentsSessionCreationRejectedRunError|BetaManagedAgentsUnknownRunError|BetaManagedAgentsSelfHostedResourcesUnsupportedRunError|BetaManagedAgentsMCPEgressBlockedRunError|null $error;

    /**
     * Populated on success. Null on creation failure. Exactly one of session_id or error is non-null.
     */
    #[Required('session_id')]
    public ?string $sessionID;

    /**
     * Describes what triggered a deployment run, with trigger-specific metadata.
     *
     * @var BetaManagedAgentsTriggerContextVariants $triggerContext
     */
    #[Required('trigger_context', union: BetaManagedAgentsTriggerContext::class)]
    public BetaManagedAgentsScheduleTriggerContext|BetaManagedAgentsManualTriggerContext $triggerContext;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new BetaManagedAgentsDeploymentRun()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsDeploymentRun::with(
     *   id: ...,
     *   agent: ...,
     *   createdAt: ...,
     *   deploymentID: ...,
     *   error: ...,
     *   sessionID: ...,
     *   triggerContext: ...,
     *   type: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsDeploymentRun)
     *   ->withID(...)
     *   ->withAgent(...)
     *   ->withCreatedAt(...)
     *   ->withDeploymentID(...)
     *   ->withError(...)
     *   ->withSessionID(...)
     *   ->withTriggerContext(...)
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
     * @param BetaManagedAgentsAgentReference|BetaManagedAgentsAgentReferenceShape $agent
     * @param ErrorShape|null $error
     * @param BetaManagedAgentsTriggerContextShape $triggerContext
     * @param Type|value-of<Type> $type
     */
    public static function with(
        string $id,
        BetaManagedAgentsAgentReference|array $agent,
        \DateTimeInterface $createdAt,
        string $deploymentID,
        BetaManagedAgentsEnvironmentArchivedRunError|array|BetaManagedAgentsAgentArchivedRunError|BetaManagedAgentsEnvironmentNotFoundRunError|BetaManagedAgentsVaultNotFoundRunError|BetaManagedAgentsVaultArchivedRunError|BetaManagedAgentsFileNotFoundRunError|BetaManagedAgentsMemoryStoreArchivedRunError|BetaManagedAgentsSkillNotFoundRunError|BetaManagedAgentsSessionResourceNotFoundRunError|BetaManagedAgentsWorkspaceArchivedRunError|BetaManagedAgentsOrganizationDisabledRunError|BetaManagedAgentsSessionRateLimitedRunError|BetaManagedAgentsSessionCreationRejectedRunError|BetaManagedAgentsUnknownRunError|BetaManagedAgentsSelfHostedResourcesUnsupportedRunError|BetaManagedAgentsMCPEgressBlockedRunError|null $error,
        ?string $sessionID,
        BetaManagedAgentsScheduleTriggerContext|array|BetaManagedAgentsManualTriggerContext $triggerContext,
        Type|string $type,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['agent'] = $agent;
        $self['createdAt'] = $createdAt;
        $self['deploymentID'] = $deploymentID;
        $self['error'] = $error;
        $self['sessionID'] = $sessionID;
        $self['triggerContext'] = $triggerContext;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Unique identifier for this run (`drun_...`).
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * A resolved agent reference with a concrete version.
     *
     * @param BetaManagedAgentsAgentReference|BetaManagedAgentsAgentReferenceShape $agent
     */
    public function withAgent(
        BetaManagedAgentsAgentReference|array $agent
    ): self {
        $self = clone $this;
        $self['agent'] = $agent;

        return $self;
    }

    /**
     * A timestamp in RFC 3339 format.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * ID of the deployment that produced this run.
     */
    public function withDeploymentID(string $deploymentID): self
    {
        $self = clone $this;
        $self['deploymentID'] = $deploymentID;

        return $self;
    }

    /**
     * Why the run failed to create a session. The type identifies the failure; message is human-readable detail.
     *
     * @param ErrorShape|null $error
     */
    public function withError(
        BetaManagedAgentsEnvironmentArchivedRunError|array|BetaManagedAgentsAgentArchivedRunError|BetaManagedAgentsEnvironmentNotFoundRunError|BetaManagedAgentsVaultNotFoundRunError|BetaManagedAgentsVaultArchivedRunError|BetaManagedAgentsFileNotFoundRunError|BetaManagedAgentsMemoryStoreArchivedRunError|BetaManagedAgentsSkillNotFoundRunError|BetaManagedAgentsSessionResourceNotFoundRunError|BetaManagedAgentsWorkspaceArchivedRunError|BetaManagedAgentsOrganizationDisabledRunError|BetaManagedAgentsSessionRateLimitedRunError|BetaManagedAgentsSessionCreationRejectedRunError|BetaManagedAgentsUnknownRunError|BetaManagedAgentsSelfHostedResourcesUnsupportedRunError|BetaManagedAgentsMCPEgressBlockedRunError|null $error,
    ): self {
        $self = clone $this;
        $self['error'] = $error;

        return $self;
    }

    /**
     * Populated on success. Null on creation failure. Exactly one of session_id or error is non-null.
     */
    public function withSessionID(?string $sessionID): self
    {
        $self = clone $this;
        $self['sessionID'] = $sessionID;

        return $self;
    }

    /**
     * Describes what triggered a deployment run, with trigger-specific metadata.
     *
     * @param BetaManagedAgentsTriggerContextShape $triggerContext
     */
    public function withTriggerContext(
        BetaManagedAgentsScheduleTriggerContext|array|BetaManagedAgentsManualTriggerContext $triggerContext,
    ): self {
        $self = clone $this;
        $self['triggerContext'] = $triggerContext;

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
