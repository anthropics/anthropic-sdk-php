<?php

declare(strict_types=1);

namespace Anthropic\Contracts\Beta;

use Anthropic\RequestOptions;
use Anthropic\Models\Beta\BetaModelInfo;

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
        mixed $requestOptions = [],
    ): BetaModelInfo;

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
        mixed $requestOptions = [],
    ): BetaModelInfo;
}
