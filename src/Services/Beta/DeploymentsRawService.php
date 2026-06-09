<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsDeploymentRun;
use Anthropic\Beta\Deployments\BetaManagedAgentsDeployment;
use Anthropic\Beta\Deployments\BetaManagedAgentsDeploymentStatus;
use Anthropic\Beta\Deployments\BetaManagedAgentsScheduleParams;
use Anthropic\Beta\Deployments\DeploymentArchiveParams;
use Anthropic\Beta\Deployments\DeploymentCreateParams;
use Anthropic\Beta\Deployments\DeploymentListParams;
use Anthropic\Beta\Deployments\DeploymentPauseParams;
use Anthropic\Beta\Deployments\DeploymentRetrieveParams;
use Anthropic\Beta\Deployments\DeploymentRunParams;
use Anthropic\Beta\Deployments\DeploymentUnpauseParams;
use Anthropic\Beta\Deployments\DeploymentUpdateParams;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\DeploymentsRawContract;

/**
 * @phpstan-import-type AgentShape from \Anthropic\Beta\Deployments\DeploymentCreateParams\Agent
 * @phpstan-import-type ResourceShape from \Anthropic\Beta\Deployments\DeploymentCreateParams\Resource
 * @phpstan-import-type AgentShape from \Anthropic\Beta\Deployments\DeploymentUpdateParams\Agent as AgentShape1
 * @phpstan-import-type ResourceShape from \Anthropic\Beta\Deployments\DeploymentUpdateParams\Resource as ResourceShape1
 * @phpstan-import-type BetaManagedAgentsDeploymentInitialEventParamsShape from \Anthropic\Beta\Deployments\BetaManagedAgentsDeploymentInitialEventParams
 * @phpstan-import-type BetaManagedAgentsScheduleParamsShape from \Anthropic\Beta\Deployments\BetaManagedAgentsScheduleParams
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class DeploymentsRawService implements DeploymentsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create Deployment
     *
     * @param array{
     *   agent: AgentShape,
     *   environmentID: string,
     *   initialEvents: list<BetaManagedAgentsDeploymentInitialEventParamsShape>,
     *   name: string,
     *   description?: string|null,
     *   metadata?: array<string,string>,
     *   resources?: list<ResourceShape>,
     *   schedule?: BetaManagedAgentsScheduleParams|BetaManagedAgentsScheduleParamsShape|null,
     *   vaultIDs?: list<string>,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|DeploymentCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaManagedAgentsDeployment>
     *
     * @throws APIException
     */
    public function create(
        array|DeploymentCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = DeploymentCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/deployments?beta=true',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: BetaManagedAgentsDeployment::class,
        );
    }

    /**
     * @api
     *
     * Get Deployment
     *
     * @param string $deploymentID Path parameter deployment_id
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|DeploymentRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaManagedAgentsDeployment>
     *
     * @throws APIException
     */
    public function retrieve(
        string $deploymentID,
        array|DeploymentRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = DeploymentRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/deployments/%1$s?beta=true', $deploymentID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: BetaManagedAgentsDeployment::class,
        );
    }

    /**
     * @api
     *
     * Update Deployment
     *
     * @param string $deploymentID Path param: Path parameter deployment_id
     * @param array{
     *   agent?: AgentShape1,
     *   description?: string|null,
     *   environmentID?: string,
     *   initialEvents?: list<BetaManagedAgentsDeploymentInitialEventParamsShape>,
     *   metadata?: array<string,string|null>|null,
     *   name?: string,
     *   resources?: list<ResourceShape1>|null,
     *   schedule?: BetaManagedAgentsScheduleParams|BetaManagedAgentsScheduleParamsShape|null,
     *   vaultIDs?: list<string>|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|DeploymentUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaManagedAgentsDeployment>
     *
     * @throws APIException
     */
    public function update(
        string $deploymentID,
        array|DeploymentUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = DeploymentUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/deployments/%1$s?beta=true', $deploymentID],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: BetaManagedAgentsDeployment::class,
        );
    }

    /**
     * @api
     *
     * List Deployments
     *
     * @param array{
     *   agentID?: string,
     *   createdAtGte?: \DateTimeInterface,
     *   createdAtLte?: \DateTimeInterface,
     *   includeArchived?: bool,
     *   limit?: int,
     *   page?: string,
     *   status?: BetaManagedAgentsDeploymentStatus|value-of<BetaManagedAgentsDeploymentStatus>,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|DeploymentListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaManagedAgentsDeployment>>
     *
     * @throws APIException
     */
    public function list(
        array|DeploymentListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = DeploymentListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(
            [
                'agentID',
                'createdAtGte',
                'createdAtLte',
                'includeArchived',
                'limit',
                'page',
                'status',
            ],
        );

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/deployments?beta=true',
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                [
                    'agentID' => 'agent_id',
                    'createdAtGte' => 'created_at[gte]',
                    'createdAtLte' => 'created_at[lte]',
                    'includeArchived' => 'include_archived',
                ],
            ),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: BetaManagedAgentsDeployment::class,
            page: PageCursor::class,
        );
    }

    /**
     * @api
     *
     * Archive Deployment
     *
     * @param string $deploymentID Path parameter deployment_id
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|DeploymentArchiveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaManagedAgentsDeployment>
     *
     * @throws APIException
     */
    public function archive(
        string $deploymentID,
        array|DeploymentArchiveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = DeploymentArchiveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/deployments/%1$s/archive?beta=true', $deploymentID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: BetaManagedAgentsDeployment::class,
        );
    }

    /**
     * @api
     *
     * Pause Deployment
     *
     * @param string $deploymentID Path parameter deployment_id
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|DeploymentPauseParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaManagedAgentsDeployment>
     *
     * @throws APIException
     */
    public function pause(
        string $deploymentID,
        array|DeploymentPauseParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = DeploymentPauseParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/deployments/%1$s/pause?beta=true', $deploymentID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: BetaManagedAgentsDeployment::class,
        );
    }

    /**
     * @api
     *
     * Run Deployment Now
     *
     * @param string $deploymentID Path parameter deployment_id
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|DeploymentRunParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaManagedAgentsDeploymentRun>
     *
     * @throws APIException
     */
    public function run(
        string $deploymentID,
        array|DeploymentRunParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = DeploymentRunParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/deployments/%1$s/run?beta=true', $deploymentID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: BetaManagedAgentsDeploymentRun::class,
        );
    }

    /**
     * @api
     *
     * Unpause Deployment
     *
     * @param string $deploymentID Path parameter deployment_id
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|DeploymentUnpauseParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaManagedAgentsDeployment>
     *
     * @throws APIException
     */
    public function unpause(
        string $deploymentID,
        array|DeploymentUnpauseParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = DeploymentUnpauseParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/deployments/%1$s/unpause?beta=true', $deploymentID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: BetaManagedAgentsDeployment::class,
        );
    }
}
