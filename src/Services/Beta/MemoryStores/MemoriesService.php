<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\MemoryStores;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsDeletedMemory;
use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsMemory;
use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsMemoryPrefix;
use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsMemoryView;
use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsPrecondition;
use Anthropic\Beta\MemoryStores\Memories\MemoryListParams\Order;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\MemoryStores\MemoriesContract;

/**
 * @phpstan-import-type ManagedAgentsPreconditionShape from \Anthropic\Beta\MemoryStores\Memories\ManagedAgentsPrecondition
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class MemoriesService implements MemoriesContract
{
    /**
     * @api
     */
    public MemoriesRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new MemoriesRawService($client);
    }

    /**
     * @api
     *
     * Create a memory
     *
     * @param string $memoryStoreID Path param: Path parameter memory_store_id
     * @param string|null $content Body param: UTF-8 text content for the new memory. Maximum 100 kB (102,400 bytes). Required; pass `""` explicitly to create an empty memory.
     * @param string $path Body param: Hierarchical path for the new memory, e.g. `/projects/foo/notes.md`. Must start with `/`, contain at least one non-empty segment, and be at most 1,024 bytes. Must not contain empty segments, `.` or `..` segments, control or format characters, and must be NFC-normalized. Paths are case-sensitive.
     * @param ManagedAgentsMemoryView|value-of<ManagedAgentsMemoryView> $view Query param: Query parameter for view
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $memoryStoreID,
        ?string $content,
        string $path,
        ManagedAgentsMemoryView|string|null $view = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): ManagedAgentsMemory {
        $params = Util::removeNulls(
            [
                'content' => $content,
                'path' => $path,
                'view' => $view,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create($memoryStoreID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Retrieve a memory
     *
     * @param string $memoryID Path param: Path parameter memory_id
     * @param string $memoryStoreID Path param: Path parameter memory_store_id
     * @param ManagedAgentsMemoryView|value-of<ManagedAgentsMemoryView> $view Query param: Query parameter for view
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $memoryID,
        string $memoryStoreID,
        ManagedAgentsMemoryView|string|null $view = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): ManagedAgentsMemory {
        $params = Util::removeNulls(
            ['memoryStoreID' => $memoryStoreID, 'view' => $view, 'betas' => $betas]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($memoryID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Update a memory
     *
     * @param string $memoryID Path param: Path parameter memory_id
     * @param string $memoryStoreID Path param: Path parameter memory_store_id
     * @param ManagedAgentsMemoryView|value-of<ManagedAgentsMemoryView> $view Query param: Query parameter for view
     * @param string|null $content Body param: New UTF-8 text content for the memory. Maximum 100 kB (102,400 bytes). Omit to leave the content unchanged (e.g., for a rename-only update).
     * @param string|null $path Body param: New path for the memory (a rename). Must start with `/`, contain at least one non-empty segment, and be at most 1,024 bytes. Must not contain empty segments, `.` or `..` segments, control or format characters, and must be NFC-normalized. Paths are case-sensitive. The memory's `id` is preserved across renames. Omit to leave the path unchanged.
     * @param ManagedAgentsPrecondition|ManagedAgentsPreconditionShape $precondition Body param: Optimistic-concurrency precondition: the update applies only if the memory's stored `content_sha256` equals the supplied value. On mismatch, the request returns `memory_precondition_failed_error` (HTTP 409); re-read the memory and retry against the fresh state. If the precondition fails but the stored state already exactly matches the requested `content` and `path`, the server returns 200 instead of 409.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $memoryID,
        string $memoryStoreID,
        ManagedAgentsMemoryView|string|null $view = null,
        ?string $content = null,
        ?string $path = null,
        ManagedAgentsPrecondition|array|null $precondition = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): ManagedAgentsMemory {
        $params = Util::removeNulls(
            [
                'memoryStoreID' => $memoryStoreID,
                'view' => $view,
                'content' => $content,
                'path' => $path,
                'precondition' => $precondition,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($memoryID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List memories
     *
     * @param string $memoryStoreID Path param: Path parameter memory_store_id
     * @param int $depth Query param: Query parameter for depth
     * @param int $limit Query param: Query parameter for limit
     * @param Order|value-of<Order> $order Query param: Query parameter for order
     * @param string $orderBy Query param: Query parameter for order_by
     * @param string $page Query param: Query parameter for page
     * @param string $pathPrefix Query param: Optional path prefix filter (raw string-prefix match; include a trailing slash for directory-scoped lists). This value appears in request URLs. Do not include secrets or personally identifiable information.
     * @param ManagedAgentsMemoryView|value-of<ManagedAgentsMemoryView> $view Query param: Query parameter for view
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<ManagedAgentsMemory|ManagedAgentsMemoryPrefix>
     *
     * @throws APIException
     */
    public function list(
        string $memoryStoreID,
        ?int $depth = null,
        ?int $limit = null,
        Order|string|null $order = null,
        ?string $orderBy = null,
        ?string $page = null,
        ?string $pathPrefix = null,
        ManagedAgentsMemoryView|string|null $view = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor {
        $params = Util::removeNulls(
            [
                'depth' => $depth,
                'limit' => $limit,
                'order' => $order,
                'orderBy' => $orderBy,
                'page' => $page,
                'pathPrefix' => $pathPrefix,
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
     * Delete a memory
     *
     * @param string $memoryID Path param: Path parameter memory_id
     * @param string $memoryStoreID Path param: Path parameter memory_store_id
     * @param string $expectedContentSha256 Query param: Query parameter for expected_content_sha256
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $memoryID,
        string $memoryStoreID,
        ?string $expectedContentSha256 = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): ManagedAgentsDeletedMemory {
        $params = Util::removeNulls(
            [
                'memoryStoreID' => $memoryStoreID,
                'expectedContentSha256' => $expectedContentSha256,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($memoryID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
