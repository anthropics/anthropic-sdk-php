<?php

declare(strict_types=1);

namespace Anthropic\Services;

use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\FileParam;
use Anthropic\Core\Util;
use Anthropic\Files\DeletedFile;
use Anthropic\Files\FileMetadata;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\FilesContract;

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
     * @param string $workspaceID Header param: Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<FileMetadata>
     *
     * @throws APIException
     */
    public function list(
        ?array $ids = null,
        ?int $limit = null,
        ?string $page = null,
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor {
        $params = Util::removeNulls(
            [
                'ids' => $ids,
                'limit' => $limit,
                'page' => $page,
                'workspaceID' => $workspaceID,
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
     * @param string $workspaceID Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $fileID,
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): DeletedFile {
        $params = Util::removeNulls(['workspaceID' => $workspaceID]);

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
     * @param string $workspaceID Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function download(
        string $fileID,
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): string {
        $params = Util::removeNulls(['workspaceID' => $workspaceID]);

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
     * @param string $workspaceID Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveMetadata(
        string $fileID,
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): FileMetadata {
        $params = Util::removeNulls(['workspaceID' => $workspaceID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveMetadata($fileID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Upload File
     *
     * @param string|FileParam $file Body param: The file to upload. Only the final path component of the part's `filename` is kept; an absent or empty `filename` is replaced with `unnamed` plus the extension for the file's stored `mime_type`, when known.
     * @param int $expiresInSeconds Body param: Seconds from upload until the file expires and its bytes become permanently unavailable. Must be between 3600 (one hour) and 7776000 (ninety days).
     * @param string $workspaceID Header param: Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function upload(
        string|FileParam $file,
        ?int $expiresInSeconds = null,
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): FileMetadata {
        $params = Util::removeNulls(
            [
                'file' => $file,
                'expiresInSeconds' => $expiresInSeconds,
                'workspaceID' => $workspaceID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->upload(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
