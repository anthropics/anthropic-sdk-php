<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Sessions;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Sessions\Resources\ManagedAgentsDeleteSessionResource;
use Anthropic\Beta\Sessions\Resources\ManagedAgentsFileResource;
use Anthropic\Beta\Sessions\Resources\ManagedAgentsGitHubRepositoryResource;
use Anthropic\Beta\Sessions\Resources\ManagedAgentsMemoryStoreResource;
use Anthropic\Beta\Sessions\Resources\ManagedAgentsSessionResource;
use Anthropic\Beta\Sessions\Resources\ResourceAddParams;
use Anthropic\Beta\Sessions\Resources\ResourceAddParams\Type;
use Anthropic\Beta\Sessions\Resources\ResourceDeleteParams;
use Anthropic\Beta\Sessions\Resources\ResourceGetResponse;
use Anthropic\Beta\Sessions\Resources\ResourceListParams;
use Anthropic\Beta\Sessions\Resources\ResourceRetrieveParams;
use Anthropic\Beta\Sessions\Resources\ResourceUpdateParams;
use Anthropic\Beta\Sessions\Resources\ResourceUpdateResponse;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Sessions\ResourcesRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class ResourcesRawService implements ResourcesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Get Session Resource
     *
     * @param string $resourceID Path param: Path parameter resource_id
     * @param array{
     *   sessionID: string, betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|ResourceRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ManagedAgentsGitHubRepositoryResource|ManagedAgentsFileResource|ManagedAgentsMemoryStoreResource,>
     *
     * @throws APIException
     */
    public function retrieve(
        string $resourceID,
        array|ResourceRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ResourceRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );
        $sessionID = $parsed['sessionID'];
        unset($parsed['sessionID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: [
                'v1/sessions/%1$s/resources/%2$s?beta=true', $sessionID, $resourceID,
            ],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: ResourceGetResponse::class,
        );
    }

    /**
     * @api
     *
     * Update Session Resource
     *
     * @param string $resourceID Path param: Path parameter resource_id
     * @param array{
     *   sessionID: string,
     *   authorizationToken: string,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|ResourceUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ManagedAgentsGitHubRepositoryResource|ManagedAgentsFileResource|ManagedAgentsMemoryStoreResource,>
     *
     * @throws APIException
     */
    public function update(
        string $resourceID,
        array|ResourceUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ResourceUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $sessionID = $parsed['sessionID'];
        unset($parsed['sessionID']);
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/sessions/%1$s/resources/%2$s?beta=true', $sessionID, $resourceID,
            ],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                array_diff_key($parsed, array_flip(array_keys($header_params))),
                array_flip(['sessionID']),
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: ResourceUpdateResponse::class,
        );
    }

    /**
     * @api
     *
     * List Session Resources
     *
     * @param string $sessionID Path param: Path parameter session_id
     * @param array{
     *   limit?: int,
     *   page?: string,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|ResourceListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<ManagedAgentsGitHubRepositoryResource|ManagedAgentsFileResource|ManagedAgentsMemoryStoreResource,>,>
     *
     * @throws APIException
     */
    public function list(
        string $sessionID,
        array|ResourceListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ResourceListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(['limit', 'page']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/sessions/%1$s/resources?beta=true', $sessionID],
            query: array_intersect_key($parsed, $query_params),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: ManagedAgentsSessionResource::class,
            page: PageCursor::class,
        );
    }

    /**
     * @api
     *
     * Delete Session Resource
     *
     * @param string $resourceID Path param: Path parameter resource_id
     * @param array{
     *   sessionID: string, betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|ResourceDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ManagedAgentsDeleteSessionResource>
     *
     * @throws APIException
     */
    public function delete(
        string $resourceID,
        array|ResourceDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ResourceDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );
        $sessionID = $parsed['sessionID'];
        unset($parsed['sessionID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: [
                'v1/sessions/%1$s/resources/%2$s?beta=true', $sessionID, $resourceID,
            ],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: ManagedAgentsDeleteSessionResource::class,
        );
    }

    /**
     * @api
     *
     * Add Session Resource
     *
     * @param string $sessionID Path param: Path parameter session_id
     * @param array{
     *   fileID: string,
     *   type: Type|value-of<Type>,
     *   mountPath?: string|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|ResourceAddParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ManagedAgentsFileResource>
     *
     * @throws APIException
     */
    public function add(
        string $sessionID,
        array|ResourceAddParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ResourceAddParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/sessions/%1$s/resources?beta=true', $sessionID],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: ManagedAgentsFileResource::class,
        );
    }
}
