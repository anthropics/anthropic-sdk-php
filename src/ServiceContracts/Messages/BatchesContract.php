<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Messages;

use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Implementation\HasRawResponse;
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
     *
     * @return MessageBatch<HasRawResponse>
     *
     * @throws APIException
     */
    public function create(
        $requests,
        ?RequestOptions $requestOptions = null
    ): MessageBatch;

    /**
     * @api
     *
     * @param array<string, mixed> $params
     *
     * @return MessageBatch<HasRawResponse>
     *
     * @throws APIException
     */
    public function createRaw(
        array $params,
        ?RequestOptions $requestOptions = null
    ): MessageBatch;

    /**
     * @api
     *
     * @return MessageBatch<HasRawResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $messageBatchID,
        ?RequestOptions $requestOptions = null
    ): MessageBatch;

    /**
     * @api
     *
     * @return MessageBatch<HasRawResponse>
     *
     * @throws APIException
     */
    public function retrieveRaw(
        string $messageBatchID,
        mixed $params,
        ?RequestOptions $requestOptions = null,
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
     *
     * @throws APIException
     */
    public function list(
        $afterID = omit,
        $beforeID = omit,
        $limit = omit,
        ?RequestOptions $requestOptions = null,
    ): Page;

    /**
     * @api
     *
     * @param array<string, mixed> $params
     *
     * @return Page<MessageBatch>
     *
     * @throws APIException
     */
    public function listRaw(
        array $params,
        ?RequestOptions $requestOptions = null
    ): Page;

    /**
     * @api
     *
     * @return DeletedMessageBatch<HasRawResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $messageBatchID,
        ?RequestOptions $requestOptions = null
    ): DeletedMessageBatch;

    /**
     * @api
     *
     * @return DeletedMessageBatch<HasRawResponse>
     *
     * @throws APIException
     */
    public function deleteRaw(
        string $messageBatchID,
        mixed $params,
        ?RequestOptions $requestOptions = null,
    ): DeletedMessageBatch;

    /**
     * @api
     *
     * @return MessageBatch<HasRawResponse>
     *
     * @throws APIException
     */
    public function cancel(
        string $messageBatchID,
        ?RequestOptions $requestOptions = null
    ): MessageBatch;

    /**
     * @api
     *
     * @return MessageBatch<HasRawResponse>
     *
     * @throws APIException
     */
    public function cancelRaw(
        string $messageBatchID,
        mixed $params,
        ?RequestOptions $requestOptions = null,
    ): MessageBatch;

    /**
     * @api
     *
     * @return MessageBatchIndividualResponse<HasRawResponse>
     *
     * @throws APIException
     */
    public function results(
        string $messageBatchID,
        ?RequestOptions $requestOptions = null
    ): MessageBatchIndividualResponse;

    /**
     * @api
     *
     * @return MessageBatchIndividualResponse<HasRawResponse>
     *
     * @throws APIException
     */
    public function resultsRaw(
        string $messageBatchID,
        mixed $params,
        ?RequestOptions $requestOptions = null,
    ): MessageBatchIndividualResponse;

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
    ): BaseStream;

    /**
     * @api
     *
     * @return BaseStream<MessageBatchIndividualResponse>
     *
     * @throws APIException
     */
    public function resultsStreamRaw(
        string $messageBatchID,
        mixed $params,
        ?RequestOptions $requestOptions = null,
    ): BaseStream;
}
