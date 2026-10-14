<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\TelemetryDestinations;

use Anthropic\Beta\Organization\TelemetryDestinations\Workspaces\BetaDeletedTelemetryDestinationWorkspace;
use Anthropic\Beta\Organization\TelemetryDestinations\Workspaces\BetaTelemetryDestinationWorkspace;
use Anthropic\Beta\Organization\TelemetryDestinations\Workspaces\WorkspaceAddParams;
use Anthropic\Beta\Organization\TelemetryDestinations\Workspaces\WorkspaceListParams;
use Anthropic\Beta\Organization\TelemetryDestinations\Workspaces\WorkspaceRemoveParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface WorkspacesRawContract
{
    /**
     * @api
     *
     * @param string $destinationID Path param: ID of the destination (`tdst_...`).
     * @param array<string,mixed>|WorkspaceListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaTelemetryDestinationWorkspace>>
     *
     * @throws APIException
     */
    public function list(
        string $destinationID,
        array|WorkspaceListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $workspaceID Path param: ID of the workspace to add (`wrkspc_...`).
     * @param array<string,mixed>|WorkspaceAddParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaTelemetryDestinationWorkspace>
     *
     * @throws APIException
     */
    public function add(
        string $workspaceID,
        array|WorkspaceAddParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $workspaceID Path param: ID of the workspace to remove (`wrkspc_...`).
     * @param array<string,mixed>|WorkspaceRemoveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaDeletedTelemetryDestinationWorkspace>
     *
     * @throws APIException
     */
    public function remove(
        string $workspaceID,
        array|WorkspaceRemoveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
