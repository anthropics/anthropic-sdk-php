<?php

declare(strict_types=1);

namespace Anthropic\Resources;

use Anthropic\Client;
use Anthropic\Contracts\CompletionsContract;
use Anthropic\Core\Serde;
use Anthropic\Core\Util;
use Anthropic\Models\AnthropicBeta\UnionMember1;
use Anthropic\Models\Completion;
use Anthropic\Models\Metadata;
use Anthropic\Models\Model\UnionMember0;
use Anthropic\Parameters\CompletionCreateParam;
use Anthropic\Parameters\CompletionCreateParam\Stream;
use Anthropic\RequestOptions;

final class Completions implements CompletionsContract
{
    public function __construct(private Client $client) {}

    /**
     * @param CompletionCreateParam|array{
     *   maxTokensToSample?: int,
     *   model?: UnionMember0::*|string,
     *   prompt?: string,
     *   metadata?: Metadata,
     *   stopSequences?: list<string>,
     *   stream?: Stream::*,
     *   temperature?: float,
     *   topK?: int,
     *   topP?: float,
     *   anthropicBeta?: list<string|UnionMember1::*>,
     * } $params
     */
    public function create(
        array|CompletionCreateParam $params,
        ?RequestOptions $requestOptions = null
    ): Completion {
        [$parsed, $options] = CompletionCreateParam::parseRequest(
            $params,
            $requestOptions
        );
        $header_params = ['betas' => 'anthropic-beta'];
        $resp = $this->client->request(
            method: 'post',
            path: 'v1/complete',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_keys($header_params)),
                $header_params
            ),
            body: (object) array_diff_key($parsed, array_keys($header_params)),
            options: array_merge(['timeout' => 600], $options),
        );

        // @phpstan-ignore-next-line;
        return Serde::coerce(Completion::class, value: $resp);
    }
}
