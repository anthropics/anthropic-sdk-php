<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Agents;

use Anthropic\Beta\Agents\BetaManagedAgentsAgent;
use Anthropic\Beta\Agents\Versions\VersionListParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface VersionsRawContract
{
    /**
     * @api
     *
     * @param string $agentID Path param: Path parameter agent_id
     * @param array<string,mixed>|VersionListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaManagedAgentsAgent>>
     *
     * @throws APIException
     */
    public function list(
        string $agentID,
        array|VersionListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
