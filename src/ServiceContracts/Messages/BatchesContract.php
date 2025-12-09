<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Messages;

use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Messages\Batches\BatchCreateParams\Request\Params\ServiceTier;
use Anthropic\Messages\Batches\DeletedMessageBatch;
use Anthropic\Messages\Batches\MessageBatch;
use Anthropic\Messages\Batches\MessageBatchIndividualResponse;
use Anthropic\Messages\CacheControlEphemeral\TTL;
use Anthropic\Messages\MessageParam\Role;
use Anthropic\Messages\Model;
use Anthropic\Page;
use Anthropic\RequestOptions;

interface BatchesContract
{
    /**
     * @api
     *
     * @param list<array{
     *   customID: string,
     *   params: array{
     *     maxTokens: int,
     *     messages: list<array{
     *       content: string|list<array<string,mixed>>, role: 'user'|'assistant'|Role
     *     }>,
     *     model: string|'claude-opus-4-5-20251101'|'claude-opus-4-5'|'claude-3-7-sonnet-latest'|'claude-3-7-sonnet-20250219'|'claude-3-5-haiku-latest'|'claude-3-5-haiku-20241022'|'claude-haiku-4-5'|'claude-haiku-4-5-20251001'|'claude-sonnet-4-20250514'|'claude-sonnet-4-0'|'claude-4-sonnet-20250514'|'claude-sonnet-4-5'|'claude-sonnet-4-5-20250929'|'claude-opus-4-0'|'claude-opus-4-20250514'|'claude-4-opus-20250514'|'claude-opus-4-1-20250805'|'claude-3-opus-latest'|'claude-3-opus-20240229'|'claude-3-haiku-20240307'|Model,
     *     metadata?: array{userID?: string|null},
     *     serviceTier?: 'auto'|'standard_only'|ServiceTier,
     *     stopSequences?: list<string>,
     *     stream?: bool,
     *     system?: string|list<array{
     *       text: string,
     *       type?: 'text',
     *       cacheControl?: array{type?: 'ephemeral', ttl?: '5m'|'1h'|TTL}|null,
     *       citations?: list<array<string,mixed>>|null,
     *     }>,
     *     temperature?: float,
     *     thinking?: array<string,mixed>,
     *     toolChoice?: array<string,mixed>,
     *     tools?: list<array<string,mixed>>,
     *     topK?: int,
     *     topP?: float,
     *   },
     * }> $requests List of requests for prompt completion. Each is an individual request to create a Message.
     *
     * @throws APIException
     */
    public function create(
        array $requests,
        ?RequestOptions $requestOptions = null
    ): MessageBatch;

    /**
     * @api
     *
     * @param string $messageBatchID ID of the Message Batch
     *
     * @throws APIException
     */
    public function retrieve(
        string $messageBatchID,
        ?RequestOptions $requestOptions = null
    ): MessageBatch;

    /**
     * @api
     *
     * @param string $afterID ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately after this object.
     * @param string $beforeID ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately before this object.
     * @param int $limit Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     *
     * @return Page<MessageBatch>
     *
     * @throws APIException
     */
    public function list(
        ?string $afterID = null,
        ?string $beforeID = null,
        int $limit = 20,
        ?RequestOptions $requestOptions = null,
    ): Page;

    /**
     * @api
     *
     * @param string $messageBatchID ID of the Message Batch
     *
     * @throws APIException
     */
    public function delete(
        string $messageBatchID,
        ?RequestOptions $requestOptions = null
    ): DeletedMessageBatch;

    /**
     * @api
     *
     * @param string $messageBatchID ID of the Message Batch
     *
     * @throws APIException
     */
    public function cancel(
        string $messageBatchID,
        ?RequestOptions $requestOptions = null
    ): MessageBatch;

    /**
     * @api
     *
     * @param string $messageBatchID ID of the Message Batch
     *
     * @throws APIException
     */
    public function results(
        string $messageBatchID,
        ?RequestOptions $requestOptions = null
    ): MessageBatchIndividualResponse;

    /**
     * @api
     *
     * @param string $messageBatchID ID of the Message Batch
     *
     * @return BaseStream<MessageBatchIndividualResponse>
     *
     * @throws APIException
     */
    public function resultsStream(
        string $messageBatchID,
        ?RequestOptions $requestOptions = null
    ): BaseStream;
}
