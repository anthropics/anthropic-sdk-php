<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Files\BetaDeletedFile;
use Anthropic\Beta\Files\BetaFileMetadata;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\FileParam;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\FilesContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class FilesService implements FilesContract
{
    /**
     * @api
     */
    public FilesRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new FilesRawService($client);
    }

    /**
     * @api
     *
     * List Files
     *
     * @param list<string>|null $ids Query param: Restrict the result set to Files whose `id` is in this list. At most 100 entries (after de-duplication). Mutually exclusive with `page` and `limit`. When supplied, the response is always a single page (`next_page` is null). IDs that do not resolve to a visible File — including deleted Files — are silently omitted.
     * @param int $limit Query param: Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     * @param string|null $page Query param: Opaque page cursor returned in a prior list response's `next_page`. Prefixed `page_`.
     * @param string $scopeID Query param: Filter by scope ID. Only returns files associated with the specified scope (e.g., a session ID).
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<BetaFileMetadata>
     *
     * @throws APIException
     */
    public function list(
        ?array $ids = null,
        ?int $limit = null,
        ?string $page = null,
        ?string $scopeID = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor {
        $params = Util::removeNulls(
            [
                'ids' => $ids,
                'limit' => $limit,
                'page' => $page,
                'scopeID' => $scopeID,
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
     * Delete File
     *
     * @param string $fileID ID of the File
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $fileID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaDeletedFile {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($fileID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Download File
     *
     * @param string $fileID ID of the File
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function download(
        string $fileID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): string {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->download($fileID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get File Metadata
     *
     * @param string $fileID ID of the File
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveMetadata(
        string $fileID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaFileMetadata {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveMetadata($fileID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Upload File
     *
     * @param string|FileParam $file Body param: The file to upload
     * @param int $expiresInSeconds Body param: Seconds from upload until the file expires and its bytes become permanently unavailable. Must be between 3600 (one hour) and 7776000 (ninety days).
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function upload(
        string|FileParam $file,
        ?int $expiresInSeconds = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaFileMetadata {
        $params = Util::removeNulls(
            [
                'file' => $file,
                'expiresInSeconds' => $expiresInSeconds,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->upload(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
