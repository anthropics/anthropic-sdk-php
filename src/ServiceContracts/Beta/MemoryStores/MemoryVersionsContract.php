<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\MemoryStores;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsMemoryView;
use Anthropic\Beta\MemoryStores\MemoryVersions\ManagedAgentsMemoryVersion;
use Anthropic\Beta\MemoryStores\MemoryVersions\ManagedAgentsMemoryVersionOperation;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface MemoryVersionsContract
{
    /**
     * @api
     *
     * @param string $memoryVersionID Path param: Path parameter memory_version_id
     * @param string $memoryStoreID Path param: Path parameter memory_store_id
     * @param ManagedAgentsMemoryView|value-of<ManagedAgentsMemoryView> $view Query param: Query parameter for view
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $memoryVersionID,
        string $memoryStoreID,
        ManagedAgentsMemoryView|string|null $view = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): ManagedAgentsMemoryVersion;

    /**
     * @api
     *
     * @param string $memoryStoreID Path param: Path parameter memory_store_id
     * @param string $apiKeyID Query param: Query parameter for api_key_id
     * @param \DateTimeInterface $createdAtGte query param: Return versions created at or after this time (inclusive)
     * @param \DateTimeInterface $createdAtLte query param: Return versions created at or before this time (inclusive)
     * @param int $limit Query param: Query parameter for limit
     * @param string $memoryID Query param: Query parameter for memory_id
     * @param ManagedAgentsMemoryVersionOperation|value-of<ManagedAgentsMemoryVersionOperation> $operation Query param: Query parameter for operation
     * @param string $page Query param: Query parameter for page
     * @param string $sessionID Query param: Query parameter for session_id
     * @param ManagedAgentsMemoryView|value-of<ManagedAgentsMemoryView> $view Query param: Query parameter for view
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<ManagedAgentsMemoryVersion>
     *
     * @throws APIException
     */
    public function list(
        string $memoryStoreID,
        ?string $apiKeyID = null,
        ?\DateTimeInterface $createdAtGte = null,
        ?\DateTimeInterface $createdAtLte = null,
        ?int $limit = null,
        ?string $memoryID = null,
        ManagedAgentsMemoryVersionOperation|string|null $operation = null,
        ?string $page = null,
        ?string $sessionID = null,
        ManagedAgentsMemoryView|string|null $view = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;

    /**
     * @api
     *
     * @param string $memoryVersionID Path param: Path parameter memory_version_id
     * @param string $memoryStoreID Path param: Path parameter memory_store_id
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function redact(
        string $memoryVersionID,
        string $memoryStoreID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): ManagedAgentsMemoryVersion;
}
