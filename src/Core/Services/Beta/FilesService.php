<?php

declare(strict_types=1);

namespace Anthropic\Core\Services\Beta;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Files\DeletedFile;
use Anthropic\Beta\Files\FileDeleteParams;
use Anthropic\Beta\Files\FileListParams;
use Anthropic\Beta\Files\FileMetadata;
use Anthropic\Beta\Files\FileRetrieveMetadataParams;
use Anthropic\Client;
use Anthropic\Core\Conversion;
use Anthropic\Core\ServiceContracts\Beta\FilesContract;
use Anthropic\Core\Util;
use Anthropic\RequestOptions;

use const Anthropic\Core\OMIT as omit;

final class FilesService implements FilesContract
{
    public function __construct(private Client $client) {}

    /**
     * List Files.
     *
     * @param string $afterID ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately after this object.
     * @param string $beforeID ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately before this object.
     * @param int $limit Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     * @param list<AnthropicBeta::*|string> $betas optional header to specify the beta version(s) you want to use
     */
    public function list(
        $afterID = omit,
        $beforeID = omit,
        $limit = omit,
        $betas = omit,
        ?RequestOptions $requestOptions = null,
    ): FileMetadata {
        [$parsed, $options] = FileListParams::parseRequest(
            [
                'afterID' => $afterID,
                'beforeID' => $beforeID,
                'limit' => $limit,
                'betas' => $betas,
            ],
            $requestOptions,
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
     * @param list<AnthropicBeta::*|string> $betas optional header to specify the beta version(s) you want to use
     */
    public function delete(
        string $fileID,
        $betas = omit,
        ?RequestOptions $requestOptions = null
    ): DeletedFile {
        [$parsed, $options] = FileDeleteParams::parseRequest(
            ['betas' => $betas],
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
     * @param list<AnthropicBeta::*|string> $betas optional header to specify the beta version(s) you want to use
     */
    public function retrieveMetadata(
        string $fileID,
        $betas = omit,
        ?RequestOptions $requestOptions = null
    ): FileMetadata {
        [$parsed, $options] = FileRetrieveMetadataParams::parseRequest(
            ['betas' => $betas],
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
