<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Sessions;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Sessions\Resources\ManagedAgentsDeleteSessionResource;
use Anthropic\Beta\Sessions\Resources\ManagedAgentsFileResource;
use Anthropic\Beta\Sessions\Resources\ManagedAgentsGitHubRepositoryResource;
use Anthropic\Beta\Sessions\Resources\ResourceAddParams\Type;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface ResourcesContract
{
    /**
     * @api
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
    ): ManagedAgentsGitHubRepositoryResource|ManagedAgentsFileResource;

    /**
     * @api
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
    ): ManagedAgentsGitHubRepositoryResource|ManagedAgentsFileResource;

    /**
     * @api
     *
     * @param string $sessionID Path param: Path parameter session_id
     * @param int $limit Query param: Maximum number of resources to return per page (max 1000). If omitted, returns all resources.
     * @param string $page query param: Opaque cursor from a previous response's next_page field
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<ManagedAgentsGitHubRepositoryResource|ManagedAgentsFileResource,>
     *
     * @throws APIException
     */
    public function list(
        string $sessionID,
        ?int $limit = null,
        ?string $page = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;

    /**
     * @api
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
    ): ManagedAgentsDeleteSessionResource;

    /**
     * @api
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
    ): ManagedAgentsFileResource;
}
