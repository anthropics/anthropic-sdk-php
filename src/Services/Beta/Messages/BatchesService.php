<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Messages;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Messages\Batches\BatchCancelParams;
use Anthropic\Beta\Messages\Batches\BatchCreateParams;
use Anthropic\Beta\Messages\Batches\BatchCreateParams\Request;
use Anthropic\Beta\Messages\Batches\BatchDeleteParams;
use Anthropic\Beta\Messages\Batches\BatchListParams;
use Anthropic\Beta\Messages\Batches\BatchResultsParams;
use Anthropic\Beta\Messages\Batches\BatchRetrieveParams;
use Anthropic\Beta\Messages\Batches\DeletedMessageBatch;
use Anthropic\Beta\Messages\Batches\MessageBatch;
use Anthropic\Beta\Messages\Batches\MessageBatchIndividualResponse;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Util;
use Anthropic\Page;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Messages\BatchesContract;
use Anthropic\SSEStream;

use const Anthropic\Core\OMIT as omit;

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
     * Learn more about the Message Batches API in our [user guide](/en/docs/build-with-claude/batch-processing)
     *
     * @param list<Request> $requests List of requests for prompt completion. Each is an individual request to create a Message.
     * @param list<AnthropicBeta::*|string> $betas optional header to specify the beta version(s) you want to use
     */
    public function create(
        $requests,
        $betas = omit,
        ?RequestOptions $requestOptions = null
    ): MessageBatch {
        [$parsed, $options] = BatchCreateParams::parseRequest(
            ['requests' => $requests, 'betas' => $betas],
            $requestOptions
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line;
        return $this->client->request(
            method: 'post',
            path: 'v1/messages/batches?beta=true',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_keys($header_params)),
                $header_params
            ),
            body: (object) array_diff_key($parsed, array_keys($header_params)),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'message-batches-2024-09-24']],
                $options,
            ),
            convert: MessageBatch::class,
        );
    }

    /**
     * @api
     *
     * This endpoint is idempotent and can be used to poll for Message Batch completion. To access the results of a Message Batch, make a request to the `results_url` field in the response.
     *
     * Learn more about the Message Batches API in our [user guide](/en/docs/build-with-claude/batch-processing)
     *
     * @param list<AnthropicBeta::*|string> $betas optional header to specify the beta version(s) you want to use
     */
    public function retrieve(
        string $messageBatchID,
        $betas = omit,
        ?RequestOptions $requestOptions = null,
    ): MessageBatch {
        [$parsed, $options] = BatchRetrieveParams::parseRequest(
            ['betas' => $betas],
            $requestOptions
        );

        // @phpstan-ignore-next-line;
        return $this->client->request(
            method: 'get',
            path: ['v1/messages/batches/%1$s?beta=true', $messageBatchID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'message-batches-2024-09-24']],
                $options,
            ),
            convert: MessageBatch::class,
        );
    }

    /**
     * @api
     *
     * List all Message Batches within a Workspace. Most recently created batches are returned first.
     *
     * Learn more about the Message Batches API in our [user guide](/en/docs/build-with-claude/batch-processing)
     *
     * @param string $afterID ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately after this object.
     * @param string $beforeID ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately before this object.
     * @param int $limit Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     * @param list<AnthropicBeta::*|string> $betas optional header to specify the beta version(s) you want to use
     *
     * @return Page<MessageBatch>
     */
    public function list(
        $afterID = omit,
        $beforeID = omit,
        $limit = omit,
        $betas = omit,
        ?RequestOptions $requestOptions = null,
    ): Page {
        [$parsed, $options] = BatchListParams::parseRequest(
            [
                'afterID' => $afterID,
                'beforeID' => $beforeID,
                'limit' => $limit,
                'betas' => $betas,
            ],
            $requestOptions,
        );
        $query_params = array_flip(['after_id', 'before_id', 'limit']);

        /** @var array<string, string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line;
        return $this->client->request(
            method: 'get',
            path: 'v1/messages/batches?beta=true',
            query: array_intersect_key($parsed, $query_params),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'message-batches-2024-09-24']],
                $options,
            ),
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
     * Learn more about the Message Batches API in our [user guide](/en/docs/build-with-claude/batch-processing)
     *
     * @param list<AnthropicBeta::*|string> $betas optional header to specify the beta version(s) you want to use
     */
    public function delete(
        string $messageBatchID,
        $betas = omit,
        ?RequestOptions $requestOptions = null,
    ): DeletedMessageBatch {
        [$parsed, $options] = BatchDeleteParams::parseRequest(
            ['betas' => $betas],
            $requestOptions
        );

        // @phpstan-ignore-next-line;
        return $this->client->request(
            method: 'delete',
            path: ['v1/messages/batches/%1$s?beta=true', $messageBatchID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'message-batches-2024-09-24']],
                $options,
            ),
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
     * Learn more about the Message Batches API in our [user guide](/en/docs/build-with-claude/batch-processing)
     *
     * @param list<AnthropicBeta::*|string> $betas optional header to specify the beta version(s) you want to use
     */
    public function cancel(
        string $messageBatchID,
        $betas = omit,
        ?RequestOptions $requestOptions = null,
    ): MessageBatch {
        [$parsed, $options] = BatchCancelParams::parseRequest(
            ['betas' => $betas],
            $requestOptions
        );

        // @phpstan-ignore-next-line;
        return $this->client->request(
            method: 'post',
            path: ['v1/messages/batches/%1$s/cancel?beta=true', $messageBatchID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'message-batches-2024-09-24']],
                $options,
            ),
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
     * Learn more about the Message Batches API in our [user guide](/en/docs/build-with-claude/batch-processing)
     *
     * @param list<AnthropicBeta::*|string> $betas optional header to specify the beta version(s) you want to use
     */
    public function results(
        string $messageBatchID,
        $betas = omit,
        ?RequestOptions $requestOptions = null,
    ): MessageBatchIndividualResponse {
        [$parsed, $options] = BatchResultsParams::parseRequest(
            ['betas' => $betas],
            $requestOptions
        );

        // @phpstan-ignore-next-line;
        return $this->client->request(
            method: 'get',
            path: ['v1/messages/batches/%1$s/results?beta=true', $messageBatchID],
            headers: Util::array_transform_keys(
                ['Accept' => 'application/x-jsonl', ...$parsed],
                ['betas' => 'anthropic-beta'],
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'message-batches-2024-09-24']],
                $options,
            ),
            convert: MessageBatchIndividualResponse::class,
        );
    }

    /**
     * @param list<AnthropicBeta::*|string> $betas optional header to specify the beta version(s) you want to use
     *
     * @return BaseStream<MessageBatchIndividualResponse>
     */
    public function resultsStream(
        string $messageBatchID,
        $betas = omit,
        ?RequestOptions $requestOptions = null,
    ): BaseStream {
        [$parsed, $options] = BatchResultsParams::parseRequest(
            ['betas' => $betas],
            $requestOptions
        );

        // @phpstan-ignore-next-line;
        return $this->client->request(
            method: 'get',
            path: ['v1/messages/batches/%1$s/results?beta=true', $messageBatchID],
            headers: Util::array_transform_keys(
                ['Accept' => 'application/x-jsonl', ...$parsed],
                ['betas' => 'anthropic-beta'],
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'message-batches-2024-09-24']],
                $options,
            ),
            convert: MessageBatchIndividualResponse::class,
            stream: SSEStream::class,
        );
    }
}
