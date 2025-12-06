<?php

declare(strict_types=1);

namespace Anthropic\Services\Messages;

use Anthropic\Client;
use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Messages\Batches\BatchCreateParams;
use Anthropic\Messages\Batches\BatchListParams;
use Anthropic\Messages\Batches\DeletedMessageBatch;
use Anthropic\Messages\Batches\MessageBatch;
use Anthropic\Messages\Batches\MessageBatchIndividualResponse;
use Anthropic\Messages\Model;
use Anthropic\Page;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Messages\BatchesContract;
use Anthropic\SSEStream;

final class BatchesService implements BatchesContract
{
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Send a batch of Message creation requests.
     *
     * The Message Batches API can be used to process multiple Messages API requests at once. Once a Message Batch is created, it begins processing immediately. Batches can take up to 24 hours to complete.
     *
     * Learn more about the Message Batches API in our [user guide](https://docs.claude.com/en/docs/build-with-claude/batch-processing)
     *
     * @param array{
     *   requests: list<array{
     *     custom_id: string,
     *     params: array{
     *       max_tokens: int,
     *       messages: list<array<mixed>>,
     *       model: string|Model,
     *       metadata?: array<mixed>,
     *       service_tier?: 'auto'|'standard_only',
     *       stop_sequences?: list<string>,
     *       stream?: bool,
     *       system?: string|list<array<mixed>>,
     *       temperature?: float,
     *       thinking?: array<string,mixed>,
     *       tool_choice?: array<string,mixed>,
     *       tools?: list<array<string,mixed>>,
     *       top_k?: int,
     *       top_p?: float,
     *     },
     *   }>,
     * }|BatchCreateParams $params
     *
     * @throws APIException
     */
    public function create(
        array|BatchCreateParams $params,
        ?RequestOptions $requestOptions = null
    ): MessageBatch {
        [$parsed, $options] = BatchCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/messages/batches',
            body: (object) $parsed,
            options: $options,
            convert: MessageBatch::class,
        );
    }

    /**
     * @api
     *
     * This endpoint is idempotent and can be used to poll for Message Batch completion. To access the results of a Message Batch, make a request to the `results_url` field in the response.
     *
     * Learn more about the Message Batches API in our [user guide](https://docs.claude.com/en/docs/build-with-claude/batch-processing)
     *
     * @throws APIException
     */
    public function retrieve(
        string $messageBatchID,
        ?RequestOptions $requestOptions = null
    ): MessageBatch {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/messages/batches/%1$s', $messageBatchID],
            options: $requestOptions,
            convert: MessageBatch::class,
        );
    }

    /**
     * @api
     *
     * List all Message Batches within a Workspace. Most recently created batches are returned first.
     *
     * Learn more about the Message Batches API in our [user guide](https://docs.claude.com/en/docs/build-with-claude/batch-processing)
     *
     * @param array{
     *   after_id?: string, before_id?: string, limit?: int
     * }|BatchListParams $params
     *
     * @return Page<MessageBatch>
     *
     * @throws APIException
     */
    public function list(
        array|BatchListParams $params,
        ?RequestOptions $requestOptions = null
    ): Page {
        [$parsed, $options] = BatchListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/messages/batches',
            query: $parsed,
            options: $options,
            convert: MessageBatch::class,
            page: Page::class,
        );
    }

    /**
     * @api
     *
     * Delete a Message Batch.
     *
     * Message Batches can only be deleted once they've finished processing. If you'd like to delete an in-progress batch, you must first cancel it.
     *
     * Learn more about the Message Batches API in our [user guide](https://docs.claude.com/en/docs/build-with-claude/batch-processing)
     *
     * @throws APIException
     */
    public function delete(
        string $messageBatchID,
        ?RequestOptions $requestOptions = null
    ): DeletedMessageBatch {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/messages/batches/%1$s', $messageBatchID],
            options: $requestOptions,
            convert: DeletedMessageBatch::class,
        );
    }

    /**
     * @api
     *
     * Batches may be canceled any time before processing ends. Once cancellation is initiated, the batch enters a `canceling` state, at which time the system may complete any in-progress, non-interruptible requests before finalizing cancellation.
     *
     * The number of canceled requests is specified in `request_counts`. To determine which requests were canceled, check the individual results within the batch. Note that cancellation may not result in any canceled requests if they were non-interruptible.
     *
     * Learn more about the Message Batches API in our [user guide](https://docs.claude.com/en/docs/build-with-claude/batch-processing)
     *
     * @throws APIException
     */
    public function cancel(
        string $messageBatchID,
        ?RequestOptions $requestOptions = null
    ): MessageBatch {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/messages/batches/%1$s/cancel', $messageBatchID],
            options: $requestOptions,
            convert: MessageBatch::class,
        );
    }

    /**
     * @api
     *
     * Streams the results of a Message Batch as a `.jsonl` file.
     *
     * Each line in the file is a JSON object containing the result of a single request in the Message Batch. Results are not guaranteed to be in the same order as requests. Use the `custom_id` field to match results to requests.
     *
     * Learn more about the Message Batches API in our [user guide](https://docs.claude.com/en/docs/build-with-claude/batch-processing)
     *
     * @throws APIException
     */
    public function results(
        string $messageBatchID,
        ?RequestOptions $requestOptions = null
    ): MessageBatchIndividualResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/messages/batches/%1$s/results', $messageBatchID],
            headers: ['Accept' => 'application/x-jsonl'],
            options: $requestOptions,
            convert: MessageBatchIndividualResponse::class,
        );
    }

    /**
     * @api
     *
     * @return BaseStream<MessageBatchIndividualResponse>
     *
     * @throws APIException
     */
    public function resultsStream(
        string $messageBatchID,
        ?RequestOptions $requestOptions = null
    ): BaseStream {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/messages/batches/%1$s/results', $messageBatchID],
            headers: ['Accept' => 'application/x-jsonl'],
            options: $requestOptions,
            convert: MessageBatchIndividualResponse::class,
            stream: SSEStream::class,
        );
    }
}
