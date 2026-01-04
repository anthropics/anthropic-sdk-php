<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Files\DeletedFile;
use Anthropic\Beta\Files\FileMetadata;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Page;
use Anthropic\RequestOptions;

interface FilesContract
{
    /**
     * @api
     *
     * @param string $afterID Query param: ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately after this object.
     * @param string $beforeID Query param: ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately before this object.
     * @param int $limit Query param: Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     * @param list<string|'message-batches-2024-09-24'|'prompt-caching-2024-07-31'|'computer-use-2024-10-22'|'computer-use-2025-01-24'|'pdfs-2024-09-25'|'token-counting-2024-11-01'|'token-efficient-tools-2025-02-19'|'output-128k-2025-02-19'|'files-api-2025-04-14'|'mcp-client-2025-04-04'|'mcp-client-2025-11-20'|'dev-full-thinking-2025-05-14'|'interleaved-thinking-2025-05-14'|'code-execution-2025-05-22'|'extended-cache-ttl-2025-04-11'|'context-1m-2025-08-07'|'context-management-2025-06-27'|'model-context-window-exceeded-2025-08-26'|'skills-2025-10-02'|AnthropicBeta> $betas header param: Optional header to specify the beta version(s) you want to use
     *
     * @return Page<FileMetadata>
     *
     * @throws APIException
     */
    public function list(
        ?string $afterID = null,
        ?string $beforeID = null,
        int $limit = 20,
        ?array $betas = null,
        ?RequestOptions $requestOptions = null,
    ): Page;

    /**
     * @api
     *
     * @param string $fileID ID of the File
     * @param list<string|'message-batches-2024-09-24'|'prompt-caching-2024-07-31'|'computer-use-2024-10-22'|'computer-use-2025-01-24'|'pdfs-2024-09-25'|'token-counting-2024-11-01'|'token-efficient-tools-2025-02-19'|'output-128k-2025-02-19'|'files-api-2025-04-14'|'mcp-client-2025-04-04'|'mcp-client-2025-11-20'|'dev-full-thinking-2025-05-14'|'interleaved-thinking-2025-05-14'|'code-execution-2025-05-22'|'extended-cache-ttl-2025-04-11'|'context-1m-2025-08-07'|'context-management-2025-06-27'|'model-context-window-exceeded-2025-08-26'|'skills-2025-10-02'|AnthropicBeta> $betas optional header to specify the beta version(s) you want to use
     *
     * @throws APIException
     */
    public function delete(
        string $fileID,
        ?array $betas = null,
        ?RequestOptions $requestOptions = null,
    ): DeletedFile;

    /**
     * @api
     *
     * @param string $fileID ID of the File
     * @param list<string|'message-batches-2024-09-24'|'prompt-caching-2024-07-31'|'computer-use-2024-10-22'|'computer-use-2025-01-24'|'pdfs-2024-09-25'|'token-counting-2024-11-01'|'token-efficient-tools-2025-02-19'|'output-128k-2025-02-19'|'files-api-2025-04-14'|'mcp-client-2025-04-04'|'mcp-client-2025-11-20'|'dev-full-thinking-2025-05-14'|'interleaved-thinking-2025-05-14'|'code-execution-2025-05-22'|'extended-cache-ttl-2025-04-11'|'context-1m-2025-08-07'|'context-management-2025-06-27'|'model-context-window-exceeded-2025-08-26'|'skills-2025-10-02'|AnthropicBeta> $betas optional header to specify the beta version(s) you want to use
     *
     * @throws APIException
     */
    public function retrieveMetadata(
        string $fileID,
        ?array $betas = null,
        ?RequestOptions $requestOptions = null,
    ): FileMetadata;
}
