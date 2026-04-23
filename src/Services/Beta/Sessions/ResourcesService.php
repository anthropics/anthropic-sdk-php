<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Sessions;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Sessions\Resources\ManagedAgentsDeleteSessionResource;
use Anthropic\Beta\Sessions\Resources\ManagedAgentsFileResource;
use Anthropic\Beta\Sessions\Resources\ManagedAgentsGitHubRepositoryResource;
use Anthropic\Beta\Sessions\Resources\ManagedAgentsMemoryStoreResource;
use Anthropic\Beta\Sessions\Resources\ResourceAddParams\Type;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Sessions\ResourcesContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class ResourcesService implements ResourcesContract
{
    /**
     * @api
     */
    public ResourcesRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ResourcesRawService($client);
    }

    /**
     * @api
     *
     * Get Session Resource
     *
     * @param string $resourceID Path param: Path parameter resource_id
     * @param string $sessionID Path param: Path parameter session_id
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $resourceID,
        string $sessionID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): ManagedAgentsGitHubRepositoryResource|ManagedAgentsFileResource|ManagedAgentsMemoryStoreResource {
        $params = Util::removeNulls(['sessionID' => $sessionID, 'betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($resourceID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Update Session Resource
     *
     * @param string $resourceID Path param: Path parameter resource_id
     * @param string $sessionID Path param: Path parameter session_id
     * @param string $authorizationToken Body param: New authorization token for the resource. Currently only `github_repository` resources support token rotation.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $resourceID,
        string $sessionID,
        string $authorizationToken,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): ManagedAgentsGitHubRepositoryResource|ManagedAgentsFileResource|ManagedAgentsMemoryStoreResource {
        $params = Util::removeNulls(
            [
                'sessionID' => $sessionID,
                'authorizationToken' => $authorizationToken,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($resourceID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List Session Resources
     *
     * @param string $sessionID Path param: Path parameter session_id
     * @param int $limit Query param: Maximum number of resources to return per page (max 1000). If omitted, returns all resources.
     * @param string $page query param: Opaque cursor from a previous response's next_page field
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<ManagedAgentsGitHubRepositoryResource|ManagedAgentsFileResource|ManagedAgentsMemoryStoreResource,>
     *
     * @throws APIException
     */
    public function list(
        string $sessionID,
        ?int $limit = null,
        ?string $page = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor {
        $params = Util::removeNulls(
            ['limit' => $limit, 'page' => $page, 'betas' => $betas]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list($sessionID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Delete Session Resource
     *
     * @param string $resourceID Path param: Path parameter resource_id
     * @param string $sessionID Path param: Path parameter session_id
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $resourceID,
        string $sessionID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): ManagedAgentsDeleteSessionResource {
        $params = Util::removeNulls(['sessionID' => $sessionID, 'betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($resourceID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Add Session Resource
     *
     * @param string $sessionID Path param: Path parameter session_id
     * @param string $fileID body param: ID of a previously uploaded file
     * @param Type|value-of<Type> $type Body param
     * @param string|null $mountPath Body param: Mount path in the container. Defaults to `/mnt/session/uploads/<file_id>`.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function add(
        string $sessionID,
        string $fileID,
        Type|string $type,
        ?string $mountPath = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): ManagedAgentsFileResource {
        $params = Util::removeNulls(
            [
                'fileID' => $fileID,
                'type' => $type,
                'mountPath' => $mountPath,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->add($sessionID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
