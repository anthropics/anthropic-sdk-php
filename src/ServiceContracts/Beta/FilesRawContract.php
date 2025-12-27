<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta;

use Anthropic\Beta\Files\DeletedFile;
use Anthropic\Beta\Files\FileDeleteParams;
use Anthropic\Beta\Files\FileListParams;
use Anthropic\Beta\Files\FileMetadata;
use Anthropic\Beta\Files\FileRetrieveMetadataParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Page;
use Anthropic\RequestOptions;

interface FilesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|FileListParams $params
     *
     * @return BaseResponse<Page<FileMetadata>>
     *
     * @throws APIException
     */
    public function list(
        array|FileListParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $fileID ID of the File
     * @param array<string,mixed>|FileDeleteParams $params
     *
     * @return BaseResponse<DeletedFile>
     *
     * @throws APIException
     */
    public function delete(
        string $fileID,
        array|FileDeleteParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $fileID ID of the File
     * @param array<string,mixed>|FileRetrieveMetadataParams $params
     *
     * @return BaseResponse<FileMetadata>
     *
     * @throws APIException
     */
    public function retrieveMetadata(
        string $fileID,
        array|FileRetrieveMetadataParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;
}
