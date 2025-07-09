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
     *   maxTokensToSample?: int,
     *   model?: string|string,
     *   prompt?: string,
     *   metadata?: Metadata,
     *   stopSequences?: list<string>,
     *   stream?: bool,
     *   temperature?: float,
     *   topK?: int,
     *   topP?: float,
     *   betas?: list<string|string>,
     * } $params
     */
    public function create(
        array $params,
        ?RequestOptions $requestOptions = null
    ): Completion;
}
