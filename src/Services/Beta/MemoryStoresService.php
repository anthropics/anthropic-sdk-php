<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\MemoryStores\BetaManagedAgentsDeletedMemoryStore;
use Anthropic\Beta\MemoryStores\BetaManagedAgentsMemoryStore;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\MemoryStoresContract;
use Anthropic\Services\Beta\MemoryStores\MemoriesService;
use Anthropic\Services\Beta\MemoryStores\MemoryVersionsService;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class MemoryStoresService implements MemoryStoresContract
{
    /**
     * @api
     */
    public MemoryStoresRawService $raw;

    /**
     * @api
     */
    public MemoriesService $memories;

    /**
     * @api
     */
    public MemoryVersionsService $memoryVersions;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new MemoryStoresRawService($client);
        $this->memories = new MemoriesService($client);
        $this->memoryVersions = new MemoryVersionsService($client);
    }

    /**
     * @api
     *
     * Create a memory store
     *
     * @param string $name Body param: Human-readable name for the store. Required; 1–255 characters; no control characters. The mount-path slug under `/mnt/memory/` is derived from this name (lowercased, non-alphanumeric runs collapsed to a hyphen). Names need not be unique within a workspace.
     * @param string $description Body param: Free-text description of what the store contains, up to 1024 characters. Included in the agent's system prompt when the store is attached, so word it to be useful to the agent.
     * @param array<string,string> $metadata Body param: Arbitrary key-value tags for your own bookkeeping (such as the end user a store belongs to). Up to 16 pairs; keys 1–64 characters; values up to 512 characters. Not visible to the agent.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $name,
        ?string $description = null,
        ?array $metadata = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaManagedAgentsMemoryStore {
        $params = Util::removeNulls(
            [
                'name' => $name,
                'description' => $description,
                'metadata' => $metadata,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Retrieve a memory store
     *
     * @param string $memoryStoreID Path parameter memory_store_id
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $memoryStoreID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaManagedAgentsMemoryStore {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($memoryStoreID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Update a memory store
     *
     * @param string $memoryStoreID Path param: Path parameter memory_store_id
     * @param string|null $description Body param: New description for the store, up to 1024 characters. Pass an empty string to clear it.
     * @param array<string,string|null>|null $metadata Body param: Metadata patch. Set a key to a string to upsert it, or to null to delete it. Omit the field to preserve. The stored bag is limited to 16 keys (up to 64 chars each) with values up to 512 chars.
     * @param string|null $name Body param: New human-readable name for the store. 1–255 characters; no control characters. Renaming changes the slug used for the store's `mount_path` in sessions created after the update.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $memoryStoreID,
        ?string $description = null,
        ?array $metadata = null,
        ?string $name = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaManagedAgentsMemoryStore {
        $params = Util::removeNulls(
            [
                'description' => $description,
                'metadata' => $metadata,
                'name' => $name,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($memoryStoreID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List memory stores
     *
     * @param \DateTimeInterface $createdAtGte Query param: Return only stores whose `created_at` is at or after this time (inclusive). Sent on the wire as `created_at[gte]`.
     * @param \DateTimeInterface $createdAtLte Query param: Return only stores whose `created_at` is at or before this time (inclusive). Sent on the wire as `created_at[lte]`.
     * @param bool $includeArchived Query param: When `true`, archived stores are included in the results. Defaults to `false` (archived stores are excluded).
     * @param int $limit Query param: Maximum number of stores to return per page. Must be between 1 and 100. Defaults to 20 when omitted.
     * @param string $page Query param: Opaque pagination cursor (a `page_...` value). Pass the `next_page` value from a previous response to fetch the next page; omit for the first page.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<BetaManagedAgentsMemoryStore>
     *
     * @throws APIException
     */
    public function list(
        ?\DateTimeInterface $createdAtGte = null,
        ?\DateTimeInterface $createdAtLte = null,
        ?bool $includeArchived = null,
        ?int $limit = null,
        ?string $page = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor {
        $params = Util::removeNulls(
            [
                'createdAtGte' => $createdAtGte,
                'createdAtLte' => $createdAtLte,
                'includeArchived' => $includeArchived,
                'limit' => $limit,
                'page' => $page,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Delete a memory store
     *
     * @param string $memoryStoreID Path parameter memory_store_id
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $memoryStoreID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaManagedAgentsDeletedMemoryStore {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($memoryStoreID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Archive a memory store
     *
     * @param string $memoryStoreID Path parameter memory_store_id
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function archive(
        string $memoryStoreID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaManagedAgentsMemoryStore {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->archive($memoryStoreID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
