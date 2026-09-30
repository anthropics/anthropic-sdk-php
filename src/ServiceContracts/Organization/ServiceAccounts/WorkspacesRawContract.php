<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Organization\ServiceAccounts;

use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Organization\ServiceAccounts\ServiceAccountWorkspaceMember;
use Anthropic\Organization\ServiceAccounts\Workspaces\WorkspaceAddParams;
use Anthropic\Organization\ServiceAccounts\Workspaces\WorkspaceListParams;
use Anthropic\Organization\ServiceAccounts\Workspaces\WorkspaceRemoveParams;
use Anthropic\Organization\ServiceAccounts\Workspaces\WorkspaceRemoveResponse;
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
     * @param string $serviceAccountID ID of the service account
     * @param array<string,mixed>|WorkspaceListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<ServiceAccountWorkspaceMember>>
     *
     * @throws APIException
     */
    public function list(
        string $serviceAccountID,
        array|WorkspaceListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $serviceAccountID ID of the service account
     * @param array<string,mixed>|WorkspaceAddParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ServiceAccountWorkspaceMember>
     *
     * @throws APIException
     */
    public function add(
        string $serviceAccountID,
        array|WorkspaceAddParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $workspaceID ID of the workspace
     * @param array<string,mixed>|WorkspaceRemoveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<WorkspaceRemoveResponse>
     *
     * @throws APIException
     */
    public function remove(
        string $workspaceID,
        array|WorkspaceRemoveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
