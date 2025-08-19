<?php

declare(strict_types=1);

namespace Anthropic\Contracts;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Completions\Completion;
use Anthropic\Completions\CompletionCreateParams;
use Anthropic\Messages\Metadata;
use Anthropic\Messages\Model;
use Anthropic\RequestOptions;

interface CompletionsContract
{
    /**
     * @param array{
     *   maxTokensToSample: int,
     *   model: Model::*|string,
     *   prompt: string,
     *   metadata?: Metadata,
     *   stopSequences?: list<string>,
     *   temperature?: float,
     *   topK?: int,
     *   topP?: float,
     *   anthropicBeta?: list<AnthropicBeta::*|string>,
     * }|CompletionCreateParams $params
     */
    public function create(
        array|CompletionCreateParams $params,
        ?RequestOptions $requestOptions = null,
    ): Completion;
}
