<?php

declare(strict_types=1);

namespace Anthropic\Contracts\Beta;

use Anthropic\Models\AnthropicBeta\UnionMember1;
use Anthropic\Models\Beta\DeletedFile;
use Anthropic\Models\Beta\FileMetadata;
use Anthropic\Parameters\Beta\FileDeleteParams;
use Anthropic\Parameters\Beta\FileDownloadParams;
use Anthropic\Parameters\Beta\FileListParams;
use Anthropic\Parameters\Beta\FileRetrieveMetadataParams;
use Anthropic\Parameters\Beta\FileUploadParams;
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
