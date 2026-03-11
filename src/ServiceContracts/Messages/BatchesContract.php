<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Messages;

use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Messages\Batches\BatchCreateParams\Request;
use Anthropic\Messages\Batches\DeletedMessageBatch;
use Anthropic\Messages\Batches\MessageBatch;
use Anthropic\Messages\Batches\MessageBatchIndividualResponse;
use Anthropic\Page;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestShape from \Anthropic\Messages\Batches\BatchCreateParams\Request
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface BatchesContract
{
    /**
     * @api
     *
     * @param list<Request|RequestShape> $requests List of requests for prompt completion. Each is an individual request to create a Message.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        array $requests,
        RequestOptions|array|null $requestOptions = null
    ): MessageBatch;

    /**
     * @api
     *
     * @param string $messageBatchID ID of the Message Batch
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $messageBatchID,
        RequestOptions|array|null $requestOptions = null
    ): MessageBatch;

    /**
     * @api
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
    ): Page;

    /**
     * @api
     *
     * @param string $messageBatchID ID of the Message Batch
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $messageBatchID,
        RequestOptions|array|null $requestOptions = null
    ): DeletedMessageBatch;

    /**
     * @api
     *
     * @param string $messageBatchID ID of the Message Batch
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function cancel(
        string $messageBatchID,
        RequestOptions|array|null $requestOptions = null
    ): MessageBatch;

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
    ): BaseStream;
}
