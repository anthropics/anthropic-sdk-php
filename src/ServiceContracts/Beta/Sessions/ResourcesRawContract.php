<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Sessions;

use Anthropic\Beta\Sessions\Resources\ManagedAgentsDeleteSessionResource;
use Anthropic\Beta\Sessions\Resources\ManagedAgentsFileResource;
use Anthropic\Beta\Sessions\Resources\ManagedAgentsGitHubRepositoryResource;
use Anthropic\Beta\Sessions\Resources\ManagedAgentsMemoryStoreResource;
use Anthropic\Beta\Sessions\Resources\ResourceAddParams;
use Anthropic\Beta\Sessions\Resources\ResourceDeleteParams;
use Anthropic\Beta\Sessions\Resources\ResourceListParams;
use Anthropic\Beta\Sessions\Resources\ResourceRetrieveParams;
use Anthropic\Beta\Sessions\Resources\ResourceUpdateParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface ResourcesRawContract
{
    /**
     * @api
     *
     * @param string $resourceID Path param: Path parameter resource_id
     * @param array<string,mixed>|ResourceRetrieveParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $resourceID Path param: Path parameter resource_id
     * @param array<string,mixed>|ResourceUpdateParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $sessionID Path param: Path parameter session_id
     * @param array<string,mixed>|ResourceListParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $resourceID Path param: Path parameter resource_id
     * @param array<string,mixed>|ResourceDeleteParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $sessionID Path param: Path parameter session_id
     * @param array<string,mixed>|ResourceAddParams $params
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
    ): BaseResponse;
}
