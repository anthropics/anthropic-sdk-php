<?php

declare(strict_types=1);

namespace Anthropic\Contracts\Beta\Messages;

use Anthropic\Models\AnthropicBeta\UnionMember1;
use Anthropic\Models\Beta\Messages\DeletedMessageBatch;
use Anthropic\Models\Beta\Messages\MessageBatch;
use Anthropic\Models\Beta\Messages\MessageBatchIndividualResponse;
use Anthropic\Parameters\Beta\Messages\BatchCancelParam;
use Anthropic\Parameters\Beta\Messages\BatchCreateParam;
use Anthropic\Parameters\Beta\Messages\BatchCreateParam\Request;
use Anthropic\Parameters\Beta\Messages\BatchDeleteParam;
use Anthropic\Parameters\Beta\Messages\BatchListParam;
use Anthropic\Parameters\Beta\Messages\BatchResultsParam;
use Anthropic\Parameters\Beta\Messages\BatchRetrieveParam;
use Anthropic\RequestOptions;

interface BatchesContract
{
    /**
     * @param array{
     *   requests: list<Request>, anthropicBeta?: list<string|UnionMember1::*>
     * }|BatchCreateParam $params
     */
    public function create(
        array|BatchCreateParam $params,
        ?RequestOptions $requestOptions = null
    ): MessageBatch;

    /**
     * @param array{
     *   anthropicBeta?: list<string|UnionMember1::*>
     * }|BatchRetrieveParam $params
     */
    public function retrieve(
        string $messageBatchID,
        array|BatchRetrieveParam $params,
        ?RequestOptions $requestOptions = null,
    ): MessageBatch;

    /**
     * @param array{
     *   afterID?: string,
     *   beforeID?: string,
     *   limit?: int,
     *   anthropicBeta?: list<string|UnionMember1::*>,
     * }|BatchListParam $params
     */
    public function list(
        array|BatchListParam $params,
        ?RequestOptions $requestOptions = null
    ): MessageBatch;

    /**
     * @param array{
     *   anthropicBeta?: list<string|UnionMember1::*>
     * }|BatchDeleteParam $params
     */
    public function delete(
        string $messageBatchID,
        array|BatchDeleteParam $params,
        ?RequestOptions $requestOptions = null,
    ): DeletedMessageBatch;

    /**
     * @param array{
     *   anthropicBeta?: list<string|UnionMember1::*>
     * }|BatchCancelParam $params
     */
    public function cancel(
        string $messageBatchID,
        array|BatchCancelParam $params,
        ?RequestOptions $requestOptions = null,
    ): MessageBatch;

    /**
     * @param array{
     *   anthropicBeta?: list<string|UnionMember1::*>
     * }|BatchResultsParam $params
     */
    public function results(
        string $messageBatchID,
        array|BatchResultsParam $params,
        ?RequestOptions $requestOptions = null,
    ): MessageBatchIndividualResponse;
}
