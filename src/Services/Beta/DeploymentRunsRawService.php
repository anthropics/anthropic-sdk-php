<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsDeploymentRun;
use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsTriggerType;
use Anthropic\Beta\DeploymentRuns\DeploymentRunListParams;
use Anthropic\Beta\DeploymentRuns\DeploymentRunRetrieveParams;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\DeploymentRunsRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class DeploymentRunsRawService implements DeploymentRunsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Get Deployment Run
     *
     * @param string $deploymentRunID Path parameter deployment_run_id
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|DeploymentRunRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaManagedAgentsDeploymentRun>
     *
     * @throws APIException
     */
    public function retrieve(
        string $deploymentRunID,
        array|DeploymentRunRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = DeploymentRunRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/deployment_runs/%1$s?beta=true', $deploymentRunID],
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
     * List Deployment Runs
     *
     * @param array{
     *   createdAtGt?: \DateTimeInterface,
     *   createdAtGte?: \DateTimeInterface,
     *   createdAtLt?: \DateTimeInterface,
     *   createdAtLte?: \DateTimeInterface,
     *   deploymentID?: string,
     *   hasError?: bool,
     *   limit?: int,
     *   page?: string,
     *   triggerType?: BetaManagedAgentsTriggerType|value-of<BetaManagedAgentsTriggerType>,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|DeploymentRunListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaManagedAgentsDeploymentRun>>
     *
     * @throws APIException
     */
    public function list(
        array|DeploymentRunListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = DeploymentRunListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(
            [
                'createdAtGt',
                'createdAtGte',
                'createdAtLt',
                'createdAtLte',
                'deploymentID',
                'hasError',
                'limit',
                'page',
                'triggerType',
            ],
        );

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/deployment_runs?beta=true',
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                [
                    'createdAtGt' => 'created_at[gt]',
                    'createdAtGte' => 'created_at[gte]',
                    'createdAtLt' => 'created_at[lt]',
                    'createdAtLte' => 'created_at[lte]',
                    'deploymentID' => 'deployment_id',
                    'hasError' => 'has_error',
                    'triggerType' => 'trigger_type',
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
            convert: BetaManagedAgentsDeploymentRun::class,
            page: PageCursor::class,
        );
    }
}
