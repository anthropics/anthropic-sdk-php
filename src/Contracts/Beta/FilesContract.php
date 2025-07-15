<?php

declare(strict_types=1);

namespace Anthropic\Contracts\Beta;

use Anthropic\Models\Beta\DeletedFile;
use Anthropic\Models\Beta\FileMetadata;
use Anthropic\Parameters\Beta\Files\DeleteParams;
use Anthropic\Parameters\Beta\Files\DownloadParams;
use Anthropic\Parameters\Beta\Files\ListParams;
use Anthropic\Parameters\Beta\Files\RetrieveMetadataParams;
use Anthropic\Parameters\Beta\Files\UploadParams;
use Anthropic\RequestOptions;

interface FilesContract
{
    /**
     * @param ListParams|array{
     *   afterID?: string, beforeID?: string, limit?: int, anthropicBeta?: list<string>
     * } $params
     */
    public function list(
        array|ListParams $params,
        ?RequestOptions $requestOptions = null
    ): FileMetadata;

    /**
     * @param array{anthropicBeta?: list<string>}|DeleteParams $params
     */
    public function delete(
        string $fileID,
        array|DeleteParams $params,
        ?RequestOptions $requestOptions = null,
    ): DeletedFile;

    /**
     * @param array{anthropicBeta?: list<string>}|DownloadParams $params
     */
    public function download(
        string $fileID,
        array|DownloadParams $params,
        ?RequestOptions $requestOptions = null,
    ): string;

    /**
     * @param array{anthropicBeta?: list<string>}|RetrieveMetadataParams $params
     */
    public function retrieveMetadata(
        string $fileID,
        array|RetrieveMetadataParams $params,
        ?RequestOptions $requestOptions = null,
    ): FileMetadata;

    /**
     * @param array{file?: string, anthropicBeta?: list<string>}|UploadParams $params
     */
    public function upload(
        array|UploadParams $params,
        ?RequestOptions $requestOptions = null
    ): FileMetadata;
}
