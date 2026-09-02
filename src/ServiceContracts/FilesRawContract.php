<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts;

use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Files\DeletedFile;
use Anthropic\Files\FileDeleteParams;
use Anthropic\Files\FileDownloadParams;
use Anthropic\Files\FileListParams;
use Anthropic\Files\FileMetadata;
use Anthropic\Files\FileRetrieveMetadataParams;
use Anthropic\Files\FileUploadParams;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface FilesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|FileListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<FileMetadata>>
     *
     * @throws APIException
     */
    public function list(
        array|FileListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $fileID ID of the File
     * @param array<string,mixed>|FileDeleteParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $fileID ID of the File
     * @param array<string,mixed>|FileDownloadParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $fileID ID of the File
     * @param array<string,mixed>|FileRetrieveMetadataParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|FileUploadParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FileMetadata>
     *
     * @throws APIException
     */
    public function upload(
        array|FileUploadParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
