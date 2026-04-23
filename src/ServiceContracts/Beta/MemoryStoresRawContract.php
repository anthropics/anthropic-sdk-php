<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta;

use Anthropic\Beta\MemoryStores\BetaManagedAgentsDeletedMemoryStore;
use Anthropic\Beta\MemoryStores\BetaManagedAgentsMemoryStore;
use Anthropic\Beta\MemoryStores\MemoryStoreArchiveParams;
use Anthropic\Beta\MemoryStores\MemoryStoreCreateParams;
use Anthropic\Beta\MemoryStores\MemoryStoreDeleteParams;
use Anthropic\Beta\MemoryStores\MemoryStoreListParams;
use Anthropic\Beta\MemoryStores\MemoryStoreRetrieveParams;
use Anthropic\Beta\MemoryStores\MemoryStoreUpdateParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface MemoryStoresRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|MemoryStoreCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaManagedAgentsMemoryStore>
     *
     * @throws APIException
     */
    public function create(
        array|MemoryStoreCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $memoryStoreID Path parameter memory_store_id
     * @param array<string,mixed>|MemoryStoreRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaManagedAgentsMemoryStore>
     *
     * @throws APIException
     */
    public function retrieve(
        string $memoryStoreID,
        array|MemoryStoreRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $memoryStoreID Path param: Path parameter memory_store_id
     * @param array<string,mixed>|MemoryStoreUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaManagedAgentsMemoryStore>
     *
     * @throws APIException
     */
    public function update(
        string $memoryStoreID,
        array|MemoryStoreUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|MemoryStoreListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaManagedAgentsMemoryStore>>
     *
     * @throws APIException
     */
    public function list(
        array|MemoryStoreListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $memoryStoreID Path parameter memory_store_id
     * @param array<string,mixed>|MemoryStoreDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaManagedAgentsDeletedMemoryStore>
     *
     * @throws APIException
     */
    public function delete(
        string $memoryStoreID,
        array|MemoryStoreDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $memoryStoreID Path parameter memory_store_id
     * @param array<string,mixed>|MemoryStoreArchiveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaManagedAgentsMemoryStore>
     *
     * @throws APIException
     */
    public function archive(
        string $memoryStoreID,
        array|MemoryStoreArchiveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
