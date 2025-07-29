<?php

declare(strict_types=1);

namespace Anthropic\Resources\Messages;

use Anthropic\Client;
use Anthropic\Contracts\Messages\BatchesContract;
use Anthropic\Core\Conversion;
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
     * Send a batch of Message creation requests.
     *
     * The Message Batches API can be used to process multiple Messages API requests at once. Once a Message Batch is created, it begins processing immediately. Batches can take up to 24 hours to complete.
     *
     * Learn more about the Message Batches API in our [user guide](/en/docs/build-with-claude/batch-processing)
     *
     * @param array{requests: list<Request>}|BatchCreateParam $params
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
        return Conversion::coerce(MessageBatch::class, value: $resp);
    }

    /**
     * This endpoint is idempotent and can be used to poll for Message Batch completion. To access the results of a Message Batch, make a request to the `results_url` field in the response.
     *
     * Learn more about the Message Batches API in our [user guide](/en/docs/build-with-claude/batch-processing)
     */
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
        return Conversion::coerce(MessageBatch::class, value: $resp);
    }

    /**
     * List all Message Batches within a Workspace. Most recently created batches are returned first.
     *
     * Learn more about the Message Batches API in our [user guide](/en/docs/build-with-claude/batch-processing)
     *
     * @param array{
     *   afterID?: string, beforeID?: string, limit?: int
     * }|BatchListParam $params
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
        return Conversion::coerce(MessageBatch::class, value: $resp);
    }

    /**
     * Delete a Message Batch.
     *
     * Message Batches can only be deleted once they've finished processing. If you'd like to delete an in-progress batch, you must first cancel it.
     *
     * Learn more about the Message Batches API in our [user guide](/en/docs/build-with-claude/batch-processing)
     */
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
        return Conversion::coerce(DeletedMessageBatch::class, value: $resp);
    }

    /**
     * Batches may be canceled any time before processing ends. Once cancellation is initiated, the batch enters a `canceling` state, at which time the system may complete any in-progress, non-interruptible requests before finalizing cancellation.
     *
     * The number of canceled requests is specified in `request_counts`. To determine which requests were canceled, check the individual results within the batch. Note that cancellation may not result in any canceled requests if they were non-interruptible.
     *
     * Learn more about the Message Batches API in our [user guide](/en/docs/build-with-claude/batch-processing)
     */
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
        return Conversion::coerce(MessageBatch::class, value: $resp);
    }

    /**
     * Streams the results of a Message Batch as a `.jsonl` file.
     *
     * Each line in the file is a JSON object containing the result of a single request in the Message Batch. Results are not guaranteed to be in the same order as requests. Use the `custom_id` field to match results to requests.
     *
     * Learn more about the Message Batches API in our [user guide](/en/docs/build-with-claude/batch-processing)
     */
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
        return Conversion::coerce(
            MessageBatchIndividualResponse::class,
            value: $resp
        );
    }
}
