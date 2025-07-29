<?php

declare(strict_types=1);

namespace Anthropic\Contracts;

use Anthropic\Models\AnthropicBeta\UnionMember1;
use Anthropic\Models\Completion;
use Anthropic\Models\Metadata;
use Anthropic\Models\Model\UnionMember0;
use Anthropic\Parameters\CompletionCreateParam;
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
     * }|CompletionCreateParam $params
     */
    public function create(
        array|CompletionCreateParam $params,
        ?RequestOptions $requestOptions = null,
    ): Completion;
}
