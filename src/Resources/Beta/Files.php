<?php

declare(strict_types=1);

namespace Anthropic\Resources\Beta;

use Anthropic\Client;
use Anthropic\Contracts\Beta\FilesContract;
use Anthropic\Core\Serde;
use Anthropic\Core\Util;
use Anthropic\Models\Beta\DeletedFile;
use Anthropic\Models\Beta\FileMetadata;
use Anthropic\Parameters\Beta\Files\DeleteParams;
use Anthropic\Parameters\Beta\Files\DownloadParams;
use Anthropic\Parameters\Beta\Files\ListParams;
use Anthropic\Parameters\Beta\Files\RetrieveMetadataParams;
use Anthropic\Parameters\Beta\Files\UploadParams;
use Anthropic\RequestOptions;

class Files implements FilesContract
{
    public function __construct(protected Client $client) {}

    /**
     * @param array{
     *   afterID?: string, beforeID?: string, limit?: int, betas?: list<string|string>
     * } $params
     */
    public function list(
        array $params,
        ?RequestOptions $requestOptions = null
    ): FileMetadata {
        [$parsed, $options] = ListParams::parseRequest($params, $requestOptions);
        $query_params = array_flip(['after_id', 'before_id', 'limit']);

        /** @var array<string, string> */
        $header_params = array_diff_key($parsed, $query_params);
        $resp = $this->client->request(
            method: 'get',
            path: 'v1/files?beta=true',
            query: array_intersect_key($parsed, $query_params),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: array_merge(
                ['extraHeaders' => ['anthropic-beta' => 'files-api-2025-04-14']],
                $options,
            ),
        );

        // @phpstan-ignore-next-line;
        return Serde::coerce(FileMetadata::class, value: $resp);
    }

    /**
     * @param array{fileID?: string, betas?: list<string|string>} $params
     */
    public function delete(
        string $fileID,
        array $params,
        ?RequestOptions $requestOptions = null
    ): DeletedFile {
        [$parsed, $options] = DeleteParams::parseRequest($params, $requestOptions);
        $resp = $this->client->request(
            method: 'delete',
            path: ['v1/files/%1$s?beta=true', $fileID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: array_merge(
                ['extraHeaders' => ['anthropic-beta' => 'files-api-2025-04-14']],
                $options,
            ),
        );

        // @phpstan-ignore-next-line;
        return Serde::coerce(DeletedFile::class, value: $resp);
    }

    /**
     * @param array{fileID?: string, betas?: list<string|string>} $params
     */
    public function download(
        string $fileID,
        array $params,
        ?RequestOptions $requestOptions = null
    ): mixed {
        [$parsed, $options] = DownloadParams::parseRequest(
            $params,
            $requestOptions
        );
        $resp = $this->client->request(
            method: 'get',
            path: ['v1/files/%1$s/content?beta=true', $fileID],
            headers: Util::array_transform_keys(
                ['Accept' => 'application/binary', ...$parsed],
                ['betas' => 'anthropic-beta'],
            ),
            options: array_merge(
                ['extraHeaders' => ['anthropic-beta' => 'files-api-2025-04-14']],
                $options,
            ),
        );

        // @phpstan-ignore-next-line;
        return Serde::coerce('mixed', value: $resp);
    }

    /**
     * @param array{fileID?: string, betas?: list<string|string>} $params
     */
    public function retrieveMetadata(
        string $fileID,
        array $params,
        ?RequestOptions $requestOptions = null
    ): FileMetadata {
        [$parsed, $options] = RetrieveMetadataParams::parseRequest(
            $params,
            $requestOptions
        );
        $resp = $this->client->request(
            method: 'get',
            path: ['v1/files/%1$s?beta=true', $fileID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: array_merge(
                ['extraHeaders' => ['anthropic-beta' => 'files-api-2025-04-14']],
                $options,
            ),
        );

        // @phpstan-ignore-next-line;
        return Serde::coerce(FileMetadata::class, value: $resp);
    }

    /**
     * @param array{file?: string, betas?: list<string|string>} $params
     */
    public function upload(
        array $params,
        ?RequestOptions $requestOptions = null
    ): FileMetadata {
        [$parsed, $options] = UploadParams::parseRequest($params, $requestOptions);
        $header_params = ['betas' => 'anthropic-beta'];
        $resp = $this->client->request(
            method: 'post',
            path: 'v1/files?beta=true',
            headers: Util::array_transform_keys(
                [
                    'Content-Type' => 'multipart/form-data',
                    ...array_intersect_key($parsed, array_keys($header_params)),
                ],
                $header_params,
            ),
            body: (object) array_diff_key($parsed, array_keys($header_params)),
            options: array_merge(
                ['extraHeaders' => ['anthropic-beta' => 'files-api-2025-04-14']],
                $options,
            ),
        );

        // @phpstan-ignore-next-line;
        return Serde::coerce(FileMetadata::class, value: $resp);
    }
}
