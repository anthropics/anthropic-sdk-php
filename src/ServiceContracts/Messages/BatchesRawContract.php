<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Messages;

use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Messages\Batches\BatchCreateParams;
use Anthropic\Messages\Batches\BatchListParams;
use Anthropic\Messages\Batches\DeletedMessageBatch;
use Anthropic\Messages\Batches\MessageBatch;
use Anthropic\Messages\Batches\MessageBatchIndividualResponse;
use Anthropic\Page;
use Anthropic\RequestOptions;

interface BatchesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|BatchCreateParams $params
     *
     * @return BaseResponse<MessageBatch>
     *
     * @throws APIException
     */
    public function create(
        array|BatchCreateParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $messageBatchID ID of the Message Batch
     *
     * @return BaseResponse<MessageBatch>
     *
     * @throws APIException
     */
    public function retrieve(
        string $messageBatchID,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|BatchListParams $params
     *
     * @return BaseResponse<Page<MessageBatch>>
     *
     * @throws APIException
     */
    public function list(
        array|BatchListParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $messageBatchID ID of the Message Batch
     *
     * @return BaseResponse<DeletedMessageBatch>
     *
     * @throws APIException
     */
    public function delete(
        string $messageBatchID,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $messageBatchID ID of the Message Batch
     *
     * @return BaseResponse<MessageBatch>
     *
     * @throws APIException
     */
    public function cancel(
        string $messageBatchID,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $messageBatchID ID of the Message Batch
     *
     * @return BaseResponse<MessageBatchIndividualResponse>
     *
     * @throws APIException
     */
    public function results(
        string $messageBatchID,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $messageBatchID ID of the Message Batch
     *
     * @return BaseResponse<BaseStream<MessageBatchIndividualResponse>>
     *
     * @throws APIException
     */
    public function resultsStream(
        string $messageBatchID,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;
}
