<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\Workspaces;

use Anthropic\Beta\Organization\ServiceAccounts\ServiceAccountWorkspaceMember;
use Anthropic\Beta\Organization\Workspaces\ServiceAccounts\ServiceAccountAddParams;
use Anthropic\Beta\Organization\Workspaces\ServiceAccounts\ServiceAccountListParams;
use Anthropic\Beta\Organization\Workspaces\ServiceAccounts\ServiceAccountRemoveParams;
use Anthropic\Beta\Organization\Workspaces\ServiceAccounts\ServiceAccountRemoveResponse;
use Anthropic\Beta\Organization\Workspaces\ServiceAccounts\ServiceAccountRetrieveParams;
use Anthropic\Beta\Organization\Workspaces\ServiceAccounts\ServiceAccountUpdateParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface ServiceAccountsRawContract
{
    /**
     * @api
     *
     * @param string $serviceAccountID path param: ID of the service account
     * @param array<string,mixed>|ServiceAccountRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ServiceAccountWorkspaceMember>
     *
     * @throws APIException
     */
    public function retrieve(
        string $serviceAccountID,
        array|ServiceAccountRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $serviceAccountID path param: ID of the service account
     * @param array<string,mixed>|ServiceAccountUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ServiceAccountWorkspaceMember>
     *
     * @throws APIException
     */
    public function update(
        string $serviceAccountID,
        array|ServiceAccountUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $workspaceID path param: ID of the workspace
     * @param array<string,mixed>|ServiceAccountListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<ServiceAccountWorkspaceMember>>
     *
     * @throws APIException
     */
    public function list(
        string $workspaceID,
        array|ServiceAccountListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $workspaceID path param: ID of the workspace
     * @param array<string,mixed>|ServiceAccountAddParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ServiceAccountWorkspaceMember>
     *
     * @throws APIException
     */
    public function add(
        string $workspaceID,
        array|ServiceAccountAddParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $serviceAccountID path param: ID of the service account
     * @param array<string,mixed>|ServiceAccountRemoveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ServiceAccountRemoveResponse>
     *
     * @throws APIException
     */
    public function remove(
        string $serviceAccountID,
        array|ServiceAccountRemoveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
