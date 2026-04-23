<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\MemoryStores;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsDeletedMemory;
use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsMemory;
use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsMemoryListItem;
use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsMemoryPrefix;
use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsMemoryView;
use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsPrecondition;
use Anthropic\Beta\MemoryStores\Memories\MemoryCreateParams;
use Anthropic\Beta\MemoryStores\Memories\MemoryDeleteParams;
use Anthropic\Beta\MemoryStores\Memories\MemoryListParams;
use Anthropic\Beta\MemoryStores\Memories\MemoryListParams\Order;
use Anthropic\Beta\MemoryStores\Memories\MemoryRetrieveParams;
use Anthropic\Beta\MemoryStores\Memories\MemoryUpdateParams;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\MemoryStores\MemoriesRawContract;

/**
 * @phpstan-import-type ManagedAgentsPreconditionShape from \Anthropic\Beta\MemoryStores\Memories\ManagedAgentsPrecondition
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class MemoriesRawService implements MemoriesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * CreateMemory
     *
     * @param string $memoryStoreID Path param: Path parameter memory_store_id
     * @param array{
     *   content: string|null,
     *   path: string,
     *   view?: ManagedAgentsMemoryView|value-of<ManagedAgentsMemoryView>,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|MemoryCreateParams $params
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
    ): BaseResponse {
        [$parsed, $options] = MemoryCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(['view']);
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/memory_stores/%1$s/memories?beta=true', $memoryStoreID],
            query: array_intersect_key($parsed, $query_params),
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys([...$query_params, ...$header_params]))
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: ManagedAgentsMemory::class,
        );
    }

    /**
     * @api
     *
     * GetMemory
     *
     * @param string $memoryID Path param: Path parameter memory_id
     * @param array{
     *   memoryStoreID: string,
     *   view?: ManagedAgentsMemoryView|value-of<ManagedAgentsMemoryView>,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|MemoryRetrieveParams $params
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
    ): BaseResponse {
        [$parsed, $options] = MemoryRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );
        $memoryStoreID = $parsed['memoryStoreID'];
        unset($parsed['memoryStoreID']);
        $query_params = array_flip(['view']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: [
                'v1/memory_stores/%1$s/memories/%2$s?beta=true',
                $memoryStoreID,
                $memoryID,
            ],
            query: array_intersect_key($parsed, $query_params),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: ManagedAgentsMemory::class,
        );
    }

    /**
     * @api
     *
     * UpdateMemory
     *
     * @param string $memoryID Path param: Path parameter memory_id
     * @param array{
     *   memoryStoreID: string,
     *   view?: ManagedAgentsMemoryView|value-of<ManagedAgentsMemoryView>,
     *   content?: string|null,
     *   path?: string|null,
     *   precondition?: ManagedAgentsPrecondition|ManagedAgentsPreconditionShape,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|MemoryUpdateParams $params
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
    ): BaseResponse {
        [$parsed, $options] = MemoryUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $memoryStoreID = $parsed['memoryStoreID'];
        unset($parsed['memoryStoreID']);
        $query_params = array_flip(['view']);
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/memory_stores/%1$s/memories/%2$s?beta=true',
                $memoryStoreID,
                $memoryID,
            ],
            query: array_intersect_key($parsed, $query_params),
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                array_diff_key(
                    $parsed,
                    array_flip(array_keys([...$query_params, ...$header_params]))
                ),
                array_flip(['memoryStoreID']),
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: ManagedAgentsMemory::class,
        );
    }

    /**
     * @api
     *
     * ListMemories
     *
     * @param string $memoryStoreID Path param: Path parameter memory_store_id
     * @param array{
     *   depth?: int,
     *   limit?: int,
     *   order?: Order|value-of<Order>,
     *   orderBy?: string,
     *   page?: string,
     *   pathPrefix?: string,
     *   view?: ManagedAgentsMemoryView|value-of<ManagedAgentsMemoryView>,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|MemoryListParams $params
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
    ): BaseResponse {
        [$parsed, $options] = MemoryListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(
            ['depth', 'limit', 'order', 'orderBy', 'page', 'pathPrefix', 'view']
        );

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/memory_stores/%1$s/memories?beta=true', $memoryStoreID],
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                ['orderBy' => 'order_by', 'pathPrefix' => 'path_prefix'],
            ),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: ManagedAgentsMemoryListItem::class,
            page: PageCursor::class,
        );
    }

    /**
     * @api
     *
     * DeleteMemory
     *
     * @param string $memoryID Path param: Path parameter memory_id
     * @param array{
     *   memoryStoreID: string,
     *   expectedContentSha256?: string,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|MemoryDeleteParams $params
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
    ): BaseResponse {
        [$parsed, $options] = MemoryDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );
        $memoryStoreID = $parsed['memoryStoreID'];
        unset($parsed['memoryStoreID']);
        $query_params = array_flip(['expectedContentSha256']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: [
                'v1/memory_stores/%1$s/memories/%2$s?beta=true',
                $memoryStoreID,
                $memoryID,
            ],
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                ['expectedContentSha256' => 'expected_content_sha256'],
            ),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: ManagedAgentsDeletedMemory::class,
        );
    }
}
