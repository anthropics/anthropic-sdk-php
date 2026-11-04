<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts;

use Anthropic\ClaudeCodeKeyCreatorNotMemberException;
use Anthropic\CMEKKeyDisabledException;
use Anthropic\CMEKKeyNetworkBlockedException;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Files\DeletedFile;
use Anthropic\Files\FileDeleteParams;
use Anthropic\Files\FileDownloadParams;
use Anthropic\Files\FileExpiredException;
use Anthropic\Files\FileListParams;
use Anthropic\Files\FileMetadata;
use Anthropic\Files\FileNotDownloadableException;
use Anthropic\Files\FileRetrieveMetadataParams;
use Anthropic\Files\FileUploadParams;
use Anthropic\Files\StorageQuotaExceededException;
use Anthropic\OrganizationOnHoldException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface FilesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|FileListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<FileMetadata>>
     *
     * @throws ClaudeCodeKeyCreatorNotMemberException
     * @throws CMEKKeyDisabledException
     * @throws CMEKKeyNetworkBlockedException
     * @throws OrganizationOnHoldException
     * @throws APIException
     */
    public function list(
        array|FileListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $fileID ID of the File.
     * @param array<string,mixed>|FileDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<DeletedFile>
     *
     * @throws ClaudeCodeKeyCreatorNotMemberException
     * @throws CMEKKeyDisabledException
     * @throws CMEKKeyNetworkBlockedException
     * @throws OrganizationOnHoldException
     * @throws APIException
     */
    public function delete(
        string $fileID,
        array|FileDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $fileID ID of the File.
     * @param array<string,mixed>|FileDownloadParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<string>
     *
     * @throws ClaudeCodeKeyCreatorNotMemberException
     * @throws CMEKKeyDisabledException
     * @throws CMEKKeyNetworkBlockedException
     * @throws FileNotDownloadableException
     * @throws OrganizationOnHoldException
     * @throws FileExpiredException
     * @throws APIException
     */
    public function download(
        string $fileID,
        array|FileDownloadParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $fileID ID of the File.
     * @param array<string,mixed>|FileRetrieveMetadataParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FileMetadata>
     *
     * @throws ClaudeCodeKeyCreatorNotMemberException
     * @throws CMEKKeyDisabledException
     * @throws CMEKKeyNetworkBlockedException
     * @throws OrganizationOnHoldException
     * @throws APIException
     */
    public function retrieveMetadata(
        string $fileID,
        array|FileRetrieveMetadataParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|FileUploadParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FileMetadata>
     *
     * @throws ClaudeCodeKeyCreatorNotMemberException
     * @throws CMEKKeyDisabledException
     * @throws CMEKKeyNetworkBlockedException
     * @throws OrganizationOnHoldException
     * @throws StorageQuotaExceededException
     * @throws APIException
     */
    public function upload(
        array|FileUploadParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
