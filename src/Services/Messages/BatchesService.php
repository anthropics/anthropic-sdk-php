<?php

declare(strict_types=1);

namespace Anthropic\Services\Messages;

use Anthropic\Client;
use Anthropic\Contracts\Messages\BatchesContract;
use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Conversion;
use Anthropic\Core\Streaming\SSEStream;
use Anthropic\Core\Util;
use Anthropic\Messages\Batches\BatchCreateParams;
use Anthropic\Messages\Batches\BatchCreateParams\Request;
use Anthropic\Messages\Batches\BatchListParams;
use Anthropic\Messages\Batches\DeletedMessageBatch;
use Anthropic\Messages\Batches\MessageBatch;
use Anthropic\Messages\Batches\MessageBatchIndividualResponse;
use Anthropic\RequestOptions;

use const Anthropic\Core\OMIT as omit;

final class BatchesService implements BatchesContract
{
    public function __construct(private Client $client) {}

    /**
     * Send a batch of Message creation requests.
     *
     * The Message Batches API can be used to process multiple Messages API requests at once. Once a Message Batch is created, it begins processing immediately. Batches can take up to 24 hours to complete.
     *
     * Learn more about the Message Batches API in our [user guide](/en/docs/build-with-claude/batch-processing)
     *
     * @param list<Request> $requests List of requests for prompt completion. Each is an individual request to create a Message.
     */
    public function create(
        $requests,
        ?RequestOptions $requestOptions = null
    ): MessageBatch {
        $args = ['requests' => $requests];
        [$parsed, $options] = BatchCreateParams::parseRequest(
            $args,
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
     * @param string $afterID ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately after this object.
     * @param string $beforeID ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately before this object.
     * @param int $limit Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     */
    public function list(
        $afterID = omit,
        $beforeID = omit,
        $limit = omit,
        ?RequestOptions $requestOptions = null,
    ): MessageBatch {
        $args = Util::array_filter_omit(
            ['afterID' => $afterID, 'beforeID' => $beforeID, 'limit' => $limit]
        );
        [$parsed, $options] = BatchListParams::parseRequest($args, $requestOptions);
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

    /**
     * @return BaseStream<MessageBatchIndividualResponse>
     */
    public function resultsStream(
        string $messageBatchID,
        ?RequestOptions $requestOptions = null
    ): BaseStream {
        $resp = $this->client->request(
            method: 'get',
            path: ['v1/messages/batches/%1$s/results', $messageBatchID],
            headers: ['Accept' => 'application/x-jsonl'],
            options: $requestOptions,
        );

        // @phpstan-ignore-next-line;
        return new SSEStream(MessageBatchIndividualResponse::class, stream: $resp);
    }
}
