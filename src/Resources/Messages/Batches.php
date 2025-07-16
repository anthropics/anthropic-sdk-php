<?php

declare(strict_types=1);

namespace Anthropic\Resources\Messages;

use Anthropic\Client;
use Anthropic\Contracts\Messages\BatchesContract;
use Anthropic\Core\Serde;
use Anthropic\Models\Messages\DeletedMessageBatch;
use Anthropic\Models\Messages\MessageBatch;
use Anthropic\Models\Messages\MessageBatchIndividualResponse;
use Anthropic\Parameters\Messages\BatchCreateParam;
use Anthropic\Parameters\Messages\BatchCreateParam\Request;
use Anthropic\Parameters\Messages\BatchListParam;
use Anthropic\RequestOptions;

final class Batches implements BatchesContract
{
    public function __construct(private Client $client) {}

    /**
     * @param array{requests?: list<Request>}|BatchCreateParam $params
     */
    public function create(
        array|BatchCreateParam $params,
        ?RequestOptions $requestOptions = null
    ): MessageBatch {
        [$parsed, $options] = BatchCreateParam::parseRequest(
            $params,
            $requestOptions
        );
        $resp = $this->client->request(
            method: 'post',
            path: 'v1/messages/batches',
            body: (object) $parsed,
            options: $options,
        );

        // @phpstan-ignore-next-line;
        return Serde::coerce(MessageBatch::class, value: $resp);
    }

    public function retrieve(
        string $messageBatchID,
        ?RequestOptions $requestOptions = null
    ): MessageBatch {
        $resp = $this->client->request(
            method: 'get',
            path: ['v1/messages/batches/%1$s', $messageBatchID],
            options: $requestOptions,
        );

        // @phpstan-ignore-next-line;
        return Serde::coerce(MessageBatch::class, value: $resp);
    }

    /**
     * @param BatchListParam|array{
     *   afterID?: string, beforeID?: string, limit?: int
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
        $resp = $this->client->request(
            method: 'get',
            path: 'v1/messages/batches',
            query: $parsed,
            options: $options,
        );

        // @phpstan-ignore-next-line;
        return Serde::coerce(MessageBatch::class, value: $resp);
    }

    public function delete(
        string $messageBatchID,
        ?RequestOptions $requestOptions = null
    ): DeletedMessageBatch {
        $resp = $this->client->request(
            method: 'delete',
            path: ['v1/messages/batches/%1$s', $messageBatchID],
            options: $requestOptions,
        );

        // @phpstan-ignore-next-line;
        return Serde::coerce(DeletedMessageBatch::class, value: $resp);
    }

    public function cancel(
        string $messageBatchID,
        ?RequestOptions $requestOptions = null
    ): MessageBatch {
        $resp = $this->client->request(
            method: 'post',
            path: ['v1/messages/batches/%1$s/cancel', $messageBatchID],
            options: $requestOptions,
        );

        // @phpstan-ignore-next-line;
        return Serde::coerce(MessageBatch::class, value: $resp);
    }

    public function results(
        string $messageBatchID,
        ?RequestOptions $requestOptions = null
    ): MessageBatchIndividualResponse {
        $resp = $this->client->request(
            method: 'get',
            path: ['v1/messages/batches/%1$s/results', $messageBatchID],
            headers: ['Accept' => 'application/x-jsonl'],
            options: $requestOptions,
        );

        // @phpstan-ignore-next-line;
        return Serde::coerce(MessageBatchIndividualResponse::class, value: $resp);
    }
}
