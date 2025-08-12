<?php

declare(strict_types=1);

namespace Anthropic\Contracts\Messages;

use Anthropic\Messages\Batches\BatchCreateParams;
use Anthropic\Messages\Batches\BatchCreateParams\Request;
use Anthropic\Messages\Batches\BatchListParams;
use Anthropic\Messages\Batches\DeletedMessageBatch;
use Anthropic\Messages\Batches\MessageBatch;
use Anthropic\Messages\Batches\MessageBatchIndividualResponse;
use Anthropic\RequestOptions;

interface BatchesContract
{
    /**
     * @param array{requests: list<Request>}|BatchCreateParams $params
     */
    public function create(
        array|BatchCreateParams $params,
        ?RequestOptions $requestOptions = null
    ): MessageBatch;

    public function retrieve(
        string $messageBatchID,
        ?RequestOptions $requestOptions = null
    ): MessageBatch;

    /**
     * @param array{
     *   afterID?: string, beforeID?: string, limit?: int
     * }|BatchListParams $params
     */
    public function list(
        array|BatchListParams $params,
        ?RequestOptions $requestOptions = null
    ): MessageBatch;

    public function delete(
        string $messageBatchID,
        ?RequestOptions $requestOptions = null
    ): DeletedMessageBatch;

    public function cancel(
        string $messageBatchID,
        ?RequestOptions $requestOptions = null
    ): MessageBatch;

    public function results(
        string $messageBatchID,
        ?RequestOptions $requestOptions = null
    ): MessageBatchIndividualResponse;
}
