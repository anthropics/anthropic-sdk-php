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
     * @param string $memoryVersionID Path param
     * @param string $memoryStoreID Path param
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
     * @param string $memoryStoreID Path param
     * @param string $apiKeyID Query param
     * @param \DateTimeInterface $createdAtGte query param: Return versions created at or after this time (inclusive)
     * @param \DateTimeInterface $createdAtLte query param: Return versions created at or before this time (inclusive)
     * @param int $limit Query param
     * @param string $memoryID Query param
     * @param ManagedAgentsMemoryVersionOperation|value-of<ManagedAgentsMemoryVersionOperation> $operation Query param: The kind of mutation a `memory_version` records. Every non-no-op mutation to a memory appends exactly one version row with one of these values.
     * @param string $page Query param
     * @param string $serviceAccountID Query param
     * @param string $sessionID Query param
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
     * @param string $memoryVersionID Path param
     * @param string $memoryStoreID Path param
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
