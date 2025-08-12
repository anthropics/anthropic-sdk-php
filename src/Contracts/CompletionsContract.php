<?php

declare(strict_types=1);

namespace Anthropic\Contracts;

use Anthropic\Beta\AnthropicBeta\UnionMember1;
use Anthropic\Completions\Completion;
use Anthropic\Completions\CompletionCreateParams;
use Anthropic\Messages\Metadata;
use Anthropic\Messages\Model\UnionMember0;
use Anthropic\RequestOptions;

interface CompletionsContract
{
    /**
     * @param array{
     *   maxTokensToSample: int,
     *   model: string|UnionMember0::*,
     *   prompt: string,
     *   metadata?: Metadata,
     *   stopSequences?: list<string>,
     *   temperature?: float,
     *   topK?: int,
     *   topP?: float,
     *   anthropicBeta?: list<string|UnionMember1::*>,
     * }|CompletionCreateParams $params
     */
    public function create(
        array|CompletionCreateParams $params,
        ?RequestOptions $requestOptions = null,
    ): Completion;
}
