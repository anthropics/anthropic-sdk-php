<?php

declare(strict_types=1);

namespace Anthropic\Contracts\Beta\Messages;

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
use Anthropic\Core\Contracts\CloseableStream;
use Anthropic\RequestOptions;

interface BatchesContract
{
    /**
     * @param array{
     *   requests: list<Request>, anthropicBeta?: list<AnthropicBeta::*|string>
     * }|BatchCreateParams $params
     */
    public function create(
        array|BatchCreateParams $params,
        ?RequestOptions $requestOptions = null
    ): MessageBatch;

    /**
     * @param array{
     *   anthropicBeta?: list<AnthropicBeta::*|string>
     * }|BatchRetrieveParams $params
     */
    public function retrieve(
        string $messageBatchID,
        array|BatchRetrieveParams $params,
        ?RequestOptions $requestOptions = null,
    ): MessageBatch;

    /**
     * @param array{
     *   afterID?: string,
     *   beforeID?: string,
     *   limit?: int,
     *   anthropicBeta?: list<AnthropicBeta::*|string>,
     * }|BatchListParams $params
     */
    public function list(
        array|BatchListParams $params,
        ?RequestOptions $requestOptions = null
    ): MessageBatch;

    /**
     * @param array{
     *   anthropicBeta?: list<AnthropicBeta::*|string>
     * }|BatchDeleteParams $params
     */
    public function delete(
        string $messageBatchID,
        array|BatchDeleteParams $params,
        ?RequestOptions $requestOptions = null,
    ): DeletedMessageBatch;

    /**
     * @param array{
     *   anthropicBeta?: list<AnthropicBeta::*|string>
     * }|BatchCancelParams $params
     */
    public function cancel(
        string $messageBatchID,
        array|BatchCancelParams $params,
        ?RequestOptions $requestOptions = null,
    ): MessageBatch;

    /**
     * @param array{
     *   anthropicBeta?: list<AnthropicBeta::*|string>
     * }|BatchResultsParams $params
     */
    public function results(
        string $messageBatchID,
        array|BatchResultsParams $params,
        ?RequestOptions $requestOptions = null,
    ): MessageBatchIndividualResponse;

    /**
     * @param array{
     *   anthropicBeta?: list<AnthropicBeta::*|string>
     * }|BatchResultsParams $params
     *
     * @return CloseableStream<MessageBatchIndividualResponse>
     */
    public function resultsStream(
        string $messageBatchID,
        array|BatchResultsParams $params,
        ?RequestOptions $requestOptions = null,
    ): CloseableStream;
}
