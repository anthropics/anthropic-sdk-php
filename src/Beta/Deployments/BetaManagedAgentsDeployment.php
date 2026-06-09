<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments;

use Anthropic\Beta\Agents\BetaManagedAgentsAgentReference;
use Anthropic\Beta\Deployments\BetaManagedAgentsDeployment\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A deployment is a configured instance of an agent — it binds the agent to everything needed to run it autonomously: an environment, credentials, initial events, and an optional schedule.
 *
 * @phpstan-import-type BetaManagedAgentsDeploymentInitialEventVariants from \Anthropic\Beta\Deployments\BetaManagedAgentsDeploymentInitialEvent
 * @phpstan-import-type BetaManagedAgentsDeploymentPausedReasonVariants from \Anthropic\Beta\Deployments\BetaManagedAgentsDeploymentPausedReason
 * @phpstan-import-type BetaManagedAgentsSessionResourceConfigVariants from \Anthropic\Beta\Deployments\BetaManagedAgentsSessionResourceConfig
 * @phpstan-import-type BetaManagedAgentsAgentReferenceShape from \Anthropic\Beta\Agents\BetaManagedAgentsAgentReference
 * @phpstan-import-type BetaManagedAgentsDeploymentInitialEventShape from \Anthropic\Beta\Deployments\BetaManagedAgentsDeploymentInitialEvent
 * @phpstan-import-type BetaManagedAgentsDeploymentPausedReasonShape from \Anthropic\Beta\Deployments\BetaManagedAgentsDeploymentPausedReason
 * @phpstan-import-type BetaManagedAgentsSessionResourceConfigShape from \Anthropic\Beta\Deployments\BetaManagedAgentsSessionResourceConfig
 * @phpstan-import-type BetaManagedAgentsScheduleShape from \Anthropic\Beta\Deployments\BetaManagedAgentsSchedule
 *
 * @phpstan-type BetaManagedAgentsDeploymentShape = array{
 *   id: string,
 *   agent: BetaManagedAgentsAgentReference|BetaManagedAgentsAgentReferenceShape,
 *   archivedAt: \DateTimeInterface|null,
 *   createdAt: \DateTimeInterface,
 *   description: string|null,
 *   environmentID: string,
 *   initialEvents: list<BetaManagedAgentsDeploymentInitialEventShape>,
 *   metadata: array<string,string>,
 *   name: string,
 *   pausedReason: BetaManagedAgentsDeploymentPausedReasonShape|null,
 *   resources: list<BetaManagedAgentsSessionResourceConfigShape>,
 *   schedule: null|BetaManagedAgentsSchedule|BetaManagedAgentsScheduleShape,
 *   status: BetaManagedAgentsDeploymentStatus|value-of<BetaManagedAgentsDeploymentStatus>,
 *   type: Type|value-of<Type>,
 *   updatedAt: \DateTimeInterface,
 *   vaultIDs: list<string>,
 * }
 */
