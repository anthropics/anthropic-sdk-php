<?php

declare(strict_types=1);

namespace Anthropic\Contracts\Beta;

use Anthropic\Models\Beta\DeletedFile;
use Anthropic\Models\Beta\FileMetadata;
use Anthropic\RequestOptions;

interface FilesContract
{
    /**
     * @param array{
     *   afterID?: string, beforeID?: string, limit?: int, betas?: list<string|string>
     * } $params
     */
    public function list(
        array $params,
        ?RequestOptions $requestOptions = null
    ): FileMetadata;

    /**
     * @param array{fileID?: string, betas?: list<string|string>} $params
     */
    public function delete(
        string $fileID,
        array $params,
        ?RequestOptions $requestOptions = null
    ): DeletedFile;

    /**
     * @param array{fileID?: string, betas?: list<string|string>} $params
     */
    public function download(
        string $fileID,
        array $params,
        ?RequestOptions $requestOptions = null
    ): mixed;

    /**
     * @param array{fileID?: string, betas?: list<string|string>} $params
     */
    public function retrieveMetadata(
        string $fileID,
        array $params,
        ?RequestOptions $requestOptions = null
    ): FileMetadata;

    /**
     * @param array{file?: string, betas?: list<string|string>} $params
     */
    public function upload(
        array $params,
        ?RequestOptions $requestOptions = null
    ): FileMetadata;
}
