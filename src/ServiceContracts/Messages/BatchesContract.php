<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Messages;

use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Messages\Batches\BatchCreateParams\Request;
use Anthropic\Messages\Batches\DeletedMessageBatch;
use Anthropic\Messages\Batches\MessageBatch;
use Anthropic\Messages\Batches\MessageBatchIndividualResponse;
use Anthropic\Page;
use Anthropic\RequestOptions;

use const Anthropic\Core\OMIT as omit;

interface BatchesContract
{
    /**
     * @api
     *
     * @param list<Request> $requests List of requests for prompt completion. Each is an individual request to create a Message.
     */
    public function create(
        $requests,
        ?RequestOptions $requestOptions = null
    ): MessageBatch;

    /**
     * @api
     */
    public function retrieve(
        string $messageBatchID,
        ?RequestOptions $requestOptions = null
    ): MessageBatch;

    /**
     * @api
     *
     * @param string $afterID ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately after this object.
     * @param string $beforeID ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately before this object.
     * @param int $limit Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     *
     * @return Page<MessageBatch>
     */
    public function list(
        $afterID = omit,
        $beforeID = omit,
        $limit = omit,
        ?RequestOptions $requestOptions = null,
    ): Page;

    /**
     * @api
     */
    public function delete(
        string $messageBatchID,
        ?RequestOptions $requestOptions = null
    ): DeletedMessageBatch;

    /**
     * @api
     */
    public function cancel(
        string $messageBatchID,
        ?RequestOptions $requestOptions = null
    ): MessageBatch;

    /**
     * @api
     */
    public function results(
        string $messageBatchID,
        ?RequestOptions $requestOptions = null
    ): MessageBatchIndividualResponse;

    /**
     * @return BaseStream<MessageBatchIndividualResponse>
     */
    public function resultsStream(
        string $messageBatchID,
        ?RequestOptions $requestOptions = null
    ): BaseStream;
}
