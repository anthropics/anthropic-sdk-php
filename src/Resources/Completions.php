<?php

declare(strict_types=1);

namespace Anthropic\Resources;

use Anthropic\Client;
use Anthropic\Contracts\CompletionsContract;
use Anthropic\Core\Serde;
use Anthropic\Core\Util;
use Anthropic\Models\Completion;
use Anthropic\Models\Metadata;
use Anthropic\Parameters\Completions\CreateParams;
use Anthropic\RequestOptions;

class Completions implements CompletionsContract
{
    public function __construct(protected Client $client) {}

    /**
     * @param array{
     *
     *     maxTokensToSample?: int,
     *     model?: string|string,
     *     prompt?: string,
     *     metadata?: Metadata,
     *     stopSequences?: list<string>,
     *     stream?: bool,
     *     temperature?: float,
     *     topK?: int,
     *     topP?: float,
     *     betas?: list<string|string>,
     *
     * } $params
     * @param RequestOptions|array{
     *
     *     timeout?: float|null,
     *     maxRetries?: int|null,
     *     initialRetryDelay?: float|null,
     *     maxRetryDelay?: float|null,
     *     extraHeaders?: list<string>|null,
     *     extraQueryParams?: list<string>|null,
     *     extraBodyParams?: list<string>|null,
     *
     * }|null $requestOptions
     */
    public function create(
        array $params,
        mixed $requestOptions = []
    ): Completion {
        [$parsed, $options] = CreateParams::parseRequest($params, $requestOptions);
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
