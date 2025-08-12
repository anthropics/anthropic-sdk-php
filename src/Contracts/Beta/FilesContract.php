<?php

declare(strict_types=1);

namespace Anthropic\Contracts\Beta;

use Anthropic\Beta\AnthropicBeta\UnionMember1;
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
     *   anthropicBeta?: list<string|UnionMember1::*>,
     * }|FileListParams $params
     */
    public function list(
        array|FileListParams $params,
        ?RequestOptions $requestOptions = null
    ): FileMetadata;

    /**
     * @param array{
     *   anthropicBeta?: list<string|UnionMember1::*>
     * }|FileDeleteParams $params
     */
    public function delete(
        string $fileID,
        array|FileDeleteParams $params,
        ?RequestOptions $requestOptions = null,
    ): DeletedFile;

    /**
     * @param array{
     *   anthropicBeta?: list<string|UnionMember1::*>
     * }|FileDownloadParams $params
     */
    public function download(
        string $fileID,
        array|FileDownloadParams $params,
        ?RequestOptions $requestOptions = null,
    ): string;

    /**
     * @param array{
     *   anthropicBeta?: list<string|UnionMember1::*>
     * }|FileRetrieveMetadataParams $params
     */
    public function retrieveMetadata(
        string $fileID,
        array|FileRetrieveMetadataParams $params,
        ?RequestOptions $requestOptions = null,
    ): FileMetadata;

    /**
     * @param array{
     *   file: string, anthropicBeta?: list<string|UnionMember1::*>
     * }|FileUploadParams $params
     */
    public function upload(
        array|FileUploadParams $params,
        ?RequestOptions $requestOptions = null
    ): FileMetadata;
}
