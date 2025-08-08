<?php

declare(strict_types=1);

namespace Anthropic\Contracts\Beta\Messages;

use Anthropic\Models\AnthropicBeta\UnionMember1;
use Anthropic\Models\Beta\Messages\BatchCancelParams;
use Anthropic\Models\Beta\Messages\BatchCreateParams;
use Anthropic\Models\Beta\Messages\BatchCreateParams\Request;
use Anthropic\Models\Beta\Messages\BatchDeleteParams;
use Anthropic\Models\Beta\Messages\BatchListParams;
use Anthropic\Models\Beta\Messages\BatchResultsParams;
use Anthropic\Models\Beta\Messages\BatchRetrieveParams;
use Anthropic\Models\Beta\Messages\DeletedMessageBatch;
use Anthropic\Models\Beta\Messages\MessageBatch;
use Anthropic\Models\Beta\Messages\MessageBatchIndividualResponse;
use Anthropic\RequestOptions;

interface BatchesContract
{
    /**
     * @param array{
     *   requests: list<Request>, anthropicBeta?: list<string|UnionMember1::*>
     * }|BatchCreateParams $params
     */
    public function create(
        array|BatchCreateParams $params,
        ?RequestOptions $requestOptions = null
    ): MessageBatch;

    /**
     * @param array{
     *   anthropicBeta?: list<string|UnionMember1::*>
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
     *   anthropicBeta?: list<string|UnionMember1::*>,
     * }|BatchListParams $params
     */
    public function list(
        array|BatchListParams $params,
        ?RequestOptions $requestOptions = null
    ): MessageBatch;

    /**
     * @param array{
     *   anthropicBeta?: list<string|UnionMember1::*>
     * }|BatchDeleteParams $params
     */
    public function delete(
        string $messageBatchID,
        array|BatchDeleteParams $params,
        ?RequestOptions $requestOptions = null,
    ): DeletedMessageBatch;

    /**
     * @param array{
     *   anthropicBeta?: list<string|UnionMember1::*>
     * }|BatchCancelParams $params
     */
    public function cancel(
        string $messageBatchID,
        array|BatchCancelParams $params,
        ?RequestOptions $requestOptions = null,
    ): MessageBatch;

    /**
     * @param array{
     *   anthropicBeta?: list<string|UnionMember1::*>
     * }|BatchResultsParams $params
     */
    public function results(
        string $messageBatchID,
        array|BatchResultsParams $params,
        ?RequestOptions $requestOptions = null,
    ): MessageBatchIndividualResponse;
}
