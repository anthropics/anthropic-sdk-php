<?php

declare(strict_types=1);

namespace Anthropic\Contracts\Beta;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Files\DeletedFile;
use Anthropic\Beta\Files\FileDeleteParams;
use Anthropic\Beta\Files\FileDownloadParams;
use Anthropic\Beta\Files\FileListParams;
use Anthropic\Beta\Files\FileMetadata;
use Anthropic\Beta\Files\FileRetrieveMetadataParams;
use Anthropic\Beta\Files\FileUploadParams;
use Anthropic\RequestOptions;

interface FilesContract
{
    /**
     * @param array{
     *   afterID?: string,
     *   beforeID?: string,
     *   limit?: int,
     *   anthropicBeta?: list<AnthropicBeta::*|string>,
     * }|FileListParams $params
     */
    public function list(
        array|FileListParams $params,
        ?RequestOptions $requestOptions = null
    ): FileMetadata;

    /**
     * @param array{
     *   anthropicBeta?: list<AnthropicBeta::*|string>
     * }|FileDeleteParams $params
     */
    public function delete(
        string $fileID,
        array|FileDeleteParams $params,
        ?RequestOptions $requestOptions = null,
    ): DeletedFile;

    /**
     * @param array{
     *   anthropicBeta?: list<AnthropicBeta::*|string>
     * }|FileDownloadParams $params
     */
    public function download(
        string $fileID,
        array|FileDownloadParams $params,
        ?RequestOptions $requestOptions = null,
    ): string;

    /**
     * @param array{
     *   anthropicBeta?: list<AnthropicBeta::*|string>
     * }|FileRetrieveMetadataParams $params
     */
    public function retrieveMetadata(
        string $fileID,
        array|FileRetrieveMetadataParams $params,
        ?RequestOptions $requestOptions = null,
    ): FileMetadata;

    /**
     * @param array{
     *   file: string, anthropicBeta?: list<AnthropicBeta::*|string>
     * }|FileUploadParams $params
     */
    public function upload(
        array|FileUploadParams $params,
        ?RequestOptions $requestOptions = null
    ): FileMetadata;
}
