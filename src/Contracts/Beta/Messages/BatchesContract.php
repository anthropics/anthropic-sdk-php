<?php

declare(strict_types=1);

namespace Anthropic\Contracts\Beta\Messages;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Messages\Batches\BatchCreateParams\Request;
use Anthropic\Beta\Messages\Batches\DeletedMessageBatch;
use Anthropic\Beta\Messages\Batches\MessageBatch;
use Anthropic\Beta\Messages\Batches\MessageBatchIndividualResponse;
use Anthropic\Core\Contracts\BaseStream;
use Anthropic\RequestOptions;

use const Anthropic\Core\OMIT as omit;

interface BatchesContract
{
    /**
     * @param list<Request> $requests List of requests for prompt completion. Each is an individual request to create a Message.
     * @param list<AnthropicBeta::*|string> $betas optional header to specify the beta version(s) you want to use
     */
    public function create(
        $requests,
        $betas = omit,
        ?RequestOptions $requestOptions = null
    ): MessageBatch;

    /**
     * @param list<AnthropicBeta::*|string> $betas optional header to specify the beta version(s) you want to use
     */
    public function retrieve(
        string $messageBatchID,
        $betas = omit,
        ?RequestOptions $requestOptions = null,
    ): MessageBatch;

    /**
     * @param string $afterID ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately after this object.
     * @param string $beforeID ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately before this object.
     * @param int $limit Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     * @param list<AnthropicBeta::*|string> $betas optional header to specify the beta version(s) you want to use
     */
    public function list(
        $afterID = omit,
        $beforeID = omit,
        $limit = omit,
        $betas = omit,
        ?RequestOptions $requestOptions = null,
    ): MessageBatch;

    /**
     * @param list<AnthropicBeta::*|string> $betas optional header to specify the beta version(s) you want to use
     */
    public function delete(
        string $messageBatchID,
        $betas = omit,
        ?RequestOptions $requestOptions = null,
    ): DeletedMessageBatch;

    /**
     * @param list<AnthropicBeta::*|string> $betas optional header to specify the beta version(s) you want to use
     */
    public function cancel(
        string $messageBatchID,
        $betas = omit,
        ?RequestOptions $requestOptions = null,
    ): MessageBatch;

    /**
     * @param list<AnthropicBeta::*|string> $betas optional header to specify the beta version(s) you want to use
     */
    public function results(
        string $messageBatchID,
        $betas = omit,
        ?RequestOptions $requestOptions = null,
    ): MessageBatchIndividualResponse;

    /**
     * @param list<AnthropicBeta::*|string> $betas optional header to specify the beta version(s) you want to use
     *
     * @return BaseStream<MessageBatchIndividualResponse>
     */
    public function resultsStream(
        string $messageBatchID,
        $betas = omit,
        ?RequestOptions $requestOptions = null,
    ): BaseStream;
}
