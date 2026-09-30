<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Organization;

use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Organization\Workspaces\Workspace;
use Anthropic\Organization\Workspaces\WorkspaceCreateParams;
use Anthropic\Organization\Workspaces\WorkspaceListParams;
use Anthropic\Organization\Workspaces\WorkspaceUpdateParams;
use Anthropic\Page;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface WorkspacesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|WorkspaceCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Workspace>
     *
     * @throws APIException
     */
    public function create(
        array|WorkspaceCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $workspaceID ID of the Workspace
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Workspace>
     *
     * @throws APIException
     */
    public function retrieve(
        string $workspaceID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|WorkspaceUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Workspace>
     *
     * @throws APIException
     */
    public function update(
        string $workspaceID,
        array|WorkspaceUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|WorkspaceListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Page<Workspace>>
     *
     * @throws APIException
     */
    public function list(
        array|WorkspaceListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Workspace>
     *
     * @throws APIException
     */
    public function archive(
        string $workspaceID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;
}
