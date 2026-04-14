<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Files\DeletedFile;
use Anthropic\Beta\Files\FileMetadata;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\FileParam;
use Anthropic\Page;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface FilesContract
{
    /**
     * @api
     *
     * @param string $afterID Query param: ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately after this object.
     * @param string $beforeID Query param: ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately before this object.
     * @param int $limit Query param: Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     * @param string $scopeID Query param: Filter by scope ID. Only returns files associated with the specified scope (e.g., a session ID).
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @return Page<FileMetadata>
     *
     * @throws APIException
     */
    public function list(
        ?string $afterID = null,
        ?string $beforeID = null,
        int $limit = 20,
        ?string $scopeID = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): Page;

    /**
     * @api
     *
     * @param string $fileID ID of the File
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $fileID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): DeletedFile;

    /**
     * @api
     *
     * @param string $fileID ID of the File
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function download(
        string $fileID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): string;

    /**
     * @api
     *
     * @param string $fileID ID of the File
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveMetadata(
        string $fileID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): FileMetadata;

    /**
     * @api
     *
     * @param string|FileParam $file Body param: The file to upload
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function upload(
        string|FileParam $file,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): FileMetadata;
}
