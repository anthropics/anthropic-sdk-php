<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta;

use Anthropic\Beta\DeploymentRuns\BetaManagedAgentsDeploymentRun;
use Anthropic\Beta\DeploymentRuns\DeploymentRunListParams;
use Anthropic\Beta\DeploymentRuns\DeploymentRunRetrieveParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface DeploymentRunsRawContract
{
    /**
     * @api
     *
     * @param string $deploymentRunID Path parameter deployment_run_id
     * @param array<string,mixed>|DeploymentRunRetrieveParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|DeploymentRunListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaManagedAgentsDeploymentRun>>
     *
     * @throws APIException
     */
    public function list(
        array|DeploymentRunListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
