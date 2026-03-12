<?php

declare(strict_types=1);

namespace Anthropic\Services\Messages;

use Anthropic\Client;
use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\Messages\Batches\BatchCreateParams\Request;
use Anthropic\Messages\Batches\DeletedMessageBatch;
use Anthropic\Messages\Batches\MessageBatch;
use Anthropic\Messages\Batches\MessageBatchIndividualResponse;
use Anthropic\Page;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Messages\BatchesContract;

/**
 * @phpstan-import-type RequestShape from \Anthropic\Messages\Batches\BatchCreateParams\Request
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class BatchesService implements BatchesContract
{
    /**
     * @api
     */
    public BatchesRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new BatchesRawService($client);
    }

    /**
     * @api
     *
     * Send a batch of Message creation requests.
     *
     * The Message Batches API can be used to process multiple Messages API requests at once. Once a Message Batch is created, it begins processing immediately. Batches can take up to 24 hours to complete.
     *
     * Learn more about the Message Batches API in our [user guide](https://docs.claude.com/en/docs/build-with-claude/batch-processing)
     *
     * @param list<Request|RequestShape> $requests List of requests for prompt completion. Each is an individual request to create a Message.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        array $requests,
        RequestOptions|array|null $requestOptions = null
    ): MessageBatch {
        $params = Util::removeNulls(['requests' => $requests]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * This endpoint is idempotent and can be used to poll for Message Batch completion. To access the results of a Message Batch, make a request to the `results_url` field in the response.
     *
     * Learn more about the Message Batches API in our [user guide](https://docs.claude.com/en/docs/build-with-claude/batch-processing)
     *
     * @param string $messageBatchID ID of the Message Batch
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $messageBatchID,
        RequestOptions|array|null $requestOptions = null
    ): MessageBatch {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($messageBatchID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List all Message Batches within a Workspace. Most recently created batches are returned first.
     *
     * Learn more about the Message Batches API in our [user guide](https://docs.claude.com/en/docs/build-with-claude/batch-processing)
     *
     * @param string $afterID ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately after this object.
     * @param string $beforeID ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately before this object.
     * @param int $limit Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     * @param RequestOpts|null $requestOptions
     *
     * @return Page<MessageBatch>
     *
     * @throws APIException
     */
    public function list(
        ?string $afterID = null,
        ?string $beforeID = null,
        int $limit = 20,
        RequestOptions|array|null $requestOptions = null,
    ): Page {
        $params = Util::removeNulls(
            ['afterID' => $afterID, 'beforeID' => $beforeID, 'limit' => $limit]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
     * @param string $messageBatchID ID of the Message Batch
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $messageBatchID,
        RequestOptions|array|null $requestOptions = null
    ): DeletedMessageBatch {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($messageBatchID, requestOptions: $requestOptions);

        return $response->parse();
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
     * @param string $messageBatchID ID of the Message Batch
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function cancel(
        string $messageBatchID,
        RequestOptions|array|null $requestOptions = null
    ): MessageBatch {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->cancel($messageBatchID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * @param string $messageBatchID ID of the Message Batch
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseStream<MessageBatchIndividualResponse>
     *
     * @throws APIException
     */
    public function resultsStream(
        string $messageBatchID,
        RequestOptions|array|null $requestOptions = null
    ): BaseStream {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->resultsStream($messageBatchID, requestOptions: $requestOptions);

        return $response->parse();
    }
}
