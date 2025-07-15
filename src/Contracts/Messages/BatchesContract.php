<?php

declare(strict_types=1);

namespace Anthropic\Contracts\Messages;

use Anthropic\Models\Messages\DeletedMessageBatch;
use Anthropic\Models\Messages\MessageBatch;
use Anthropic\Models\Messages\MessageBatchIndividualResponse;
use Anthropic\Parameters\Messages\Batches\CreateParams\Request;
use Anthropic\RequestOptions;

interface BatchesContract
{
    /**
     * @param array{requests?: list<Request>} $params
     */
    public function create(
        array $params,
        ?RequestOptions $requestOptions = null
    ): MessageBatch;

    /**
     * @param array{messageBatchID?: string} $params
     */
    public function retrieve(
        string $messageBatchID,
        array $params,
        ?RequestOptions $requestOptions = null,
    ): MessageBatch;

    /**
     * @param array{afterID?: string, beforeID?: string, limit?: int} $params
     */
    public function list(
        array $params,
        ?RequestOptions $requestOptions = null
    ): MessageBatch;

    /**
     * @param array{messageBatchID?: string} $params
     */
    public function delete(
        string $messageBatchID,
        array $params,
        ?RequestOptions $requestOptions = null,
    ): DeletedMessageBatch;

    /**
     * @param array{messageBatchID?: string} $params
     */
    public function cancel(
        string $messageBatchID,
        array $params,
        ?RequestOptions $requestOptions = null,
    ): MessageBatch;

    /**
     * @param array{messageBatchID?: string} $params
     */
    public function results(
        string $messageBatchID,
        array $params,
        ?RequestOptions $requestOptions = null,
    ): MessageBatchIndividualResponse;
}
