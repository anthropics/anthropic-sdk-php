<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization;

use Anthropic\Beta\Organization\ServiceAccounts\ServiceAccount;
use Anthropic\Beta\Organization\ServiceAccounts\ServiceAccountArchiveParams;
use Anthropic\Beta\Organization\ServiceAccounts\ServiceAccountCreateParams;
use Anthropic\Beta\Organization\ServiceAccounts\ServiceAccountListParams;
use Anthropic\Beta\Organization\ServiceAccounts\ServiceAccountRetrieveParams;
use Anthropic\Beta\Organization\ServiceAccounts\ServiceAccountUpdateParams;
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
     * @param array<string,mixed>|ServiceAccountRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ServiceAccount>
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
     * @param string $serviceAccountID path param: ID of the service account to update
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
     * @param array<string,mixed>|ServiceAccountArchiveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ServiceAccount>
     *
     * @throws APIException
     */
    public function archive(
        string $serviceAccountID,
        array|ServiceAccountArchiveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
