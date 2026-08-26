<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\Federation\Rules;

use Anthropic\Beta\Organization\Federation\Rules\BetaFederationRuleWorkspace;
use Anthropic\Beta\Organization\Federation\Rules\Workspaces\WorkspaceAddParams;
use Anthropic\Beta\Organization\Federation\Rules\Workspaces\WorkspaceListParams;
use Anthropic\Beta\Organization\Federation\Rules\Workspaces\WorkspaceRemoveParams;
use Anthropic\Beta\Organization\Federation\Rules\Workspaces\WorkspaceRemoveResponse;
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
     * @param string $federationRuleID path param: ID of the federation rule
     * @param array<string,mixed>|WorkspaceListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaFederationRuleWorkspace>>
     *
     * @throws APIException
     */
    public function list(
        string $federationRuleID,
        array|WorkspaceListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $federationRuleID path param: ID of the federation rule
     * @param array<string,mixed>|WorkspaceAddParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaFederationRuleWorkspace>
     *
     * @throws APIException
     */
    public function add(
        string $federationRuleID,
        array|WorkspaceAddParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $workspaceID path param: ID of the workspace to disable for
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
