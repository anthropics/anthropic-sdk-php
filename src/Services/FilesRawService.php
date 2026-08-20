<?php

declare(strict_types=1);

namespace Anthropic\Services;

use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\FileParam;
use Anthropic\Files\DeletedFile;
use Anthropic\Files\FileListParams;
use Anthropic\Files\FileMetadata;
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
     *   ids?: list<string>|null, limit?: int, page?: string|null
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

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/files',
            query: $parsed,
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
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<DeletedFile>
     *
     * @throws APIException
     */
    public function delete(
        string $fileID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/files/%1$s', $fileID],
            options: $requestOptions,
            convert: DeletedFile::class,
        );
    }

    /**
     * @api
     *
     * Download File
     *
     * @param string $fileID ID of the File
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<string>
     *
     * @throws APIException
     */
    public function download(
        string $fileID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/files/%1$s/content', $fileID],
            headers: ['Accept' => 'application/binary'],
            options: $requestOptions,
            convert: 'string',
        );
    }

    /**
     * @api
     *
     * Get File Metadata
     *
     * @param string $fileID ID of the File
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FileMetadata>
     *
     * @throws APIException
     */
    public function retrieveMetadata(
        string $fileID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/files/%1$s', $fileID],
            options: $requestOptions,
            convert: FileMetadata::class,
        );
    }

    /**
     * @api
     *
     * Upload File
     *
     * @param array{
     *   file: string|FileParam, expiresInSeconds?: int
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

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/files',
            headers: ['Content-Type' => 'multipart/form-data'],
            body: (object) $parsed,
            options: $options,
            convert: FileMetadata::class,
        );
    }
}
