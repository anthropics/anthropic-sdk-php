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
     * GetMemoryVersion
     *
     * @param string $memoryVersionID Path param: Path parameter memory_version_id
     * @param array{
     *   memoryStoreID: string,
     *   view?: ManagedAgentsMemoryView|value-of<ManagedAgentsMemoryView>,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
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
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: ManagedAgentsMemoryVersion::class,
        );
    }

    /**
     * @api
     *
     * ListMemoryVersions
     *
     * @param string $memoryStoreID Path param: Path parameter memory_store_id
     * @param array{
     *   apiKeyID?: string,
     *   createdAtGte?: \DateTimeInterface,
     *   createdAtLte?: \DateTimeInterface,
     *   limit?: int,
     *   memoryID?: string,
     *   operation?: ManagedAgentsMemoryVersionOperation|value-of<ManagedAgentsMemoryVersionOperation>,
     *   page?: string,
     *   sessionID?: string,
     *   view?: ManagedAgentsMemoryView|value-of<ManagedAgentsMemoryView>,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
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
                    'sessionID' => 'session_id',
                ],
            ),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: ManagedAgentsMemoryVersion::class,
            page: PageCursor::class,
        );
    }

    /**
     * @api
     *
     * RedactMemoryVersion
     *
     * @param string $memoryVersionID Path param: Path parameter memory_version_id
     * @param array{
     *   memoryStoreID: string,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
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
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: ManagedAgentsMemoryVersion::class,
        );
    }
}
