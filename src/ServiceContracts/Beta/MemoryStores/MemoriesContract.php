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
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 * @phpstan-import-type ManagedAgentsPreconditionShape from \Anthropic\Beta\MemoryStores\Memories\ManagedAgentsPrecondition
 */
interface MemoriesContract
{
    /**
     * @api
     *
     * @param string $memoryStoreID Path param: The ID of the memory store to create the memory in (`memstore_...`).
     * @param string|null $content Body param: The UTF-8 text content of the new memory. Pass `""` to create an empty memory.
     *
     * The maximum size is 100 kB (102,400 bytes).
     * @param string $path Body param: The path of the new memory, such as `/projects/foo/notes.md`. Paths are case-sensitive.
     *
     * A path starts with `/` and has 1 to 20 segments. A segment can't be empty and can't be `.` or `..`. A path can't contain control characters, format characters, or the line and paragraph separators U+2028 and U+2029. It must be in Unicode Normalization Form C and at most 1,024 bytes long.
     * @param ManagedAgentsMemoryView|value-of<ManagedAgentsMemoryView> $view Query param: Whether a `memory` or `memory_version` in the response includes its `content`. Defaults to `full` on retrieve operations and to `basic` on list, create, and update operations.
     *
     * With `full`, list operations return at most 20 items per page.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `agent-memory-2026-07-22` or `managed-agents-2026-04-01` in this header
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
     * @param ManagedAgentsMemoryView|value-of<ManagedAgentsMemoryView> $view Query param: Whether a `memory` or `memory_version` in the response includes its `content`. Defaults to `full` on retrieve operations and to `basic` on list, create, and update operations.
     *
     * With `full`, list operations return at most 20 items per page.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `agent-memory-2026-07-22` or `managed-agents-2026-04-01` in this header
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
     * @param ManagedAgentsMemoryView|value-of<ManagedAgentsMemoryView> $view Query param: Whether a `memory` or `memory_version` in the response includes its `content`. Defaults to `full` on retrieve operations and to `basic` on list, create, and update operations.
     *
     * With `full`, list operations return at most 20 items per page.
     * @param string|null $content Body param: New UTF-8 text content for the memory. Maximum 100 kB (102,400 bytes). Omit to leave the content unchanged (e.g., for a rename-only update).
     * @param string|null $path Body param: The new path of the memory, which renames it. Omit it to keep the current path.
     *
     * The memory keeps its `id`. A path starts with `/` and has 1 to 20 segments. A segment can't be empty and can't be `.` or `..`. A path can't contain control characters, format characters, or the line and paragraph separators U+2028 and U+2029. It must be in Unicode Normalization Form C and at most 1,024 bytes long. Paths are case-sensitive.
     * @param ManagedAgentsPrecondition|ManagedAgentsPreconditionShape $precondition Body param: The condition that the memory must meet for the update to apply. Omit it to update unconditionally.
     *
     * If the condition fails, the request fails with HTTP status 409.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `agent-memory-2026-07-22` or `managed-agents-2026-04-01` in this header
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
     * @param int $depth Query param: How far below `path_prefix` to list. Defaults to `0`, which lists every memory below the prefix.
     *
     * Pass `1` to list only the direct children. Deeper memories are then grouped into `memory_prefix` items.
     * @param int $limit Query param: The maximum number of items to return per page, from 1 to 100. Defaults to 20.
     *
     * With `view=full`, a page holds at most 20 items. `memory` and `memory_prefix` items both count toward the limit.
     * @param string $page Query param: The `next_page` value from a previous response, to get the next page. Omit it to get the first page.
     * @param string $pathPrefix Query param: Return only memories whose path starts with this prefix, such as `/notes/`. This value appears in request URLs. Do not include secrets or personally identifiable information.
     *
     * Omit it to list the whole store. The prefix must end with `/` and matches whole segments, so `/notes/` matches `/notes/todo.md` but not `/notes-archive/todo.md`.
     * @param ManagedAgentsMemoryView|value-of<ManagedAgentsMemoryView> $view Query param: Whether each memory in the response includes `content`. Defaults to `basic`, which sets it to `null`.
     *
     * With `full`, a page holds at most 20 items.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `agent-memory-2026-07-22` or `managed-agents-2026-04-01` in this header
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
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `agent-memory-2026-07-22` or `managed-agents-2026-04-01` in this header
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
