<?php

declare(strict_types=1);

namespace Anthropic\Contracts\Messages;

use Anthropic\Models\Messages\DeletedMessageBatch;
use Anthropic\Models\Messages\MessageBatch;
use Anthropic\Models\Messages\MessageBatchIndividualResponse;
use Anthropic\Parameters\Messages\Batches\CreateParams;
use Anthropic\Parameters\Messages\Batches\CreateParams\Request;
use Anthropic\Parameters\Messages\Batches\ListParams;
use Anthropic\RequestOptions;

interface BatchesContract
{
    /**
     * @param array{requests?: list<Request>}|CreateParams $params
     */
    public function create(
        array|CreateParams $params,
        ?RequestOptions $requestOptions = null
    ): MessageBatch;

    public function retrieve(
        string $messageBatchID,
        ?RequestOptions $requestOptions = null
    ): MessageBatch;

    /**
     * @param ListParams|array{
     *   afterID?: string, beforeID?: string, limit?: int
     * } $params
     */
    public function list(
        array|ListParams $params,
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
