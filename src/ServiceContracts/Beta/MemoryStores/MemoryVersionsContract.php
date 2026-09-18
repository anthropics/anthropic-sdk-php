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
     * @param string $memoryVersionID Path param: The ID of the memory version to retrieve (`memver_...`).
     * @param string $memoryStoreID Path param: The ID of the memory store that holds the version (`memstore_...`).
     * @param ManagedAgentsMemoryView|value-of<ManagedAgentsMemoryView> $view Query param: Selects which projection of a `memory` or `memory_version` the server returns. `basic` returns the object with `content` set to `null`; `full` populates `content`. When omitted, the default is endpoint-specific: retrieve operations default to `full`; list, create, and update operations default to `basic`. Listing with `view=full` caps `limit` at 20.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param string $workspaceID Header param: Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $memoryVersionID,
        string $memoryStoreID,
        ManagedAgentsMemoryView|string|null $view = null,
        ?array $betas = null,
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): ManagedAgentsMemoryVersion;

    /**
     * @api
     *
     * @param string $memoryStoreID Path param: The ID of the memory store whose version history to list (`memstore_...`).
     * @param string $apiKeyID query param: Return only versions written with the API key that has this ID
     * @param \DateTimeInterface $createdAtGte query param: Return versions created at or after this time (inclusive)
     * @param \DateTimeInterface $createdAtLte query param: Return versions created at or before this time (inclusive)
     * @param int $limit Query param: The maximum number of versions to return per page. Defaults to 20.
     * @param string $memoryID Query param: Return only versions of the memory with this ID (`mem_...`).
     *
     * The filter still works after the memory is deleted. The results then include the version whose `operation` is `deleted`.
     * @param ManagedAgentsMemoryVersionOperation|value-of<ManagedAgentsMemoryVersionOperation> $operation query param: Return only versions that record this kind of change
     * @param string $page Query param: The `next_page` value from a previous response, to get the next page. Omit it to get the first page.
     * @param string $serviceAccountID Query param: Return only versions written by the service account with this ID (`svac_...`).
     * @param string $sessionID query param: Return only versions written by the session with this ID
     * @param ManagedAgentsMemoryView|value-of<ManagedAgentsMemoryView> $view Query param: Selects which projection of a `memory` or `memory_version` the server returns. `basic` returns the object with `content` set to `null`; `full` populates `content`. When omitted, the default is endpoint-specific: retrieve operations default to `full`; list, create, and update operations default to `basic`. Listing with `view=full` caps `limit` at 20.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param string $workspaceID Header param: Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
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
        ?string $serviceAccountID = null,
        ?string $sessionID = null,
        ManagedAgentsMemoryView|string|null $view = null,
        ?array $betas = null,
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;

    /**
     * @api
     *
     * @param string $memoryVersionID Path param: The ID of the memory version to redact (`memver_...`).
     * @param string $memoryStoreID Path param: The ID of the memory store that holds the version (`memstore_...`).
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param string $workspaceID Header param: Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function redact(
        string $memoryVersionID,
        string $memoryStoreID,
        ?array $betas = null,
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): ManagedAgentsMemoryVersion;
}