final class BetaManagedAgentsDeployment implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsDeploymentShape> */
    use SdkModel;

    /**
     * Unique identifier for this deployment.
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
    #[Required('archived_at')]
    public ?\DateTimeInterface $archivedAt;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * Description of what the deployment does.
     */
    #[Required]
    public ?string $description;

    /**
     * ID of the `environment` where sessions run.
     */
    #[Required('environment_id')]
    public string $environmentID;

    /**
     * Events sent to each session immediately after creation.
     *
     * @var list<BetaManagedAgentsDeploymentInitialEventVariants> $initialEvents
     */
    #[Required(
        'initial_events',
        list: BetaManagedAgentsDeploymentInitialEvent::class
    )]
    public array $initialEvents;

    /**
     * Arbitrary key-value metadata. Maximum 16 pairs.
     *
     * @var array<string,string> $metadata
     */
    #[Required(map: 'string')]
    public array $metadata;

    /**
     * Human-readable name.
     */
    #[Required]
    public string $name;

    /**
     * Why a deployment is paused. Non-null exactly when `status` is `paused`.
     *
     * @var BetaManagedAgentsDeploymentPausedReasonVariants|null $pausedReason
     */
    #[Required(
        'paused_reason',
        union: BetaManagedAgentsDeploymentPausedReason::class
    )]
    public BetaManagedAgentsManualDeploymentPausedReason|BetaManagedAgentsErrorDeploymentPausedReason|null $pausedReason;

    /**
     * Resources attached to sessions created from this deployment. Echoes the input minus write-only credentials.
     *
     * @var list<BetaManagedAgentsSessionResourceConfigVariants> $resources
     */
    #[Required(list: BetaManagedAgentsSessionResourceConfig::class)]
    public array $resources;

    /**
     * 5-field POSIX cron schedule with computed runtime timestamps.
     */
    #[Required]
    public ?BetaManagedAgentsSchedule $schedule;

    /**
     * Lifecycle status of a deployment.
     *
     * @var value-of<BetaManagedAgentsDeploymentStatus> $status
     */
    #[Required(enum: BetaManagedAgentsDeploymentStatus::class)]
    public string $status;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('updated_at')]
    public \DateTimeInterface $updatedAt;

    /**
     * Vault IDs supplying stored credentials for sessions created from this deployment.
     *
     * @var list<string> $vaultIDs
     */
    #[Required('vault_ids', list: 'string')]
    public array $vaultIDs;

    /**
     * `new BetaManagedAgentsDeployment()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsDeployment::with(
     *   id: ...,
     *   agent: ...,
     *   archivedAt: ...,
     *   createdAt: ...,
     *   description: ...,
     *   environmentID: ...,
     *   initialEvents: ...,
     *   metadata: ...,
     *   name: ...,
     *   pausedReason: ...,
     *   resources: ...,
     *   schedule: ...,
     *   status: ...,
     *   type: ...,
     *   updatedAt: ...,
     *   vaultIDs: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsDeployment)
     *   ->withID(...)
     *   ->withAgent(...)
     *   ->withArchivedAt(...)
     *   ->withCreatedAt(...)
     *   ->withDescription(...)
     *   ->withEnvironmentID(...)
     *   ->withInitialEvents(...)
     *   ->withMetadata(...)
     *   ->withName(...)
     *   ->withPausedReason(...)
     *   ->withResources(...)
     *   ->withSchedule(...)
     *   ->withStatus(...)
     *   ->withType(...)
     *   ->withUpdatedAt(...)
     *   ->withVaultIDs(...)
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
     * @param list<BetaManagedAgentsDeploymentInitialEventShape> $initialEvents
     * @param array<string,string> $metadata
     * @param BetaManagedAgentsDeploymentPausedReasonShape|null $pausedReason
     * @param list<BetaManagedAgentsSessionResourceConfigShape> $resources
     * @param BetaManagedAgentsSchedule|BetaManagedAgentsScheduleShape|null $schedule
     * @param BetaManagedAgentsDeploymentStatus|value-of<BetaManagedAgentsDeploymentStatus> $status
     * @param Type|value-of<Type> $type
     * @param list<string> $vaultIDs
     */
    public static function with(
        string $id,
        BetaManagedAgentsAgentReference|array $agent,
        ?\DateTimeInterface $archivedAt,
        \DateTimeInterface $createdAt,
        ?string $description,
        string $environmentID,
        array $initialEvents,
        array $metadata,
        string $name,
        BetaManagedAgentsManualDeploymentPausedReason|array|BetaManagedAgentsErrorDeploymentPausedReason|null $pausedReason,
        array $resources,
        BetaManagedAgentsSchedule|array|null $schedule,
        BetaManagedAgentsDeploymentStatus|string $status,
        Type|string $type,
        \DateTimeInterface $updatedAt,
        array $vaultIDs,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['agent'] = $agent;
        $self['archivedAt'] = $archivedAt;
        $self['createdAt'] = $createdAt;
        $self['description'] = $description;
        $self['environmentID'] = $environmentID;
        $self['initialEvents'] = $initialEvents;
        $self['metadata'] = $metadata;
        $self['name'] = $name;
        $self['pausedReason'] = $pausedReason;
        $self['resources'] = $resources;
        $self['schedule'] = $schedule;
        $self['status'] = $status;
        $self['type'] = $type;
        $self['updatedAt'] = $updatedAt;
        $self['vaultIDs'] = $vaultIDs;

        return $self;
    }

    /**
     * Unique identifier for this deployment.
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
    public function withArchivedAt(?\DateTimeInterface $archivedAt): self
    {
        $self = clone $this;
        $self['archivedAt'] = $archivedAt;

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
     * Description of what the deployment does.
     */
    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * ID of the `environment` where sessions run.
     */
    public function withEnvironmentID(string $environmentID): self
    {
        $self = clone $this;
        $self['environmentID'] = $environmentID;

        return $self;
    }

    /**
     * Events sent to each session immediately after creation.
     *
     * @param list<BetaManagedAgentsDeploymentInitialEventShape> $initialEvents
     */
    public function withInitialEvents(array $initialEvents): self
    {
        $self = clone $this;
        $self['initialEvents'] = $initialEvents;

        return $self;
    }

    /**
     * Arbitrary key-value metadata. Maximum 16 pairs.
     *
     * @param array<string,string> $metadata
     */
    public function withMetadata(array $metadata): self
    {
        $self = clone $this;
        $self['metadata'] = $metadata;

        return $self;
    }

    /**
     * Human-readable name.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Why a deployment is paused. Non-null exactly when `status` is `paused`.
     *
     * @param BetaManagedAgentsDeploymentPausedReasonShape|null $pausedReason
     */
    public function withPausedReason(
        BetaManagedAgentsManualDeploymentPausedReason|array|BetaManagedAgentsErrorDeploymentPausedReason|null $pausedReason,
    ): self {
        $self = clone $this;
        $self['pausedReason'] = $pausedReason;

        return $self;
    }

    /**
     * Resources attached to sessions created from this deployment. Echoes the input minus write-only credentials.
     *
     * @param list<BetaManagedAgentsSessionResourceConfigShape> $resources
     */
    public function withResources(array $resources): self
    {
        $self = clone $this;
        $self['resources'] = $resources;

        return $self;
    }

    /**
     * 5-field POSIX cron schedule with computed runtime timestamps.
     *
     * @param BetaManagedAgentsSchedule|BetaManagedAgentsScheduleShape|null $schedule
     */
    public function withSchedule(
        BetaManagedAgentsSchedule|array|null $schedule
    ): self {
        $self = clone $this;
        $self['schedule'] = $schedule;

        return $self;
    }

    /**
     * Lifecycle status of a deployment.
     *
     * @param BetaManagedAgentsDeploymentStatus|value-of<BetaManagedAgentsDeploymentStatus> $status
     */
    public function withStatus(
        BetaManagedAgentsDeploymentStatus|string $status
    ): self {
        $self = clone $this;
        $self['status'] = $status;

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

    /**
     * A timestamp in RFC 3339 format.
     */
    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * Vault IDs supplying stored credentials for sessions created from this deployment.
     *
     * @param list<string> $vaultIDs
     */
    public function withVaultIDs(array $vaultIDs): self
    {
        $self = clone $this;
        $self['vaultIDs'] = $vaultIDs;

        return $self;
    }
}
