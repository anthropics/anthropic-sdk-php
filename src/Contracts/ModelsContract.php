<?php

declare(strict_types=1);

namespace Anthropic\Contracts;

use Anthropic\Models\ModelInfo;
use Anthropic\RequestOptions;

interface ModelsContract
{
    /**
     * @param array{modelID?: string, betas?: list<string|string>} $params
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
    public function retrieve(
        string $modelID,
        array $params,
        mixed $requestOptions = []
    ): ModelInfo;

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
    ): ModelInfo;
}
