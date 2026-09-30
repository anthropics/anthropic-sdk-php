<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Organization;

use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Organization\ServiceAccounts\ServiceAccount;
use Anthropic\Organization\ServiceAccounts\ServiceAccountCreateParams;
use Anthropic\Organization\ServiceAccounts\ServiceAccountListParams;
use Anthropic\Organization\ServiceAccounts\ServiceAccountUpdateParams;
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
     * @param array<string,mixed>|ServiceAccountCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ServiceAccount>
     *
     * @throws APIException
     */
    public function create(
        array|ServiceAccountCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $serviceAccountID ID of the service account
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ServiceAccount>
     *
     * @throws APIException
     */
    public function retrieve(
        string $serviceAccountID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $serviceAccountID ID of the service account to update
     * @param array<string,mixed>|ServiceAccountUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ServiceAccount>
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
     * @param array<string,mixed>|ServiceAccountListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<ServiceAccount>>
     *
     * @throws APIException
     */
    public function list(
        array|ServiceAccountListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $serviceAccountID ID of the service account to archive
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ServiceAccount>
     *
     * @throws APIException
     */
    public function archive(
        string $serviceAccountID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;
}
