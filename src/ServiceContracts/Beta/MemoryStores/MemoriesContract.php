<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\MemoryStores;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsDeletedMemory;
use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsMemory;
use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsMemoryPrefix;
use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsMemoryView;
use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsPrecondition;
use Anthropic\Beta\MemoryStores\Memories\MemoryListParams\Order;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type ManagedAgentsPreconditionShape from \Anthropic\Beta\MemoryStores\Memories\ManagedAgentsPrecondition
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface MemoriesContract
{
    /**
     * @api
     *
     * @param string $memoryStoreID Path param: Path parameter memory_store_id
     * @param string|null $content Body param
     * @param string $path Body param
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
    ): ManagedAgentsMemory;

    /**
     * @api
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
    ): ManagedAgentsMemory;

    /**
     * @api
     *
     * @param string $memoryID Path param: Path parameter memory_id
     * @param string $memoryStoreID Path param: Path parameter memory_store_id
     * @param ManagedAgentsMemoryView|value-of<ManagedAgentsMemoryView> $view Query param: Query parameter for view
     * @param string|null $content Body param
     * @param string|null $path Body param
     * @param ManagedAgentsPrecondition|ManagedAgentsPreconditionShape $precondition Body param
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
    ): ManagedAgentsMemory;

    /**
     * @api
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
    ): PageCursor;

    /**
     * @api
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
    ): ManagedAgentsDeletedMemory;
}
