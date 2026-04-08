<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta;

use Anthropic\Beta\Agents\AgentArchiveParams;
use Anthropic\Beta\Agents\AgentCreateParams;
use Anthropic\Beta\Agents\AgentListParams;
use Anthropic\Beta\Agents\AgentRetrieveParams;
use Anthropic\Beta\Agents\AgentUpdateParams;
use Anthropic\Beta\Agents\BetaManagedAgentsAgent;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface AgentsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|AgentCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaManagedAgentsAgent>
     *
     * @throws APIException
     */
    public function create(
        array|AgentCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $agentID Path param: Path parameter agent_id
     * @param array<string,mixed>|AgentRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaManagedAgentsAgent>
     *
     * @throws APIException
     */
    public function retrieve(
        string $agentID,
        array|AgentRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $agentID Path param: Path parameter agent_id
     * @param array<string,mixed>|AgentUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaManagedAgentsAgent>
     *
     * @throws APIException
     */
    public function update(
        string $agentID,
        array|AgentUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|AgentListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaManagedAgentsAgent>>
     *
     * @throws APIException
     */
    public function list(
        array|AgentListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $agentID Path parameter agent_id
     * @param array<string,mixed>|AgentArchiveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaManagedAgentsAgent>
     *
     * @throws APIException
     */
    public function archive(
        string $agentID,
        array|AgentArchiveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
