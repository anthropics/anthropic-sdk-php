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
     *
     *       afterID?: string,
     *       beforeID?: string,
     *       limit?: int,
     *       betas?: list<string|string>,
     *
     * } $params
     * @param RequestOptions|array{
     *
     *       timeout?: float|null,
     *       maxRetries?: int|null,
     *       initialRetryDelay?: float|null,
     *       maxRetryDelay?: float|null,
     *       extraHeaders?: list<string>|null,
     *       extraQueryParams?: list<string>|null,
     *       extraBodyParams?: list<string>|null,
     *
     * }|null $requestOptions
     */
    public function list(
        array $params,
        mixed $requestOptions = []
    ): FileMetadata;

    /**
     * @param array{fileID?: string, betas?: list<string|string>} $params
     * @param RequestOptions|array{
     *
     *       timeout?: float|null,
     *       maxRetries?: int|null,
     *       initialRetryDelay?: float|null,
     *       maxRetryDelay?: float|null,
     *       extraHeaders?: list<string>|null,
     *       extraQueryParams?: list<string>|null,
     *       extraBodyParams?: list<string>|null,
     *
     * }|null $requestOptions
     */
    public function delete(
        string $fileID,
        array $params,
        mixed $requestOptions = []
    ): DeletedFile;

    /**
     * @param array{fileID?: string, betas?: list<string|string>} $params
     * @param RequestOptions|array{
     *
     *       timeout?: float|null,
     *       maxRetries?: int|null,
     *       initialRetryDelay?: float|null,
     *       maxRetryDelay?: float|null,
     *       extraHeaders?: list<string>|null,
     *       extraQueryParams?: list<string>|null,
     *       extraBodyParams?: list<string>|null,
     *
     * }|null $requestOptions
     */
    public function download(
        string $fileID,
        array $params,
        mixed $requestOptions = []
    ): mixed;

    /**
     * @param array{fileID?: string, betas?: list<string|string>} $params
     * @param RequestOptions|array{
     *
     *       timeout?: float|null,
     *       maxRetries?: int|null,
     *       initialRetryDelay?: float|null,
     *       maxRetryDelay?: float|null,
     *       extraHeaders?: list<string>|null,
     *       extraQueryParams?: list<string>|null,
     *       extraBodyParams?: list<string>|null,
     *
     * }|null $requestOptions
     */
    public function retrieveMetadata(
        string $fileID,
        array $params,
        mixed $requestOptions = []
    ): FileMetadata;

    /**
     * @param array{file?: string, betas?: list<string|string>} $params
     * @param RequestOptions|array{
     *
     *       timeout?: float|null,
     *       maxRetries?: int|null,
     *       initialRetryDelay?: float|null,
     *       maxRetryDelay?: float|null,
     *       extraHeaders?: list<string>|null,
     *       extraQueryParams?: list<string>|null,
     *       extraBodyParams?: list<string>|null,
     *
     * }|null $requestOptions
     */
    public function upload(
        array $params,
        mixed $requestOptions = []
    ): FileMetadata;
}
