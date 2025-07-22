<?php

declare(strict_types=1);

namespace Anthropic\Resources\Beta;

use Anthropic\Client;
use Anthropic\Contracts\Beta\FilesContract;
use Anthropic\Core\Conversion;
use Anthropic\Core\Util;
use Anthropic\Models\AnthropicBeta\UnionMember1;
use Anthropic\Models\Beta\DeletedFile;
use Anthropic\Models\Beta\FileMetadata;
use Anthropic\Parameters\Beta\FileDeleteParam;
use Anthropic\Parameters\Beta\FileDownloadParam;
use Anthropic\Parameters\Beta\FileListParam;
use Anthropic\Parameters\Beta\FileRetrieveMetadataParam;
use Anthropic\Parameters\Beta\FileUploadParam;
use Anthropic\RequestOptions;

final class Files implements FilesContract
{
    public function __construct(private Client $client) {}

    /**
     * List Files.
     *
     * @param FileListParam|array{
     *   afterID?: string,
     *   beforeID?: string,
     *   limit?: int,
     *   anthropicBeta?: list<string|UnionMember1::*>,
     * } $params
     */
    public function list(
        array|FileListParam $params,
        ?RequestOptions $requestOptions = null
    ): FileMetadata {
        [$parsed, $options] = FileListParam::parseRequest($params, $requestOptions);
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
        return Conversion::coerce(FileMetadata::class, value: $resp);
    }

    /**
     * Delete File.
     *
     * @param FileDeleteParam|array{
     *   anthropicBeta?: list<string|UnionMember1::*>
     * } $params
     */
    public function delete(
        string $fileID,
        array|FileDeleteParam $params,
        ?RequestOptions $requestOptions = null,
    ): DeletedFile {
        [$parsed, $options] = FileDeleteParam::parseRequest(
            $params,
            $requestOptions
        );
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
        return Conversion::coerce(DeletedFile::class, value: $resp);
    }

    /**
     * Download File.
     *
     * @param FileDownloadParam|array{
     *   anthropicBeta?: list<string|UnionMember1::*>
     * } $params
     */
    public function download(
        string $fileID,
        array|FileDownloadParam $params,
        ?RequestOptions $requestOptions = null,
    ): string {
        [$parsed, $options] = FileDownloadParam::parseRequest(
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
        return Conversion::coerce('string', value: $resp);
    }

    /**
     * Get File Metadata.
     *
     * @param FileRetrieveMetadataParam|array{
     *   anthropicBeta?: list<string|UnionMember1::*>
     * } $params
     */
    public function retrieveMetadata(
        string $fileID,
        array|FileRetrieveMetadataParam $params,
        ?RequestOptions $requestOptions = null,
    ): FileMetadata {
        [$parsed, $options] = FileRetrieveMetadataParam::parseRequest(
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
        return Conversion::coerce(FileMetadata::class, value: $resp);
    }

    /**
     * Upload File.
     *
     * @param FileUploadParam|array{
     *   file: string, anthropicBeta?: list<string|UnionMember1::*>
     * } $params
     */
    public function upload(
        array|FileUploadParam $params,
        ?RequestOptions $requestOptions = null
    ): FileMetadata {
        [$parsed, $options] = FileUploadParam::parseRequest(
            $params,
            $requestOptions
        );
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
        return Conversion::coerce(FileMetadata::class, value: $resp);
    }
}
