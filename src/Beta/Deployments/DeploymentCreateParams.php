<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Deployments\DeploymentCreateParams\Resource;
use Anthropic\Beta\Sessions\BetaManagedAgentsAgentParams;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Create Deployment.
 *
 * @see Anthropic\Services\Beta\DeploymentsService::create()
 *
 * @phpstan-import-type AgentVariants from \Anthropic\Beta\Deployments\DeploymentCreateParams\Agent
 * @phpstan-import-type BetaManagedAgentsDeploymentInitialEventParamsVariants from \Anthropic\Beta\Deployments\BetaManagedAgentsDeploymentInitialEventParams
 * @phpstan-import-type ResourceVariants from \Anthropic\Beta\Deployments\DeploymentCreateParams\Resource
 * @phpstan-import-type AgentShape from \Anthropic\Beta\Deployments\DeploymentCreateParams\Agent
 * @phpstan-import-type BetaManagedAgentsDeploymentInitialEventParamsShape from \Anthropic\Beta\Deployments\BetaManagedAgentsDeploymentInitialEventParams
 * @phpstan-import-type ResourceShape from \Anthropic\Beta\Deployments\DeploymentCreateParams\Resource
 * @phpstan-import-type BetaManagedAgentsScheduleParamsShape from \Anthropic\Beta\Deployments\BetaManagedAgentsScheduleParams
 *
 * @phpstan-type DeploymentCreateParamsShape = array{
 *   agent: AgentShape,
 *   environmentID: string,
 *   initialEvents: list<BetaManagedAgentsDeploymentInitialEventParamsShape>,
 *   name: string,
 *   description?: string|null,
 *   metadata?: array<string,string>|null,
 *   resources?: list<ResourceShape>|null,
 *   schedule?: null|BetaManagedAgentsScheduleParams|BetaManagedAgentsScheduleParamsShape,
 *   vaultIDs?: list<string>|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class DeploymentCreateParams implements BaseModel
{
    /** @use SdkModel<DeploymentCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Agent to deploy. Accepts the `agent` ID string, which pins the latest version, or an `agent` object with both id and version specified. The agent must exist and not be archived.
     *
     * @var AgentVariants $agent
     */
    #[Required]
    public string|BetaManagedAgentsAgentParams $agent;

    /**
     * ID of the `environment` defining the container configuration for sessions created from this deployment.
     */
    #[Required('environment_id')]
    public string $environmentID;

    /**
     * Events to send to each session immediately after creation. At least 1, maximum 50.
     *
     * @var list<BetaManagedAgentsDeploymentInitialEventParamsVariants> $initialEvents
     */
    #[Required(
        'initial_events',
        list: BetaManagedAgentsDeploymentInitialEventParams::class
    )]
    public array $initialEvents;

    /**
     * Human-readable name for the deployment.
     */
    #[Required]
    public string $name;

    /**
     * Description of what the deployment does.
     */
    #[Optional(nullable: true)]
    public ?string $description;

    /**
     * Arbitrary key-value metadata. Maximum 16 pairs, keys up to 64 chars, values up to 512 chars.
     *
     * @var array<string,string>|null $metadata
     */
    #[Optional(map: 'string')]
    public ?array $metadata;

    /**
     * Resources (e.g. repositories, files) to mount into each session's container. Maximum 500.
     *
     * @var list<ResourceVariants>|null $resources
     */
    #[Optional(list: Resource::class)]
    public ?array $resources;

    /**
     * 5-field POSIX cron schedule. Literal wall-clock matching in the configured timezone.
     */
    #[Optional(nullable: true)]
    public ?BetaManagedAgentsScheduleParams $schedule;

    /**
     * Vault IDs for stored credentials the agent can use during sessions created from this deployment. Maximum 50.
     *
     * @var list<string>|null $vaultIDs
     */
    #[Optional('vault_ids', list: 'string')]
    public ?array $vaultIDs;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new DeploymentCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * DeploymentCreateParams::with(
     *   agent: ..., environmentID: ..., initialEvents: ..., name: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new DeploymentCreateParams)
     *   ->withAgent(...)
     *   ->withEnvironmentID(...)
     *   ->withInitialEvents(...)
     *   ->withName(...)
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
     * @param AgentShape $agent
     * @param list<BetaManagedAgentsDeploymentInitialEventParamsShape> $initialEvents
     * @param array<string,string>|null $metadata
     * @param list<ResourceShape>|null $resources
     * @param BetaManagedAgentsScheduleParams|BetaManagedAgentsScheduleParamsShape|null $schedule
     * @param list<string>|null $vaultIDs
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        string|BetaManagedAgentsAgentParams|array $agent,
        string $environmentID,
        array $initialEvents,
        string $name,
        ?string $description = null,
        ?array $metadata = null,
        ?array $resources = null,
        BetaManagedAgentsScheduleParams|array|null $schedule = null,
        ?array $vaultIDs = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        $self['agent'] = $agent;
        $self['environmentID'] = $environmentID;
        $self['initialEvents'] = $initialEvents;
        $self['name'] = $name;

        null !== $description && $self['description'] = $description;
        null !== $metadata && $self['metadata'] = $metadata;
        null !== $resources && $self['resources'] = $resources;
        null !== $schedule && $self['schedule'] = $schedule;
        null !== $vaultIDs && $self['vaultIDs'] = $vaultIDs;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Agent to deploy. Accepts the `agent` ID string, which pins the latest version, or an `agent` object with both id and version specified. The agent must exist and not be archived.
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
     * ID of the `environment` defining the container configuration for sessions created from this deployment.
     */
    public function withEnvironmentID(string $environmentID): self
    {
        $self = clone $this;
        $self['environmentID'] = $environmentID;

        return $self;
    }

    /**
     * Events to send to each session immediately after creation. At least 1, maximum 50.
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
     * Human-readable name for the deployment.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

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
     * Arbitrary key-value metadata. Maximum 16 pairs, keys up to 64 chars, values up to 512 chars.
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
     * Resources (e.g. repositories, files) to mount into each session's container. Maximum 500.
     *
     * @param list<ResourceShape> $resources
     */
    public function withResources(array $resources): self
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
     * Vault IDs for stored credentials the agent can use during sessions created from this deployment. Maximum 50.
     *
     * @param list<string> $vaultIDs
     */
    public function withVaultIDs(array $vaultIDs): self
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
