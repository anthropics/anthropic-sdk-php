<?php

declare(strict_types=1);

namespace Anthropic\Contracts\Beta\Messages;

use Anthropic\Models\Beta\Messages\BetaDeletedMessageBatch;
use Anthropic\Models\Beta\Messages\BetaMessageBatch;
use Anthropic\Models\Beta\Messages\BetaMessageBatchIndividualResponse;
use Anthropic\Parameters\Beta\Messages\Batches\CreateParams\Request;
use Anthropic\RequestOptions;

interface BatchesContract
{
    /**
     * @param array{requests?: list<Request>, betas?: list<string|string>} $params
     */
    public function create(
        array $params,
        ?RequestOptions $requestOptions = null
    ): BetaMessageBatch;

    /**
     * @param array{messageBatchID?: string, betas?: list<string|string>} $params
     */
    public function retrieve(
        string $messageBatchID,
        array $params,
        ?RequestOptions $requestOptions = null,
    ): BetaMessageBatch;

    /**
     * @param array{
     *   afterID?: string, beforeID?: string, limit?: int, betas?: list<string|string>
     * } $params
     */
    public function list(
        array $params,
        ?RequestOptions $requestOptions = null
    ): BetaMessageBatch;

    /**
     * @param array{messageBatchID?: string, betas?: list<string|string>} $params
     */
    public function delete(
        string $messageBatchID,
        array $params,
        ?RequestOptions $requestOptions = null,
    ): BetaDeletedMessageBatch;

    /**
     * @param array{messageBatchID?: string, betas?: list<string|string>} $params
     */
    public function cancel(
        string $messageBatchID,
        array $params,
        ?RequestOptions $requestOptions = null,
    ): BetaMessageBatch;

    /**
     * @param array{messageBatchID?: string, betas?: list<string|string>} $params
     */
    public function results(
        string $messageBatchID,
        array $params,
        ?RequestOptions $requestOptions = null,
    ): BetaMessageBatchIndividualResponse;
}
