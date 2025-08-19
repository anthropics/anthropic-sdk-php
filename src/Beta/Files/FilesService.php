<?php

declare(strict_types=1);

namespace Anthropic\Beta\Files;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Client;
use Anthropic\Contracts\Beta\FilesContract;
use Anthropic\Core\Conversion;
use Anthropic\Core\Util;
use Anthropic\RequestOptions;

final class FilesService implements FilesContract
{
    public function __construct(private Client $client) {}

    /**
     * List Files.
     *
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
    ): FileMetadata {
        [$parsed, $options] = FileListParams::parseRequest(
            $params,
            $requestOptions
        );
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
     * @param array{
     *   anthropicBeta?: list<AnthropicBeta::*|string>
     * }|FileDeleteParams $params
     */
    public function delete(
        string $fileID,
        array|FileDeleteParams $params,
        ?RequestOptions $requestOptions = null,
    ): DeletedFile {
        [$parsed, $options] = FileDeleteParams::parseRequest(
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
     * Get File Metadata.
     *
     * @param array{
     *   anthropicBeta?: list<AnthropicBeta::*|string>
     * }|FileRetrieveMetadataParams $params
     */
    public function retrieveMetadata(
        string $fileID,
        array|FileRetrieveMetadataParams $params,
        ?RequestOptions $requestOptions = null,
    ): FileMetadata {
        [$parsed, $options] = FileRetrieveMetadataParams::parseRequest(
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
}
