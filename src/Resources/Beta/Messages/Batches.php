<?php

declare(strict_types=1);

namespace Anthropic\Resources\Beta\Messages;

use Anthropic\Client;
use Anthropic\Contracts\Beta\Messages\BatchesContract;
use Anthropic\Core\Conversion;
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
     * Send a batch of Message creation requests.
     *
     * The Message Batches API can be used to process multiple Messages API requests at once. Once a Message Batch is created, it begins processing immediately. Batches can take up to 24 hours to complete.
     *
     * Learn more about the Message Batches API in our [user guide](/en/docs/build-with-claude/batch-processing)
     *
     * @param array{
     *   requests: list<Request>, anthropicBeta?: list<string|UnionMember1::*>
     * }|BatchCreateParam $params
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
        return Conversion::coerce(MessageBatch::class, value: $resp);
    }

    /**
     * This endpoint is idempotent and can be used to poll for Message Batch completion. To access the results of a Message Batch, make a request to the `results_url` field in the response.
     *
     * Learn more about the Message Batches API in our [user guide](/en/docs/build-with-claude/batch-processing)
     *
     * @param array{
     *   anthropicBeta?: list<string|UnionMember1::*>
     * }|BatchRetrieveParam $params
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
        return Conversion::coerce(MessageBatch::class, value: $resp);
    }

    /**
     * List all Message Batches within a Workspace. Most recently created batches are returned first.
     *
     * Learn more about the Message Batches API in our [user guide](/en/docs/build-with-claude/batch-processing)
     *
     * @param array{
     *   afterID?: string,
     *   beforeID?: string,
     *   limit?: int,
     *   anthropicBeta?: list<string|UnionMember1::*>,
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
        return Conversion::coerce(MessageBatch::class, value: $resp);
    }

    /**
     * Delete a Message Batch.
     *
     * Message Batches can only be deleted once they've finished processing. If you'd like to delete an in-progress batch, you must first cancel it.
     *
     * Learn more about the Message Batches API in our [user guide](/en/docs/build-with-claude/batch-processing)
     *
     * @param array{
     *   anthropicBeta?: list<string|UnionMember1::*>
     * }|BatchDeleteParam $params
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
        return Conversion::coerce(DeletedMessageBatch::class, value: $resp);
    }

    /**
     * Batches may be canceled any time before processing ends. Once cancellation is initiated, the batch enters a `canceling` state, at which time the system may complete any in-progress, non-interruptible requests before finalizing cancellation.
     *
     * The number of canceled requests is specified in `request_counts`. To determine which requests were canceled, check the individual results within the batch. Note that cancellation may not result in any canceled requests if they were non-interruptible.
     *
     * Learn more about the Message Batches API in our [user guide](/en/docs/build-with-claude/batch-processing)
     *
     * @param array{
     *   anthropicBeta?: list<string|UnionMember1::*>
     * }|BatchCancelParam $params
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
        return Conversion::coerce(MessageBatch::class, value: $resp);
    }

    /**
     * Streams the results of a Message Batch as a `.jsonl` file.
     *
     * Each line in the file is a JSON object containing the result of a single request in the Message Batch. Results are not guaranteed to be in the same order as requests. Use the `custom_id` field to match results to requests.
     *
     * Learn more about the Message Batches API in our [user guide](/en/docs/build-with-claude/batch-processing)
     *
     * @param array{
     *   anthropicBeta?: list<string|UnionMember1::*>
     * }|BatchResultsParam $params
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
        return Conversion::coerce(
            MessageBatchIndividualResponse::class,
            value: $resp
        );
    }
}
