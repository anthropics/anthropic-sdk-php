<?php

declare(strict_types=1);

namespace Anthropic\Contracts;

use Anthropic\Models\Completion;
use Anthropic\Models\Metadata;
use Anthropic\Parameters\Completions\CreateParams;
use Anthropic\RequestOptions;

interface CompletionsContract
{
    /**
     * @param CreateParams|array{
     *   maxTokensToSample?: int,
     *   model?: string,
     *   prompt?: string,
     *   metadata?: Metadata,
     *   stopSequences?: list<string>,
     *   stream?: bool,
     *   temperature?: float,
     *   topK?: int,
     *   topP?: float,
     *   anthropicBeta?: list<string>,
     * } $params
     */
    public function create(
        array|CreateParams $params,
        ?RequestOptions $requestOptions = null
    ): Completion;
}
