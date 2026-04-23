<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\MemoryStores;

use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsDeletedMemory;
use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsMemory;
use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsMemoryPrefix;
use Anthropic\Beta\MemoryStores\Memories\MemoryCreateParams;
use Anthropic\Beta\MemoryStores\Memories\MemoryDeleteParams;
use Anthropic\Beta\MemoryStores\Memories\MemoryListParams;
use Anthropic\Beta\MemoryStores\Memories\MemoryRetrieveParams;
use Anthropic\Beta\MemoryStores\Memories\MemoryUpdateParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface MemoriesRawContract
{
    /**
     * @api
     *
     * @param string $memoryStoreID Path param: Path parameter memory_store_id
     * @param array<string,mixed>|MemoryCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ManagedAgentsMemory>
     *
     * @throws APIException
     */
    public function create(
        string $memoryStoreID,
        array|MemoryCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $memoryID Path param: Path parameter memory_id
     * @param array<string,mixed>|MemoryRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ManagedAgentsMemory>
     *
     * @throws APIException
     */
    public function retrieve(
        string $memoryID,
        array|MemoryRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $memoryID Path param: Path parameter memory_id
     * @param array<string,mixed>|MemoryUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ManagedAgentsMemory>
     *
     * @throws APIException
     */
    public function update(
        string $memoryID,
        array|MemoryUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $memoryStoreID Path param: Path parameter memory_store_id
     * @param array<string,mixed>|MemoryListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<ManagedAgentsMemory|ManagedAgentsMemoryPrefix>>
     *
     * @throws APIException
     */
    public function list(
        string $memoryStoreID,
        array|MemoryListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $memoryID Path param: Path parameter memory_id
     * @param array<string,mixed>|MemoryDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ManagedAgentsDeletedMemory>
     *
     * @throws APIException
     */
    public function delete(
        string $memoryID,
        array|MemoryDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
