<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Files\DeletedFile;
use Anthropic\Beta\Files\FileMetadata;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Implementation\HasRawResponse;
use Anthropic\Page;
use Anthropic\RequestOptions;

use const Anthropic\Core\OMIT as omit;

interface FilesContract
{
    /**
     * @api
     *
     * @param string $afterID ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately after this object.
     * @param string $beforeID ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately before this object.
     * @param int $limit Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     * @param list<string|AnthropicBeta> $betas optional header to specify the beta version(s) you want to use
     *
     * @return Page<FileMetadata>
     *
     * @throws APIException
     */
    public function list(
        $afterID = omit,
        $beforeID = omit,
        $limit = omit,
        $betas = omit,
        ?RequestOptions $requestOptions = null,
    ): Page;

    /**
     * @api
     *
     * @param array<string, mixed> $params
     *
     * @return Page<FileMetadata>
     *
     * @throws APIException
     */
    public function listRaw(
        array $params,
        ?RequestOptions $requestOptions = null
    ): Page;

    /**
     * @api
     *
     * @param list<string|AnthropicBeta> $betas optional header to specify the beta version(s) you want to use
     *
     * @return DeletedFile<HasRawResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $fileID,
        $betas = omit,
        ?RequestOptions $requestOptions = null
    ): DeletedFile;

    /**
     * @api
     *
     * @param array<string, mixed> $params
     *
     * @return DeletedFile<HasRawResponse>
     *
     * @throws APIException
     */
    public function deleteRaw(
        string $fileID,
        array $params,
        ?RequestOptions $requestOptions = null
    ): DeletedFile;

    /**
     * @api
     *
     * @param list<string|AnthropicBeta> $betas optional header to specify the beta version(s) you want to use
     *
     * @return FileMetadata<HasRawResponse>
     *
     * @throws APIException
     */
    public function retrieveMetadata(
        string $fileID,
        $betas = omit,
        ?RequestOptions $requestOptions = null
    ): FileMetadata;

    /**
     * @api
     *
     * @param array<string, mixed> $params
     *
     * @return FileMetadata<HasRawResponse>
     *
     * @throws APIException
     */
    public function retrieveMetadataRaw(
        string $fileID,
        array $params,
        ?RequestOptions $requestOptions = null
    ): FileMetadata;
}
