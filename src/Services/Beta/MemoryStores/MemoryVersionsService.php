<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\MemoryStores;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsMemoryView;
use Anthropic\Beta\MemoryStores\MemoryVersions\ManagedAgentsMemoryVersion;
use Anthropic\Beta\MemoryStores\MemoryVersions\ManagedAgentsMemoryVersionOperation;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\MemoryStores\MemoryVersionsContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class MemoryVersionsService implements MemoryVersionsContract
{
    /**
     * @api
     */
    public MemoryVersionsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new MemoryVersionsRawService($client);
    }

    /**
     * @api
     *
     * GetMemoryVersion
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
    ): ManagedAgentsMemoryVersion {
        $params = Util::removeNulls(
            ['memoryStoreID' => $memoryStoreID, 'view' => $view, 'betas' => $betas]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($memoryVersionID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * ListMemoryVersions
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
    ): PageCursor {
        $params = Util::removeNulls(
            [
                'apiKeyID' => $apiKeyID,
                'createdAtGte' => $createdAtGte,
                'createdAtLte' => $createdAtLte,
                'limit' => $limit,
                'memoryID' => $memoryID,
                'operation' => $operation,
                'page' => $page,
                'sessionID' => $sessionID,
                'view' => $view,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list($memoryStoreID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * RedactMemoryVersion
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
    ): ManagedAgentsMemoryVersion {
        $params = Util::removeNulls(
            ['memoryStoreID' => $memoryStoreID, 'betas' => $betas]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->redact($memoryVersionID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
