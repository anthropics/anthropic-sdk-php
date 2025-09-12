<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Messages;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Messages\Batches\BatchCreateParams\Request;
use Anthropic\Beta\Messages\Batches\DeletedMessageBatch;
use Anthropic\Beta\Messages\Batches\MessageBatch;
use Anthropic\Beta\Messages\Batches\MessageBatchIndividualResponse;
use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Implementation\HasRawResponse;
use Anthropic\Page;
use Anthropic\RequestOptions;

use const Anthropic\Core\OMIT as omit;

interface BatchesContract
{
    /**
     * @api
     *
     * @param list<Request> $requests List of requests for prompt completion. Each is an individual request to create a Message.
     * @param list<string|AnthropicBeta> $betas optional header to specify the beta version(s) you want to use
     *
     * @return MessageBatch<HasRawResponse>
     *
     * @throws APIException
     */
    public function create(
        $requests,
        $betas = omit,
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
     * @param list<string|AnthropicBeta> $betas optional header to specify the beta version(s) you want to use
     *
     * @return MessageBatch<HasRawResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $messageBatchID,
        $betas = omit,
        ?RequestOptions $requestOptions = null,
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
    public function retrieveRaw(
        string $messageBatchID,
        array $params,
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
     * @param list<string|AnthropicBeta> $betas optional header to specify the beta version(s) you want to use
     *
     * @return Page<MessageBatch>
     *
     * @throws APIException
     */
    public function list(
        $afterID = omit,
        $beforeID = omit,
        $limit = omit,
        $betas = omit,
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
     * @param list<string|AnthropicBeta> $betas optional header to specify the beta version(s) you want to use
     *
     * @return DeletedMessageBatch<HasRawResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $messageBatchID,
        $betas = omit,
        ?RequestOptions $requestOptions = null,
    ): DeletedMessageBatch;

    /**
     * @api
     *
     * @param array<string, mixed> $params
     *
     * @return DeletedMessageBatch<HasRawResponse>
     *
     * @throws APIException
     */
    public function deleteRaw(
        string $messageBatchID,
        array $params,
        ?RequestOptions $requestOptions = null,
    ): DeletedMessageBatch;

    /**
     * @api
     *
     * @param list<string|AnthropicBeta> $betas optional header to specify the beta version(s) you want to use
     *
     * @return MessageBatch<HasRawResponse>
     *
     * @throws APIException
     */
    public function cancel(
        string $messageBatchID,
        $betas = omit,
        ?RequestOptions $requestOptions = null,
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
    public function cancelRaw(
        string $messageBatchID,
        array $params,
        ?RequestOptions $requestOptions = null,
    ): MessageBatch;

    /**
     * @api
     *
     * @param list<string|AnthropicBeta> $betas optional header to specify the beta version(s) you want to use
     *
     * @return MessageBatchIndividualResponse<HasRawResponse>
     *
     * @throws APIException
     */
    public function results(
        string $messageBatchID,
        $betas = omit,
        ?RequestOptions $requestOptions = null,
    ): MessageBatchIndividualResponse;

    /**
     * @api
     *
     * @param array<string, mixed> $params
     *
     * @return MessageBatchIndividualResponse<HasRawResponse>
     *
     * @throws APIException
     */
    public function resultsRaw(
        string $messageBatchID,
        array $params,
        ?RequestOptions $requestOptions = null,
    ): MessageBatchIndividualResponse;

    /**
     * @api
     *
     * @param list<string|AnthropicBeta> $betas optional header to specify the beta version(s) you want to use
     *
     * @return BaseStream<MessageBatchIndividualResponse>
     *
     * @throws APIException
     */
    public function resultsStream(
        string $messageBatchID,
        $betas = omit,
        ?RequestOptions $requestOptions = null,
    ): BaseStream;

    /**
     * @api
     *
     * @param array<string, mixed> $params
     *
     * @return BaseStream<MessageBatchIndividualResponse>
     *
     * @throws APIException
     */
    public function resultsStreamRaw(
        string $messageBatchID,
        array $params,
        ?RequestOptions $requestOptions = null,
    ): BaseStream;
}
