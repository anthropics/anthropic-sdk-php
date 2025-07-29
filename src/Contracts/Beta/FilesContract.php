<?php

declare(strict_types=1);

namespace Anthropic\Contracts\Beta;

use Anthropic\Models\AnthropicBeta\UnionMember1;
use Anthropic\Models\Beta\DeletedFile;
use Anthropic\Models\Beta\FileMetadata;
use Anthropic\Parameters\Beta\FileDeleteParam;
use Anthropic\Parameters\Beta\FileDownloadParam;
use Anthropic\Parameters\Beta\FileListParam;
use Anthropic\Parameters\Beta\FileRetrieveMetadataParam;
use Anthropic\Parameters\Beta\FileUploadParam;
use Anthropic\RequestOptions;

interface FilesContract
{
    /**
     * @param array{
     *   afterID?: string,
     *   beforeID?: string,
     *   limit?: int,
     *   anthropicBeta?: list<string|UnionMember1::*>,
     * }|FileListParam $params
     */
    public function list(
        array|FileListParam $params,
        ?RequestOptions $requestOptions = null
    ): FileMetadata;

    /**
     * @param array{
     *   anthropicBeta?: list<string|UnionMember1::*>
     * }|FileDeleteParam $params
     */
    public function delete(
        string $fileID,
        array|FileDeleteParam $params,
        ?RequestOptions $requestOptions = null,
    ): DeletedFile;

    /**
     * @param array{
     *   anthropicBeta?: list<string|UnionMember1::*>
     * }|FileDownloadParam $params
     */
    public function download(
        string $fileID,
        array|FileDownloadParam $params,
        ?RequestOptions $requestOptions = null,
    ): string;

    /**
     * @param array{
     *   anthropicBeta?: list<string|UnionMember1::*>
     * }|FileRetrieveMetadataParam $params
     */
    public function retrieveMetadata(
        string $fileID,
        array|FileRetrieveMetadataParam $params,
        ?RequestOptions $requestOptions = null,
    ): FileMetadata;

    /**
     * @param array{
     *   file: string, anthropicBeta?: list<string|UnionMember1::*>
     * }|FileUploadParam $params
     */
    public function upload(
        array|FileUploadParam $params,
        ?RequestOptions $requestOptions = null
    ): FileMetadata;
}
