<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta;

use Anthropic\Beta\Files\DeletedFile;
use Anthropic\Beta\Files\FileDeleteParams;
use Anthropic\Beta\Files\FileListParams;
use Anthropic\Beta\Files\FileMetadata;
use Anthropic\Beta\Files\FileRetrieveMetadataParams;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\Page;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\FilesContract;

final class FilesService implements FilesContract
{
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * List Files
     *
     * @param array{
     *   after_id?: string, before_id?: string, limit?: int, betas?: list<string>
     * }|FileListParams $params
     *
     * @return Page<FileMetadata>
     *
     * @throws APIException
     */
    public function list(
        array|FileListParams $params,
        ?RequestOptions $requestOptions = null
    ): Page {
        [$parsed, $options] = FileListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(['after_id', 'before_id', 'limit']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/files?beta=true',
            query: array_intersect_key($parsed, $query_params),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'files-api-2025-04-14']],
                $options,
            ),
            convert: FileMetadata::class,
            page: Page::class,
        );
    }

    /**
     * @api
     *
     * Delete File
     *
     * @param array{betas?: list<string>}|FileDeleteParams $params
     *
     * @throws APIException
     */
    public function delete(
        string $fileID,
        array|FileDeleteParams $params,
        ?RequestOptions $requestOptions = null,
    ): DeletedFile {
        [$parsed, $options] = FileDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/files/%1$s?beta=true', $fileID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'files-api-2025-04-14']],
                $options,
            ),
            convert: DeletedFile::class,
        );
    }

    /**
     * @api
     *
     * Get File Metadata
     *
     * @param array{betas?: list<string>}|FileRetrieveMetadataParams $params
     *
     * @throws APIException
     */
    public function retrieveMetadata(
        string $fileID,
        array|FileRetrieveMetadataParams $params,
        ?RequestOptions $requestOptions = null,
    ): FileMetadata {
        [$parsed, $options] = FileRetrieveMetadataParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/files/%1$s?beta=true', $fileID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'files-api-2025-04-14']],
                $options,
            ),
            convert: FileMetadata::class,
        );
    }
}
