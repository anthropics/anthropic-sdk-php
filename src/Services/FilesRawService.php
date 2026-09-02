<?php

declare(strict_types=1);

namespace Anthropic\Services;

use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\FileParam;
use Anthropic\Core\Util;
use Anthropic\Files\DeletedFile;
use Anthropic\Files\FileDeleteParams;
use Anthropic\Files\FileDownloadParams;
use Anthropic\Files\FileListParams;
use Anthropic\Files\FileMetadata;
use Anthropic\Files\FileRetrieveMetadataParams;
use Anthropic\Files\FileUploadParams;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\FilesRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class FilesRawService implements FilesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * List Files
     *
     * @param array{
     *   ids?: list<string>|null, limit?: int, page?: string|null, workspaceID?: string
     * }|FileListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<FileMetadata>>
     *
     * @throws APIException
     */
    public function list(
        array|FileListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = FileListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(['ids', 'limit', 'page']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/files',
            query: array_intersect_key($parsed, $query_params),
            headers: Util::array_transform_keys(
                $header_params,
                ['workspaceID' => 'anthropic-workspace-id']
            ),
            options: $options,
            convert: FileMetadata::class,
            page: PageCursor::class,
        );
    }

    /**
     * @api
     *
     * Delete File
     *
     * @param string $fileID ID of the File
     * @param array{workspaceID?: string}|FileDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<DeletedFile>
     *
     * @throws APIException
     */
    public function delete(
        string $fileID,
        array|FileDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = FileDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/files/%1$s', $fileID],
            headers: Util::array_transform_keys(
                $parsed,
                ['workspaceID' => 'anthropic-workspace-id']
            ),
            options: $options,
            convert: DeletedFile::class,
        );
    }

    /**
     * @api
     *
     * Download File
     *
     * @param string $fileID ID of the File
     * @param array{workspaceID?: string}|FileDownloadParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<string>
     *
     * @throws APIException
     */
    public function download(
        string $fileID,
        array|FileDownloadParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = FileDownloadParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/files/%1$s/content', $fileID],
            headers: Util::array_transform_keys(
                ['Accept' => 'application/binary', ...$parsed],
                ['workspaceID' => 'anthropic-workspace-id'],
            ),
            options: $options,
            convert: 'string',
        );
    }

    /**
     * @api
     *
     * Get File Metadata
     *
     * @param string $fileID ID of the File
     * @param array{workspaceID?: string}|FileRetrieveMetadataParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FileMetadata>
     *
     * @throws APIException
     */
    public function retrieveMetadata(
        string $fileID,
        array|FileRetrieveMetadataParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = FileRetrieveMetadataParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/files/%1$s', $fileID],
            headers: Util::array_transform_keys(
                $parsed,
                ['workspaceID' => 'anthropic-workspace-id']
            ),
            options: $options,
            convert: FileMetadata::class,
        );
    }

    /**
     * @api
     *
     * Upload File
     *
     * @param array{
     *   file: string|FileParam, expiresInSeconds?: int, workspaceID?: string
     * }|FileUploadParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FileMetadata>
     *
     * @throws APIException
     */
    public function upload(
        array|FileUploadParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = FileUploadParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['workspaceID' => 'anthropic-workspace-id'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/files',
            headers: Util::array_transform_keys(
                [
                    'Content-Type' => 'multipart/form-data',
                    ...array_intersect_key(
                        $parsed,
                        array_flip(array_keys($header_params))
                    ),
                ],
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: FileMetadata::class,
        );
    }
}
