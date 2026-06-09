<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta;

use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsDeploymentRun;
use Anthropic\Beta\Deployments\BetaManagedAgentsDeployment;
use Anthropic\Beta\Deployments\DeploymentArchiveParams;
use Anthropic\Beta\Deployments\DeploymentCreateParams;
use Anthropic\Beta\Deployments\DeploymentListParams;
use Anthropic\Beta\Deployments\DeploymentPauseParams;
use Anthropic\Beta\Deployments\DeploymentRetrieveParams;
use Anthropic\Beta\Deployments\DeploymentRunParams;
use Anthropic\Beta\Deployments\DeploymentUnpauseParams;
use Anthropic\Beta\Deployments\DeploymentUpdateParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface DeploymentsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|DeploymentCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaManagedAgentsDeployment>
     *
     * @throws APIException
     */
    public function create(
        array|DeploymentCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $deploymentID Path parameter deployment_id
     * @param array<string,mixed>|DeploymentRetrieveParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $deploymentID Path param: Path parameter deployment_id
     * @param array<string,mixed>|DeploymentUpdateParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|DeploymentListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaManagedAgentsDeployment>>
     *
     * @throws APIException
     */
    public function list(
        array|DeploymentListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $deploymentID Path parameter deployment_id
     * @param array<string,mixed>|DeploymentArchiveParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $deploymentID Path parameter deployment_id
     * @param array<string,mixed>|DeploymentPauseParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $deploymentID Path parameter deployment_id
     * @param array<string,mixed>|DeploymentRunParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $deploymentID Path parameter deployment_id
     * @param array<string,mixed>|DeploymentUnpauseParams $params
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
    ): BaseResponse;
}
