<?php

declare(strict_types=1);

namespace Anthropic\Resources\Beta\Messages;

use Anthropic\Client;
use Anthropic\Contracts\Beta\Messages\BatchesContract;
use Anthropic\Core\Serde;
use Anthropic\Core\Util;
use Anthropic\Models\AnthropicBeta\UnionMember1;
use Anthropic\Models\Beta\Messages\DeletedMessageBatch;
use Anthropic\Models\Beta\Messages\MessageBatch;
use Anthropic\Models\Beta\Messages\MessageBatchIndividualResponse;
use Anthropic\Parameters\Beta\Messages\BatchCancelParam;
use Anthropic\Parameters\Beta\Messages\BatchCreateParam;
use Anthropic\Parameters\Beta\Messages\BatchCreateParam\Request;
use Anthropic\Parameters\Beta\Messages\BatchDeleteParam;
use Anthropic\Parameters\Beta\Messages\BatchListParam;
use Anthropic\Parameters\Beta\Messages\BatchResultsParam;
use Anthropic\Parameters\Beta\Messages\BatchRetrieveParam;
use Anthropic\RequestOptions;

final class Batches implements BatchesContract
{
    public function __construct(private Client $client) {}

    /**
     * @param BatchCreateParam|array{
     *   requests?: list<Request>, anthropicBeta?: list<string|UnionMember1::*>
     * } $params
     */
    public function create(
        array|BatchCreateParam $params,
        ?RequestOptions $requestOptions = null
    ): MessageBatch {
        [$parsed, $options] = BatchCreateParam::parseRequest(
            $params,
            $requestOptions
        );
        $header_params = ['betas' => 'anthropic-beta'];
        $resp = $this->client->request(
            method: 'post',
            path: 'v1/messages/batches?beta=true',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_keys($header_params)),
                $header_params
            ),
            body: (object) array_diff_key($parsed, array_keys($header_params)),
            options: array_merge(
                ['extraHeaders' => ['anthropic-beta' => 'message-batches-2024-09-24']],
                $options,
            ),
        );

        // @phpstan-ignore-next-line;
        return Serde::coerce(MessageBatch::class, value: $resp);
    }

    /**
     * @param BatchRetrieveParam|array{
     *   anthropicBeta?: list<string|UnionMember1::*>
     * } $params
     */
    public function retrieve(
        string $messageBatchID,
        array|BatchRetrieveParam $params,
        ?RequestOptions $requestOptions = null,
    ): MessageBatch {
        [$parsed, $options] = BatchRetrieveParam::parseRequest(
            $params,
            $requestOptions
        );
        $resp = $this->client->request(
            method: 'get',
            path: ['v1/messages/batches/%1$s?beta=true', $messageBatchID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: array_merge(
                ['extraHeaders' => ['anthropic-beta' => 'message-batches-2024-09-24']],
                $options,
            ),
        );

        // @phpstan-ignore-next-line;
        return Serde::coerce(MessageBatch::class, value: $resp);
    }

    /**
     * @param BatchListParam|array{
     *   afterID?: string,
     *   beforeID?: string,
     *   limit?: int,
     *   anthropicBeta?: list<string|UnionMember1::*>,
     * } $params
     */
    public function list(
        array|BatchListParam $params,
        ?RequestOptions $requestOptions = null
    ): MessageBatch {
        [$parsed, $options] = BatchListParam::parseRequest(
            $params,
            $requestOptions
        );
        $query_params = array_flip(['after_id', 'before_id', 'limit']);

        /** @var array<string, string> */
        $header_params = array_diff_key($parsed, $query_params);
        $resp = $this->client->request(
            method: 'get',
            path: 'v1/messages/batches?beta=true',
            query: array_intersect_key($parsed, $query_params),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: array_merge(
                ['extraHeaders' => ['anthropic-beta' => 'message-batches-2024-09-24']],
                $options,
            ),
        );

        // @phpstan-ignore-next-line;
        return Serde::coerce(MessageBatch::class, value: $resp);
    }

    /**
     * @param BatchDeleteParam|array{
     *   anthropicBeta?: list<string|UnionMember1::*>
     * } $params
     */
    public function delete(
        string $messageBatchID,
        array|BatchDeleteParam $params,
        ?RequestOptions $requestOptions = null,
    ): DeletedMessageBatch {
        [$parsed, $options] = BatchDeleteParam::parseRequest(
            $params,
            $requestOptions
        );
        $resp = $this->client->request(
            method: 'delete',
            path: ['v1/messages/batches/%1$s?beta=true', $messageBatchID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: array_merge(
                ['extraHeaders' => ['anthropic-beta' => 'message-batches-2024-09-24']],
                $options,
            ),
        );

        // @phpstan-ignore-next-line;
        return Serde::coerce(DeletedMessageBatch::class, value: $resp);
    }

    /**
     * @param BatchCancelParam|array{
     *   anthropicBeta?: list<string|UnionMember1::*>
     * } $params
     */
    public function cancel(
        string $messageBatchID,
        array|BatchCancelParam $params,
        ?RequestOptions $requestOptions = null,
    ): MessageBatch {
        [$parsed, $options] = BatchCancelParam::parseRequest(
            $params,
            $requestOptions
        );
        $resp = $this->client->request(
            method: 'post',
            path: ['v1/messages/batches/%1$s/cancel?beta=true', $messageBatchID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: array_merge(
                ['extraHeaders' => ['anthropic-beta' => 'message-batches-2024-09-24']],
                $options,
            ),
        );

        // @phpstan-ignore-next-line;
        return Serde::coerce(MessageBatch::class, value: $resp);
    }

    /**
     * @param BatchResultsParam|array{
     *   anthropicBeta?: list<string|UnionMember1::*>
     * } $params
     */
    public function results(
        string $messageBatchID,
        array|BatchResultsParam $params,
        ?RequestOptions $requestOptions = null,
    ): MessageBatchIndividualResponse {
        [$parsed, $options] = BatchResultsParam::parseRequest(
            $params,
            $requestOptions
        );
        $resp = $this->client->request(
            method: 'get',
            path: ['v1/messages/batches/%1$s/results?beta=true', $messageBatchID],
            headers: Util::array_transform_keys(
                ['Accept' => 'application/x-jsonl', ...$parsed],
                ['betas' => 'anthropic-beta'],
            ),
            options: array_merge(
                ['extraHeaders' => ['anthropic-beta' => 'message-batches-2024-09-24']],
                $options,
            ),
        );

        // @phpstan-ignore-next-line;
        return Serde::coerce(MessageBatchIndividualResponse::class, value: $resp);
    }
}
