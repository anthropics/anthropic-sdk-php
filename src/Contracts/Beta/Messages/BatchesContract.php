<?php

declare(strict_types=1);

namespace Anthropic\Contracts\Beta\Messages;

use Anthropic\Models\AnthropicBeta\UnionMember1;
use Anthropic\Models\Beta\Messages\BetaDeletedMessageBatch;
use Anthropic\Models\Beta\Messages\BetaMessageBatch;
use Anthropic\Models\Beta\Messages\BetaMessageBatchIndividualResponse;
use Anthropic\Parameters\Beta\Messages\Batches\CancelParams;
use Anthropic\Parameters\Beta\Messages\Batches\CreateParams;
use Anthropic\Parameters\Beta\Messages\Batches\CreateParams\Request;
use Anthropic\Parameters\Beta\Messages\Batches\DeleteParams;
use Anthropic\Parameters\Beta\Messages\Batches\ListParams;
use Anthropic\Parameters\Beta\Messages\Batches\ResultsParams;
use Anthropic\Parameters\Beta\Messages\Batches\RetrieveParams;
use Anthropic\RequestOptions;

interface BatchesContract
{
    /**
     * @param CreateParams|array{
     *   requests?: list<Request>, anthropicBeta?: list<string|UnionMember1::*>
     * } $params
     */
    public function create(
        array|CreateParams $params,
        ?RequestOptions $requestOptions = null
    ): BetaMessageBatch;

    /**
     * @param RetrieveParams|array{
     *   anthropicBeta?: list<string|UnionMember1::*>
     * } $params
     */
    public function retrieve(
        string $messageBatchID,
        array|RetrieveParams $params,
        ?RequestOptions $requestOptions = null,
    ): BetaMessageBatch;

    /**
     * @param ListParams|array{
     *   afterID?: string,
     *   beforeID?: string,
     *   limit?: int,
     *   anthropicBeta?: list<string|UnionMember1::*>,
     * } $params
     */
    public function list(
        array|ListParams $params,
        ?RequestOptions $requestOptions = null
    ): BetaMessageBatch;

    /**
     * @param array{anthropicBeta?: list<string|UnionMember1::*>}|DeleteParams $params
     */
    public function delete(
        string $messageBatchID,
        array|DeleteParams $params,
        ?RequestOptions $requestOptions = null,
    ): BetaDeletedMessageBatch;

    /**
     * @param array{anthropicBeta?: list<string|UnionMember1::*>}|CancelParams $params
     */
    public function cancel(
        string $messageBatchID,
        array|CancelParams $params,
        ?RequestOptions $requestOptions = null,
    ): BetaMessageBatch;

    /**
     * @param array{anthropicBeta?: list<string|UnionMember1::*>}|ResultsParams $params
     */
    public function results(
        string $messageBatchID,
        array|ResultsParams $params,
        ?RequestOptions $requestOptions = null,
    ): BetaMessageBatchIndividualResponse;
}
