<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\MemoryStores;

use Anthropic\Beta\MemoryStores\MemoryVersions\ManagedAgentsMemoryVersion;
use Anthropic\Beta\MemoryStores\MemoryVersions\MemoryVersionListParams;
use Anthropic\Beta\MemoryStores\MemoryVersions\MemoryVersionRedactParams;
use Anthropic\Beta\MemoryStores\MemoryVersions\MemoryVersionRetrieveParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface MemoryVersionsRawContract
{
    /**
     * @api
     *
     * @param string $memoryVersionID Path param: Path parameter memory_version_id
     * @param array<string,mixed>|MemoryVersionRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ManagedAgentsMemoryVersion>
     *
     * @throws APIException
     */
    public function retrieve(
        string $memoryVersionID,
        array|MemoryVersionRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $memoryStoreID Path param: Path parameter memory_store_id
     * @param array<string,mixed>|MemoryVersionListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<ManagedAgentsMemoryVersion>>
     *
     * @throws APIException
     */
    public function list(
        string $memoryStoreID,
        array|MemoryVersionListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $memoryVersionID Path param: Path parameter memory_version_id
     * @param array<string,mixed>|MemoryVersionRedactParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ManagedAgentsMemoryVersion>
     *
     * @throws APIException
     */
    public function redact(
        string $memoryVersionID,
        array|MemoryVersionRedactParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
