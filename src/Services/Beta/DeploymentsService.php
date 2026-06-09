<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsDeploymentRun;
use Anthropic\Beta\Deployments\BetaManagedAgentsDeployment;
use Anthropic\Beta\Deployments\BetaManagedAgentsDeploymentStatus;
use Anthropic\Beta\Deployments\BetaManagedAgentsScheduleParams;
use Anthropic\Beta\Sessions\BetaManagedAgentsAgentParams;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\DeploymentsContract;

/**
 * @phpstan-import-type AgentShape from \Anthropic\Beta\Deployments\DeploymentCreateParams\Agent
 * @phpstan-import-type ResourceShape from \Anthropic\Beta\Deployments\DeploymentCreateParams\Resource
 * @phpstan-import-type AgentShape from \Anthropic\Beta\Deployments\DeploymentUpdateParams\Agent as AgentShape1
 * @phpstan-import-type ResourceShape from \Anthropic\Beta\Deployments\DeploymentUpdateParams\Resource as ResourceShape1
 * @phpstan-import-type BetaManagedAgentsDeploymentInitialEventParamsShape from \Anthropic\Beta\Deployments\BetaManagedAgentsDeploymentInitialEventParams
 * @phpstan-import-type BetaManagedAgentsScheduleParamsShape from \Anthropic\Beta\Deployments\BetaManagedAgentsScheduleParams
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class DeploymentsService implements DeploymentsContract
{
    /**
     * @api
     */
    public DeploymentsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new DeploymentsRawService($client);
    }

    /**
     * @api
     *
     * Create Deployment
     *
     * @param AgentShape $agent Body param: Agent to deploy. Accepts the `agent` ID string, which pins the latest version, or an `agent` object with both id and version specified. The agent must exist and not be archived.
     * @param string $environmentID body param: ID of the `environment` defining the container configuration for sessions created from this deployment
     * @param list<BetaManagedAgentsDeploymentInitialEventParamsShape> $initialEvents Body param: Events to send to each session immediately after creation. At least 1, maximum 50.
     * @param string $name body param: Human-readable name for the deployment
     * @param string|null $description body param: Description of what the deployment does
     * @param array<string,string> $metadata Body param: Arbitrary key-value metadata. Maximum 16 pairs, keys up to 64 chars, values up to 512 chars.
     * @param list<ResourceShape> $resources Body param: Resources (e.g. repositories, files) to mount into each session's container. Maximum 500.
     * @param BetaManagedAgentsScheduleParams|BetaManagedAgentsScheduleParamsShape|null $schedule Body param: 5-field POSIX cron schedule. Literal wall-clock matching in the configured timezone.
     * @param list<string> $vaultIDs Body param: Vault IDs for stored credentials the agent can use during sessions created from this deployment. Maximum 50.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
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
        RequestOptions|array|null $requestOptions = null,
    ): BetaManagedAgentsDeployment {
        $params = Util::removeNulls(
            [
                'agent' => $agent,
                'environmentID' => $environmentID,
                'initialEvents' => $initialEvents,
                'name' => $name,
                'description' => $description,
                'metadata' => $metadata,
                'resources' => $resources,
                'schedule' => $schedule,
                'vaultIDs' => $vaultIDs,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get Deployment
     *
     * @param string $deploymentID Path parameter deployment_id
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $deploymentID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaManagedAgentsDeployment {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($deploymentID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Update Deployment
     *
     * @param string $deploymentID Path param: Path parameter deployment_id
     * @param AgentShape1 $agent Body param: Agent to deploy. Accepts the `agent` ID string, which re-pins to the latest version, or an `agent` object with both id and version specified. Omit to preserve. Cannot be cleared.
     * @param string|null $description Body param: Description. Omit to preserve; send empty string or null to clear.
     * @param string $environmentID Body param: ID of the `environment` where sessions run. Omit to preserve. Cannot be cleared.
     * @param list<BetaManagedAgentsDeploymentInitialEventParamsShape> $initialEvents Body param: Initial events. Full replacement. Omit to preserve. Cannot be cleared. At least 1, maximum 50.
     * @param array<string,string|null>|null $metadata Body param: Metadata patch. Set a key to a string to upsert it, or to null to delete it. Omit the field to preserve. The stored bag is limited to 16 keys (up to 64 chars each) with values up to 512 chars.
     * @param string $name Body param: Human-readable name. Must be non-empty. Omit to preserve. Cannot be cleared.
     * @param list<ResourceShape1>|null $resources Body param: Session resources. Full replacement. Omit to preserve; send empty array or null to clear. Maximum 500.
     * @param BetaManagedAgentsScheduleParams|BetaManagedAgentsScheduleParamsShape|null $schedule Body param: 5-field POSIX cron schedule. Literal wall-clock matching in the configured timezone.
     * @param list<string>|null $vaultIDs Body param: Vault IDs. Full replacement. Omit to preserve; send empty array or null to clear. Maximum 50.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $deploymentID,
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
        RequestOptions|array|null $requestOptions = null,
    ): BetaManagedAgentsDeployment {
        $params = Util::removeNulls(
            [
                'agent' => $agent,
                'description' => $description,
                'environmentID' => $environmentID,
                'initialEvents' => $initialEvents,
                'metadata' => $metadata,
                'name' => $name,
                'resources' => $resources,
                'schedule' => $schedule,
                'vaultIDs' => $vaultIDs,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($deploymentID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List Deployments
     *
     * @param string $agentID query param: Filter by agent ID
     * @param \DateTimeInterface $createdAtGte query param: Return deployments created at or after this time (inclusive)
     * @param \DateTimeInterface $createdAtLte query param: Return deployments created at or before this time (inclusive)
     * @param bool $includeArchived Query param: When true, includes archived deployments. Default: false (exclude archived).
     * @param int $limit Query param: Maximum results per page. Default 20, maximum 100.
     * @param string $page query param: Opaque pagination cursor
     * @param BetaManagedAgentsDeploymentStatus|value-of<BetaManagedAgentsDeploymentStatus> $status Query param: Filter by status: active or paused. Omit for both. To include archived deployments, use include_archived instead; the two cannot be combined.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<BetaManagedAgentsDeployment>
     *
     * @throws APIException
     */
    public function list(
        ?string $agentID = null,
        ?\DateTimeInterface $createdAtGte = null,
        ?\DateTimeInterface $createdAtLte = null,
        ?bool $includeArchived = null,
        ?int $limit = null,
        ?string $page = null,
        BetaManagedAgentsDeploymentStatus|string|null $status = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor {
        $params = Util::removeNulls(
            [
                'agentID' => $agentID,
                'createdAtGte' => $createdAtGte,
                'createdAtLte' => $createdAtLte,
                'includeArchived' => $includeArchived,
                'limit' => $limit,
                'page' => $page,
                'status' => $status,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Archive Deployment
     *
     * @param string $deploymentID Path parameter deployment_id
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function archive(
        string $deploymentID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaManagedAgentsDeployment {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->archive($deploymentID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Pause Deployment
     *
     * @param string $deploymentID Path parameter deployment_id
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function pause(
        string $deploymentID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaManagedAgentsDeployment {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->pause($deploymentID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Run Deployment Now
     *
     * @param string $deploymentID Path parameter deployment_id
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function run(
        string $deploymentID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaManagedAgentsDeploymentRun {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->run($deploymentID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Unpause Deployment
     *
     * @param string $deploymentID Path parameter deployment_id
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function unpause(
        string $deploymentID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaManagedAgentsDeployment {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->unpause($deploymentID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
