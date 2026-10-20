<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\MemoryStores;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsMemoryView;
use Anthropic\Beta\MemoryStores\MemoryVersions\ManagedAgentsMemoryVersion;
use Anthropic\Beta\MemoryStores\MemoryVersions\ManagedAgentsMemoryVersionOperation;
use Anthropic\Beta\MemoryStores\MemoryVersions\MemoryVersionListParams;
use Anthropic\Beta\MemoryStores\MemoryVersions\MemoryVersionRedactParams;
use Anthropic\Beta\MemoryStores\MemoryVersions\MemoryVersionRetrieveParams;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Implementation\ApiCallInfo;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\MemoryStores\MemoryVersionsRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class MemoryVersionsRawService implements MemoryVersionsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Retrieve a Memory Version
     *
     * @param string $memoryVersionID Path param: The ID of the memory version to retrieve (`memver_...`).
     * @param array{
     *   memoryStoreID: string,
     *   view?: ManagedAgentsMemoryView|value-of<ManagedAgentsMemoryView>,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     *   workspaceID?: string,
     * }|MemoryVersionRetrieveParams $params
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
    ): BaseResponse {
        [$parsed, $options] = MemoryVersionRetrieveParams::parseRequest(
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
                'v1/memory_stores/%1$s/memory_versions/%2$s?beta=true',
                $memoryStoreID,
                $memoryVersionID,
            ],
            query: array_intersect_key($parsed, $query_params),
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
                name: 'anthropic.memory_stores.memory_versions.retrieve',
                route: '/v1/memory_stores/{memory_store_id}/memory_versions/{memory_version_id}',
                query: ['view'],
                attributes: [
                    'gen_ai.memory.store.id' => $memoryStoreID,
                    'anthropic.memory_store.memory_version.id' => $memoryVersionID,
                ],
            )),
            convert: ManagedAgentsMemoryVersion::class,
        );
    }

    /**
     * @api
     *
     * List Memory Versions
     *
     * @param string $memoryStoreID Path param: The ID of the memory store whose version history to list (`memstore_...`).
     * @param array{
     *   apiKeyID?: string,
     *   createdAtGte?: \DateTimeInterface,
     *   createdAtLte?: \DateTimeInterface,
     *   limit?: int,
     *   memoryID?: string,
     *   operation?: ManagedAgentsMemoryVersionOperation|value-of<ManagedAgentsMemoryVersionOperation>,
     *   page?: string,
     *   serviceAccountID?: string,
     *   sessionID?: string,
     *   view?: ManagedAgentsMemoryView|value-of<ManagedAgentsMemoryView>,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     *   workspaceID?: string,
     * }|MemoryVersionListParams $params
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
    ): BaseResponse {
        [$parsed, $options] = MemoryVersionListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(
            [
                'apiKeyID',
                'createdAtGte',
                'createdAtLte',
                'limit',
                'memoryID',
                'operation',
                'page',
                'serviceAccountID',
                'sessionID',
                'view',
            ],
        );

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/memory_stores/%1$s/memory_versions?beta=true', $memoryStoreID],
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                [
                    'apiKeyID' => 'api_key_id',
                    'createdAtGte' => 'created_at[gte]',
                    'createdAtLte' => 'created_at[lte]',
                    'memoryID' => 'memory_id',
                    'serviceAccountID' => 'service_account_id',
                    'sessionID' => 'session_id',
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
                name: 'anthropic.memory_stores.memory_versions.list',
                route: '/v1/memory_stores/{memory_store_id}/memory_versions',
                query: [
                    'api_key_id',
                    'created_at[gte]',
                    'created_at[lte]',
                    'limit',
                    'memory_id',
                    'operation',
                    'page',
                    'service_account_id',
                    'session_id',
                    'view',
                ],
                attributes: ['gen_ai.memory.store.id' => $memoryStoreID],
            )),
            convert: ManagedAgentsMemoryVersion::class,
            page: PageCursor::class,
        );
    }

    /**
     * @api
     *
     * Redact a Memory Version
     *
     * @param string $memoryVersionID Path param: The ID of the memory version to redact (`memver_...`).
     * @param array{
     *   memoryStoreID: string,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     *   workspaceID?: string,
     * }|MemoryVersionRedactParams $params
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
    ): BaseResponse {
        [$parsed, $options] = MemoryVersionRedactParams::parseRequest(
            $params,
            $requestOptions,
        );
        $memoryStoreID = $parsed['memoryStoreID'];
        unset($parsed['memoryStoreID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/memory_stores/%1$s/memory_versions/%2$s/redact?beta=true',
                $memoryStoreID,
                $memoryVersionID,
            ],
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
                name: 'anthropic.memory_stores.memory_versions.redact',
                route: '/v1/memory_stores/{memory_store_id}/memory_versions/{memory_version_id}/redact',
                attributes: [
                    'gen_ai.memory.store.id' => $memoryStoreID,
                    'anthropic.memory_store.memory_version.id' => $memoryVersionID,
                ],
            )),
            convert: ManagedAgentsMemoryVersion::class,
        );
    }
}
