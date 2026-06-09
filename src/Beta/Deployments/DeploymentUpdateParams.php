<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Deployments\DeploymentUpdateParams\Resource;
use Anthropic\Beta\Sessions\BetaManagedAgentsAgentParams;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\MapOf;

/**
 * Update Deployment.
 *
 * @see Anthropic\Services\Beta\DeploymentsService::update()
 *
 * @phpstan-import-type AgentVariants from \Anthropic\Beta\Deployments\DeploymentUpdateParams\Agent
 * @phpstan-import-type BetaManagedAgentsDeploymentInitialEventParamsVariants from \Anthropic\Beta\Deployments\BetaManagedAgentsDeploymentInitialEventParams
 * @phpstan-import-type ResourceVariants from \Anthropic\Beta\Deployments\DeploymentUpdateParams\Resource
 * @phpstan-import-type AgentShape from \Anthropic\Beta\Deployments\DeploymentUpdateParams\Agent
 * @phpstan-import-type BetaManagedAgentsDeploymentInitialEventParamsShape from \Anthropic\Beta\Deployments\BetaManagedAgentsDeploymentInitialEventParams
 * @phpstan-import-type ResourceShape from \Anthropic\Beta\Deployments\DeploymentUpdateParams\Resource
 * @phpstan-import-type BetaManagedAgentsScheduleParamsShape from \Anthropic\Beta\Deployments\BetaManagedAgentsScheduleParams
 *
 * @phpstan-type DeploymentUpdateParamsShape = array{
 *   agent?: AgentShape|null,
 *   description?: string|null,
 *   environmentID?: string|null,
 *   initialEvents?: list<BetaManagedAgentsDeploymentInitialEventParamsShape>|null,
 *   metadata?: array<string,string|null>|null,
 *   name?: string|null,
 *   resources?: list<ResourceShape>|null,
 *   schedule?: null|BetaManagedAgentsScheduleParams|BetaManagedAgentsScheduleParamsShape,
 *   vaultIDs?: list<string>|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class DeploymentUpdateParams implements BaseModel
{
    /** @use SdkModel<DeploymentUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Agent to deploy. Accepts the `agent` ID string, which re-pins to the latest version, or an `agent` object with both id and version specified. Omit to preserve. Cannot be cleared.
     *
     * @var AgentVariants|null $agent
     */
    #[Optional]
    public string|BetaManagedAgentsAgentParams|null $agent;

    /**
     * Description. Omit to preserve; send empty string or null to clear.
     */
    #[Optional(nullable: true)]
    public ?string $description;

    /**
     * ID of the `environment` where sessions run. Omit to preserve. Cannot be cleared.
     */
    #[Optional('environment_id')]
    public ?string $environmentID;

    /**
     * Initial events. Full replacement. Omit to preserve. Cannot be cleared. At least 1, maximum 50.
     *
     * @var list<BetaManagedAgentsDeploymentInitialEventParamsVariants>|null $initialEvents
     */
    #[Optional(
        'initial_events',
        list: BetaManagedAgentsDeploymentInitialEventParams::class
    )]
    public ?array $initialEvents;

    /**
     * Metadata patch. Set a key to a string to upsert it, or to null to delete it. Omit the field to preserve. The stored bag is limited to 16 keys (up to 64 chars each) with values up to 512 chars.
     *
     * @var array<string,string|null>|null $metadata
     */
    #[Optional(type: new MapOf('string', nullable: true), nullable: true)]
    public ?array $metadata;

    /**
     * Human-readable name. Must be non-empty. Omit to preserve. Cannot be cleared.
     */
    #[Optional]
    public ?string $name;

    /**
     * Session resources. Full replacement. Omit to preserve; send empty array or null to clear. Maximum 500.
     *
     * @var list<ResourceVariants>|null $resources
     */
    #[Optional(list: Resource::class, nullable: true)]
    public ?array $resources;

    /**
     * 5-field POSIX cron schedule. Literal wall-clock matching in the configured timezone.
     */
    #[Optional(nullable: true)]
    public ?BetaManagedAgentsScheduleParams $schedule;

    /**
     * Vault IDs. Full replacement. Omit to preserve; send empty array or null to clear. Maximum 50.
     *
     * @var list<string>|null $vaultIDs
     */
    #[Optional('vault_ids', list: 'string', nullable: true)]
    public ?array $vaultIDs;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param AgentShape|null $agent
     * @param list<BetaManagedAgentsDeploymentInitialEventParamsShape>|null $initialEvents
     * @param array<string,string|null>|null $metadata
     * @param list<ResourceShape>|null $resources
     * @param BetaManagedAgentsScheduleParams|BetaManagedAgentsScheduleParamsShape|null $schedule
     * @param list<string>|null $vaultIDs
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        string|BetaManagedAgentsAgentParams|array|null $agent = null,
        ?string $description = null,
        ?string $environmentID = null,
        ?array $initialEvents = null,
        ?array $metadata = null,
        ?string $name = null,
        ?array $resources = null,
        BetaManagedAgentsScheduleParams|array|null $schedule = null,
        ?array $vaultIDs = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        null !== $agent && $self['agent'] = $agent;
        null !== $description && $self['description'] = $description;
        null !== $environmentID && $self['environmentID'] = $environmentID;
        null !== $initialEvents && $self['initialEvents'] = $initialEvents;
        null !== $metadata && $self['metadata'] = $metadata;
        null !== $name && $self['name'] = $name;
        null !== $resources && $self['resources'] = $resources;
        null !== $schedule && $self['schedule'] = $schedule;
        null !== $vaultIDs && $self['vaultIDs'] = $vaultIDs;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Agent to deploy. Accepts the `agent` ID string, which re-pins to the latest version, or an `agent` object with both id and version specified. Omit to preserve. Cannot be cleared.
     *
     * @param AgentShape $agent
     */
    public function withAgent(
        string|BetaManagedAgentsAgentParams|array $agent
    ): self {
        $self = clone $this;
        $self['agent'] = $agent;

        return $self;
    }

    /**
     * Description. Omit to preserve; send empty string or null to clear.
     */
    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * ID of the `environment` where sessions run. Omit to preserve. Cannot be cleared.
     */
    public function withEnvironmentID(string $environmentID): self
    {
        $self = clone $this;
        $self['environmentID'] = $environmentID;

        return $self;
    }

    /**
     * Initial events. Full replacement. Omit to preserve. Cannot be cleared. At least 1, maximum 50.
     *
     * @param list<BetaManagedAgentsDeploymentInitialEventParamsShape> $initialEvents
     */
    public function withInitialEvents(array $initialEvents): self
    {
        $self = clone $this;
        $self['initialEvents'] = $initialEvents;

        return $self;
    }

    /**
     * Metadata patch. Set a key to a string to upsert it, or to null to delete it. Omit the field to preserve. The stored bag is limited to 16 keys (up to 64 chars each) with values up to 512 chars.
     *
     * @param array<string,string|null>|null $metadata
     */
    public function withMetadata(?array $metadata): self
    {
        $self = clone $this;
        $self['metadata'] = $metadata;

        return $self;
    }

    /**
     * Human-readable name. Must be non-empty. Omit to preserve. Cannot be cleared.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Session resources. Full replacement. Omit to preserve; send empty array or null to clear. Maximum 500.
     *
     * @param list<ResourceShape>|null $resources
     */
    public function withResources(?array $resources): self
    {
        $self = clone $this;
        $self['resources'] = $resources;

        return $self;
    }

    /**
     * 5-field POSIX cron schedule. Literal wall-clock matching in the configured timezone.
     *
     * @param BetaManagedAgentsScheduleParams|BetaManagedAgentsScheduleParamsShape|null $schedule
     */
    public function withSchedule(
        BetaManagedAgentsScheduleParams|array|null $schedule
    ): self {
        $self = clone $this;
        $self['schedule'] = $schedule;

        return $self;
    }

    /**
     * Vault IDs. Full replacement. Omit to preserve; send empty array or null to clear. Maximum 50.
     *
     * @param list<string>|null $vaultIDs
     */
    public function withVaultIDs(?array $vaultIDs): self
    {
        $self = clone $this;
        $self['vaultIDs'] = $vaultIDs;

        return $self;
    }

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas
     */
    public function withBetas(array $betas): self
    {
        $self = clone $this;
        $self['betas'] = $betas;

        return $self;
    }
}
