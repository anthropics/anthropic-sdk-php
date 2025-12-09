<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Skills;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Skills\Versions\VersionDeleteResponse;
use Anthropic\Beta\Skills\Versions\VersionGetResponse;
use Anthropic\Beta\Skills\Versions\VersionListResponse;
use Anthropic\Beta\Skills\Versions\VersionNewResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

interface VersionsContract
{
    /**
     * @api
     *
     * @param string $skillID Path param: Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     * @param list<string>|null $files Body param: Files to upload for the skill.
     *
     * All files must be in the same top-level directory and must include a SKILL.md file at the root of that directory.
     * @param list<string|'message-batches-2024-09-24'|'prompt-caching-2024-07-31'|'computer-use-2024-10-22'|'computer-use-2025-01-24'|'pdfs-2024-09-25'|'token-counting-2024-11-01'|'token-efficient-tools-2025-02-19'|'output-128k-2025-02-19'|'files-api-2025-04-14'|'mcp-client-2025-04-04'|'mcp-client-2025-11-20'|'dev-full-thinking-2025-05-14'|'interleaved-thinking-2025-05-14'|'code-execution-2025-05-22'|'extended-cache-ttl-2025-04-11'|'context-1m-2025-08-07'|'context-management-2025-06-27'|'model-context-window-exceeded-2025-08-26'|'skills-2025-10-02'|AnthropicBeta> $betas header param: Optional header to specify the beta version(s) you want to use
     *
     * @throws APIException
     */
    public function create(
        string $skillID,
        ?array $files = null,
        ?array $betas = null,
        ?RequestOptions $requestOptions = null,
    ): VersionNewResponse;

    /**
     * @api
     *
     * @param string $version Path param: Version identifier for the skill.
     *
     * Each version is identified by a Unix epoch timestamp (e.g., "1759178010641129").
     * @param string $skillID Path param: Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     * @param list<string|'message-batches-2024-09-24'|'prompt-caching-2024-07-31'|'computer-use-2024-10-22'|'computer-use-2025-01-24'|'pdfs-2024-09-25'|'token-counting-2024-11-01'|'token-efficient-tools-2025-02-19'|'output-128k-2025-02-19'|'files-api-2025-04-14'|'mcp-client-2025-04-04'|'mcp-client-2025-11-20'|'dev-full-thinking-2025-05-14'|'interleaved-thinking-2025-05-14'|'code-execution-2025-05-22'|'extended-cache-ttl-2025-04-11'|'context-1m-2025-08-07'|'context-management-2025-06-27'|'model-context-window-exceeded-2025-08-26'|'skills-2025-10-02'|AnthropicBeta> $betas header param: Optional header to specify the beta version(s) you want to use
     *
     * @throws APIException
     */
    public function retrieve(
        string $version,
        string $skillID,
        ?array $betas = null,
        ?RequestOptions $requestOptions = null,
    ): VersionGetResponse;

    /**
     * @api
     *
     * @param string $skillID Path param: Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     * @param int|null $limit Query param: Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     * @param string|null $page query param: Optionally set to the `next_page` token from the previous response
     * @param list<string|'message-batches-2024-09-24'|'prompt-caching-2024-07-31'|'computer-use-2024-10-22'|'computer-use-2025-01-24'|'pdfs-2024-09-25'|'token-counting-2024-11-01'|'token-efficient-tools-2025-02-19'|'output-128k-2025-02-19'|'files-api-2025-04-14'|'mcp-client-2025-04-04'|'mcp-client-2025-11-20'|'dev-full-thinking-2025-05-14'|'interleaved-thinking-2025-05-14'|'code-execution-2025-05-22'|'extended-cache-ttl-2025-04-11'|'context-1m-2025-08-07'|'context-management-2025-06-27'|'model-context-window-exceeded-2025-08-26'|'skills-2025-10-02'|AnthropicBeta> $betas header param: Optional header to specify the beta version(s) you want to use
     *
     * @return PageCursor<VersionListResponse>
     *
     * @throws APIException
     */
    public function list(
        string $skillID,
        ?int $limit = null,
        ?string $page = null,
        ?array $betas = null,
        ?RequestOptions $requestOptions = null,
    ): PageCursor;

    /**
     * @api
     *
     * @param string $version Path param: Version identifier for the skill.
     *
     * Each version is identified by a Unix epoch timestamp (e.g., "1759178010641129").
     * @param string $skillID Path param: Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     * @param list<string|'message-batches-2024-09-24'|'prompt-caching-2024-07-31'|'computer-use-2024-10-22'|'computer-use-2025-01-24'|'pdfs-2024-09-25'|'token-counting-2024-11-01'|'token-efficient-tools-2025-02-19'|'output-128k-2025-02-19'|'files-api-2025-04-14'|'mcp-client-2025-04-04'|'mcp-client-2025-11-20'|'dev-full-thinking-2025-05-14'|'interleaved-thinking-2025-05-14'|'code-execution-2025-05-22'|'extended-cache-ttl-2025-04-11'|'context-1m-2025-08-07'|'context-management-2025-06-27'|'model-context-window-exceeded-2025-08-26'|'skills-2025-10-02'|AnthropicBeta> $betas header param: Optional header to specify the beta version(s) you want to use
     *
     * @throws APIException
     */
    public function delete(
        string $version,
        string $skillID,
        ?array $betas = null,
        ?RequestOptions $requestOptions = null,
    ): VersionDeleteResponse;
}
