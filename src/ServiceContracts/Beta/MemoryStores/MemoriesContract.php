<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\MemoryStores;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsDeletedMemory;
use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsMemory;
use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsMemoryPrefix;
use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsMemoryView;
use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsPrecondition;
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
     * @param string $memoryStoreID Path param: The ID of the memory store to create the memory in (`memstore_...`).
     * @param string|null $content Body param: UTF-8 text content for the new memory. Maximum 100 kB (102,400 bytes). Required; pass `""` explicitly to create an empty memory.
     * @param string $path Body param: Hierarchical path for the new memory, e.g. `/projects/foo/notes.md`. Must start with `/`, contain at least one non-empty segment, and be at most 1,024 bytes. Must not contain empty segments, `.` or `..` segments, control or format characters, or the Unicode line and paragraph separators (U+2028, U+2029), and must be NFC-normalized. Paths are case-sensitive.
     * @param ManagedAgentsMemoryView|value-of<ManagedAgentsMemoryView> $view Query param: Selects which projection of a `memory` or `memory_version` the server returns. `basic` returns the object with `content` set to `null`; `full` populates `content`. When omitted, the default is endpoint-specific: retrieve operations default to `full`; list, create, and update operations default to `basic`. Listing with `view=full` caps `limit` at 20.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param string $workspaceID Header param: Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
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
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): ManagedAgentsMemory;

    /**
     * @api
     *
     * @param string $memoryID Path param: The ID of the memory to retrieve (`mem_...`).
     * @param string $memoryStoreID Path param: The ID of the memory store that holds the memory (`memstore_...`).
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
        string $memoryID,
        string $memoryStoreID,
        ManagedAgentsMemoryView|string|null $view = null,
        ?array $betas = null,
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): ManagedAgentsMemory;

    /**
     * @api
     *
     * @param string $memoryID Path param: The ID of the memory to update (`mem_...`).
     * @param string $memoryStoreID Path param: The ID of the memory store that holds the memory (`memstore_...`).
     * @param ManagedAgentsMemoryView|value-of<ManagedAgentsMemoryView> $view Query param: Selects which projection of a `memory` or `memory_version` the server returns. `basic` returns the object with `content` set to `null`; `full` populates `content`. When omitted, the default is endpoint-specific: retrieve operations default to `full`; list, create, and update operations default to `basic`. Listing with `view=full` caps `limit` at 20.
     * @param string|null $content Body param: New UTF-8 text content for the memory. Maximum 100 kB (102,400 bytes). Omit to leave the content unchanged (e.g., for a rename-only update).
     * @param string|null $path Body param: New path for the memory (a rename). Must start with `/`, contain at least one non-empty segment, and be at most 1,024 bytes. Must not contain empty segments, `.` or `..` segments, control or format characters, or the Unicode line and paragraph separators (U+2028, U+2029), and must be NFC-normalized. Paths are case-sensitive. The memory's `id` is preserved across renames. Omit to leave the path unchanged.
     * @param ManagedAgentsPrecondition|ManagedAgentsPreconditionShape $precondition Body param: Optimistic-concurrency precondition: the update applies only if the memory's stored `content_sha256` equals the supplied value. On mismatch, the request returns `memory_precondition_failed_error` (HTTP 409); re-read the memory and retry against the fresh state. If the precondition fails but the stored state already exactly matches the requested `content` and `path`, the server returns 200 instead of 409.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param string $workspaceID Header param: Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
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
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): ManagedAgentsMemory;

    /**
     * @api
     *
     * @param string $memoryStoreID Path param: The ID of the memory store to list memories from (`memstore_...`).
     * @param int $depth Query param: `0` (or omitted) returns all descendants below `path_prefix` (recursive). `1` returns immediate children only; deeper entries roll up as `memory_prefix` items. `depth=1` behaves like `ls`; omitting `depth` behaves like `find`.
     * @param int $limit Query param: Maximum number of items to return per page. Must be between 1 and 100. Defaults to 20 when omitted. Capped at 20 when `view=full`. Both `memory` and `memory_prefix` items count toward the limit.
     * @param string $page Query param: Opaque pagination cursor (a `page_...` value). Pass the `next_page` value from a previous response to fetch the next page; omit for the first page.
     * @param string $pathPrefix Query param: Optional path prefix filter. Must end with `/` (segment-aligned), e.g., `/notes/`. This value appears in request URLs. Do not include secrets or personally identifiable information.
     * @param ManagedAgentsMemoryView|value-of<ManagedAgentsMemoryView> $view Query param: Which projection of each `memory` to return. Defaults to `basic` (content omitted). `full` populates `content` on each item and caps `limit` at 20; use this as the bulk-read path for export and sync.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param string $workspaceID Header param: Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
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
        ?string $page = null,
        ?string $pathPrefix = null,
        ManagedAgentsMemoryView|string|null $view = null,
        ?array $betas = null,
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;

    /**
     * @api
     *
     * @param string $memoryID Path param: The ID of the memory to delete (`mem_...`).
     * @param string $memoryStoreID Path param: The ID of the memory store that holds the memory (`memstore_...`).
     * @param string $expectedContentSha256 Query param: Delete the memory only if its current `content_sha256` equals this value, given as 64 lowercase hexadecimal characters. Omit it to delete unconditionally.
     *
     * If the hashes differ, the request fails with HTTP status 409 and nothing is deleted.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param string $workspaceID Header param: Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $memoryID,
        string $memoryStoreID,
        ?string $expectedContentSha256 = null,
        ?array $betas = null,
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): ManagedAgentsDeletedMemory;
}
