<?php

declare(strict_types=1);

namespace Anthropic\Contracts;

use Anthropic\Models\Completion;
use Anthropic\Models\Metadata;
use Anthropic\RequestOptions;

interface CompletionsContract
{
    /**
     * @param array{
     *
     *       maxTokensToSample?: int,
     *       model?: string|string,
     *       prompt?: string,
     *       metadata?: Metadata,
     *       stopSequences?: list<string>,
     *       stream?: bool,
     *       temperature?: float,
     *       topK?: int,
     *       topP?: float,
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
    public function create(
        array $params,
        mixed $requestOptions = []
    ): Completion;
}
