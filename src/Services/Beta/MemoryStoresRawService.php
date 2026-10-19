<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\MemoryStores\BetaManagedAgentsDeletedMemoryStore;
use Anthropic\Beta\MemoryStores\BetaManagedAgentsMemoryStore;
use Anthropic\Beta\MemoryStores\MemoryStoreArchiveParams;
use Anthropic\Beta\MemoryStores\MemoryStoreCreateParams;
use Anthropic\Beta\MemoryStores\MemoryStoreDeleteParams;
use Anthropic\Beta\MemoryStores\MemoryStoreListParams;
use Anthropic\Beta\MemoryStores\MemoryStoreRetrieveParams;
use Anthropic\Beta\MemoryStores\MemoryStoreUpdateParams;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Implementation\ApiCallInfo;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\MemoryStoresRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class MemoryStoresRawService implements MemoryStoresRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create a Memory Store
     *
     * @param array{
     *   name: string,
     *   description?: string,
     *   metadata?: array<string,string>,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     *   workspaceID?: string,
     * }|MemoryStoreCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaManagedAgentsMemoryStore>
     *
     * @throws APIException
     */
    public function create(
        array|MemoryStoreCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = MemoryStoreCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = [
            'betas' => 'anthropic-beta', 'workspaceID' => 'anthropic-workspace-id',
        ];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/memory_stores?beta=true',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'agent-memory-2026-07-22']],
                $options,
            )->withApiCall(new ApiCallInfo(
                name: 'anthropic.memory_stores.create',
                route: '/v1/memory_stores',
                createdId: 'gen_ai.memory.store.id',
            )),
            convert: BetaManagedAgentsMemoryStore::class,
        );
    }

    /**
     * @api
     *
     * Retrieve a Memory Store
     *
     * @param string $memoryStoreID The ID of the memory store to retrieve (`memstore_...`).
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     *   workspaceID?: string,
     * }|MemoryStoreRetrieveParams $params
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
    ): BaseResponse {
        [$parsed, $options] = MemoryStoreRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/memory_stores/%1$s?beta=true', $memoryStoreID],
            headers: Util::array_transform_keys(
                $parsed,
                [
                    'betas' => 'anthropic-beta', 'workspaceID' => 'anthropic-workspace-id',
                ],
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'agent-memory-2026-07-22']],
                $options,
            )->withApiCall(new ApiCallInfo(
                name: 'anthropic.memory_stores.retrieve',
                route: '/v1/memory_stores/{memory_store_id}',
                attributes: ['gen_ai.memory.store.id' => $memoryStoreID],
            )),
            convert: BetaManagedAgentsMemoryStore::class,
        );
    }

    /**
     * @api
     *
     * Update a Memory Store
     *
     * @param string $memoryStoreID Path param: The ID of the memory store to update (`memstore_...`).
     *
     * The request fails with HTTP status 400 if the store is archived.
     * @param array{
     *   description?: string|null,
     *   metadata?: array<string,string|null>|null,
     *   name?: string|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     *   workspaceID?: string,
     * }|MemoryStoreUpdateParams $params
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
    ): BaseResponse {
        [$parsed, $options] = MemoryStoreUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = [
            'betas' => 'anthropic-beta', 'workspaceID' => 'anthropic-workspace-id',
        ];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/memory_stores/%1$s?beta=true', $memoryStoreID],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'agent-memory-2026-07-22']],
                $options,
            )->withApiCall(new ApiCallInfo(
                name: 'anthropic.memory_stores.update',
                route: '/v1/memory_stores/{memory_store_id}',
                attributes: ['gen_ai.memory.store.id' => $memoryStoreID],
            )),
            convert: BetaManagedAgentsMemoryStore::class,
        );
    }

    /**
     * @api
     *
     * List Memory Stores
     *
     * @param array{
     *   createdAtGte?: \DateTimeInterface,
     *   createdAtLte?: \DateTimeInterface,
     *   includeArchived?: bool,
     *   limit?: int,
     *   page?: string,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     *   workspaceID?: string,
     * }|MemoryStoreListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaManagedAgentsMemoryStore>>
     *
     * @throws APIException
     */
    public function list(
        array|MemoryStoreListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = MemoryStoreListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(
            ['createdAtGte', 'createdAtLte', 'includeArchived', 'limit', 'page']
        );

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/memory_stores?beta=true',
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                [
                    'createdAtGte' => 'created_at[gte]',
                    'createdAtLte' => 'created_at[lte]',
                    'includeArchived' => 'include_archived',
                ],
            ),
            headers: Util::array_transform_keys(
                $header_params,
                [
                    'betas' => 'anthropic-beta', 'workspaceID' => 'anthropic-workspace-id',
                ],
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'agent-memory-2026-07-22']],
                $options,
            )->withApiCall(new ApiCallInfo(
                name: 'anthropic.memory_stores.list',
                route: '/v1/memory_stores',
                query: [
                    'created_at[gte]',
                    'created_at[lte]',
                    'include_archived',
                    'limit',
                    'page',
                ],
            )),
            convert: BetaManagedAgentsMemoryStore::class,
            page: PageCursor::class,
        );
    }

    /**
     * @api
     *
     * Delete a Memory Store
     *
     * @param string $memoryStoreID The ID of the memory store to delete (`memstore_...`).
     *
     * Deleting a store also deletes all its memories and memory versions. It can't be undone.
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     *   workspaceID?: string,
     * }|MemoryStoreDeleteParams $params
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
    ): BaseResponse {
        [$parsed, $options] = MemoryStoreDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/memory_stores/%1$s?beta=true', $memoryStoreID],
            headers: Util::array_transform_keys(
                $parsed,
                [
                    'betas' => 'anthropic-beta', 'workspaceID' => 'anthropic-workspace-id',
                ],
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'agent-memory-2026-07-22']],
                $options,
            )->withApiCall(new ApiCallInfo(
                name: 'anthropic.memory_stores.delete',
                route: '/v1/memory_stores/{memory_store_id}',
                attributes: ['gen_ai.memory.store.id' => $memoryStoreID],
            )),
            convert: BetaManagedAgentsDeletedMemoryStore::class,
        );
    }

    /**
     * @api
     *
     * Archive a Memory Store
     *
     * @param string $memoryStoreID The ID of the memory store to archive (`memstore_...`).
     *
     * Archiving can't be undone. Archiving a store that is already archived returns it unchanged.
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     *   workspaceID?: string,
     * }|MemoryStoreArchiveParams $params
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
    ): BaseResponse {
        [$parsed, $options] = MemoryStoreArchiveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/memory_stores/%1$s/archive?beta=true', $memoryStoreID],
            headers: Util::array_transform_keys(
                $parsed,
                [
                    'betas' => 'anthropic-beta', 'workspaceID' => 'anthropic-workspace-id',
                ],
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'agent-memory-2026-07-22']],
                $options,
            )->withApiCall(new ApiCallInfo(
                name: 'anthropic.memory_stores.archive',
                route: '/v1/memory_stores/{memory_store_id}/archive',
                attributes: ['gen_ai.memory.store.id' => $memoryStoreID],
            )),
            convert: BetaManagedAgentsMemoryStore::class,
        );
    }
}
