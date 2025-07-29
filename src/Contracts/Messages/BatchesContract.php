<?php

declare(strict_types=1);

namespace Anthropic\Contracts\Messages;

use Anthropic\Models\Messages\DeletedMessageBatch;
use Anthropic\Models\Messages\MessageBatch;
use Anthropic\Models\Messages\MessageBatchIndividualResponse;
use Anthropic\Parameters\Messages\BatchCreateParam;
use Anthropic\Parameters\Messages\BatchCreateParam\Request;
use Anthropic\Parameters\Messages\BatchListParam;
use Anthropic\RequestOptions;

interface BatchesContract
{
    /**
     * @param array{requests: list<Request>}|BatchCreateParam $params
     */
    public function create(
        array|BatchCreateParam $params,
        ?RequestOptions $requestOptions = null
    ): MessageBatch;

    public function retrieve(
        string $messageBatchID,
        ?RequestOptions $requestOptions = null
    ): MessageBatch;

    /**
     * @param array{
     *   afterID?: string, beforeID?: string, limit?: int
     * }|BatchListParam $params
     */
    public function list(
        array|BatchListParam $params,
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
