<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Messages;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Messages\Batches\BatchCreateParams\Request;
use Anthropic\Beta\Messages\Batches\DeletedMessageBatch;
use Anthropic\Beta\Messages\Batches\MessageBatch;
use Anthropic\Beta\Messages\Batches\MessageBatchIndividualResponse;
use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Page;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestShape from \Anthropic\Beta\Messages\Batches\BatchCreateParams\Request
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface BatchesContract
{
    /**
     * @api
     *
     * @param list<Request|RequestShape> $requests Body param: List of requests for prompt completion. Each is an individual request to create a Message.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        array $requests,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): MessageBatch;

    /**
     * @api
     *
     * @param string $messageBatchID ID of the Message Batch
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $messageBatchID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): MessageBatch;

    /**
     * @api
     *
     * @param string $afterID Query param: ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately after this object.
     * @param string $beforeID Query param: ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately before this object.
     * @param int $limit Query param: Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @return Page<MessageBatch>
     *
     * @throws APIException
     */
    public function list(
        ?string $afterID = null,
        ?string $beforeID = null,
        int $limit = 20,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): Page;

    /**
     * @api
     *
     * @param string $messageBatchID ID of the Message Batch
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $messageBatchID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): DeletedMessageBatch;

    /**
     * @api
     *
     * @param string $messageBatchID ID of the Message Batch
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function cancel(
        string $messageBatchID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): MessageBatch;

    /**
     * @api
     *
     * @param string $messageBatchID ID of the Message Batch
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseStream<MessageBatchIndividualResponse>
     *
     * @throws APIException
     */
    public function resultsStream(
        string $messageBatchID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BaseStream;
}
