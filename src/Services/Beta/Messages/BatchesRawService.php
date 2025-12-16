<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Messages;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Messages\Batches\BatchCancelParams;
use Anthropic\Beta\Messages\Batches\BatchCreateParams;
use Anthropic\Beta\Messages\Batches\BatchCreateParams\Request\Params\ServiceTier;
use Anthropic\Beta\Messages\Batches\BatchDeleteParams;
use Anthropic\Beta\Messages\Batches\BatchListParams;
use Anthropic\Beta\Messages\Batches\BatchResultsParams;
use Anthropic\Beta\Messages\Batches\BatchRetrieveParams;
use Anthropic\Beta\Messages\Batches\DeletedMessageBatch;
use Anthropic\Beta\Messages\Batches\MessageBatch;
use Anthropic\Beta\Messages\Batches\MessageBatchIndividualResponse;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\JsonLStream;
use Anthropic\Messages\Model;
use Anthropic\Page;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Messages\BatchesRawContract;

final class BatchesRawService implements BatchesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Send a batch of Message creation requests.
     *
     * The Message Batches API can be used to process multiple Messages API requests at once. Once a Message Batch is created, it begins processing immediately. Batches can take up to 24 hours to complete.
     *
     * Learn more about the Message Batches API in our [user guide](https://docs.claude.com/en/docs/build-with-claude/batch-processing)
     *
     * @param array{
     *   requests: list<array{
     *     customID: string,
     *     params: array{
     *       maxTokens: int,
     *       messages: list<array<string,mixed>>,
     *       model: string|'claude-opus-4-5-20251101'|'claude-opus-4-5'|'claude-3-7-sonnet-latest'|'claude-3-7-sonnet-20250219'|'claude-3-5-haiku-latest'|'claude-3-5-haiku-20241022'|'claude-haiku-4-5'|'claude-haiku-4-5-20251001'|'claude-sonnet-4-20250514'|'claude-sonnet-4-0'|'claude-4-sonnet-20250514'|'claude-sonnet-4-5'|'claude-sonnet-4-5-20250929'|'claude-opus-4-0'|'claude-opus-4-20250514'|'claude-4-opus-20250514'|'claude-opus-4-1-20250805'|'claude-3-opus-latest'|'claude-3-opus-20240229'|'claude-3-haiku-20240307'|Model,
     *       container?: string|array<string,mixed>|null,
     *       contextManagement?: array<string,mixed>|null,
     *       mcpServers?: list<array<string,mixed>>,
     *       metadata?: array<string,mixed>,
     *       outputConfig?: array<string,mixed>,
     *       outputFormat?: array<string,mixed>|null,
     *       serviceTier?: 'auto'|'standard_only'|ServiceTier,
     *       stopSequences?: list<string>,
     *       stream?: bool,
     *       system?: string|list<array<string,mixed>>,
     *       temperature?: float,
     *       thinking?: array<string,mixed>,
     *       toolChoice?: array<string,mixed>,
     *       tools?: list<array<string,mixed>>,
     *       topK?: int,
     *       topP?: float,
     *     },
     *   }>,
     *   betas?: list<string|'message-batches-2024-09-24'|'prompt-caching-2024-07-31'|'computer-use-2024-10-22'|'computer-use-2025-01-24'|'pdfs-2024-09-25'|'token-counting-2024-11-01'|'token-efficient-tools-2025-02-19'|'output-128k-2025-02-19'|'files-api-2025-04-14'|'mcp-client-2025-04-04'|'mcp-client-2025-11-20'|'dev-full-thinking-2025-05-14'|'interleaved-thinking-2025-05-14'|'code-execution-2025-05-22'|'extended-cache-ttl-2025-04-11'|'context-1m-2025-08-07'|'context-management-2025-06-27'|'model-context-window-exceeded-2025-08-26'|'skills-2025-10-02'|AnthropicBeta>,
     * }|BatchCreateParams $params
     *
     * @return BaseResponse<MessageBatch>
     *
     * @throws APIException
     */
    public function create(
        array|BatchCreateParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        [$parsed, $options] = BatchCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/messages/batches?beta=true',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'message-batches-2024-09-24']],
                $options,
            ),
            convert: MessageBatch::class,
        );
    }

    /**
     * @api
     *
     * This endpoint is idempotent and can be used to poll for Message Batch completion. To access the results of a Message Batch, make a request to the `results_url` field in the response.
     *
     * Learn more about the Message Batches API in our [user guide](https://docs.claude.com/en/docs/build-with-claude/batch-processing)
     *
     * @param string $messageBatchID ID of the Message Batch
     * @param array{
     *   betas?: list<string|'message-batches-2024-09-24'|'prompt-caching-2024-07-31'|'computer-use-2024-10-22'|'computer-use-2025-01-24'|'pdfs-2024-09-25'|'token-counting-2024-11-01'|'token-efficient-tools-2025-02-19'|'output-128k-2025-02-19'|'files-api-2025-04-14'|'mcp-client-2025-04-04'|'mcp-client-2025-11-20'|'dev-full-thinking-2025-05-14'|'interleaved-thinking-2025-05-14'|'code-execution-2025-05-22'|'extended-cache-ttl-2025-04-11'|'context-1m-2025-08-07'|'context-management-2025-06-27'|'model-context-window-exceeded-2025-08-26'|'skills-2025-10-02'|AnthropicBeta>,
     * }|BatchRetrieveParams $params
     *
     * @return BaseResponse<MessageBatch>
     *
     * @throws APIException
     */
    public function retrieve(
        string $messageBatchID,
        array|BatchRetrieveParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = BatchRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/messages/batches/%1$s?beta=true', $messageBatchID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'message-batches-2024-09-24']],
                $options,
            ),
            convert: MessageBatch::class,
        );
    }

    /**
     * @api
     *
     * List all Message Batches within a Workspace. Most recently created batches are returned first.
     *
     * Learn more about the Message Batches API in our [user guide](https://docs.claude.com/en/docs/build-with-claude/batch-processing)
     *
     * @param array{
     *   afterID?: string,
     *   beforeID?: string,
     *   limit?: int,
     *   betas?: list<string|'message-batches-2024-09-24'|'prompt-caching-2024-07-31'|'computer-use-2024-10-22'|'computer-use-2025-01-24'|'pdfs-2024-09-25'|'token-counting-2024-11-01'|'token-efficient-tools-2025-02-19'|'output-128k-2025-02-19'|'files-api-2025-04-14'|'mcp-client-2025-04-04'|'mcp-client-2025-11-20'|'dev-full-thinking-2025-05-14'|'interleaved-thinking-2025-05-14'|'code-execution-2025-05-22'|'extended-cache-ttl-2025-04-11'|'context-1m-2025-08-07'|'context-management-2025-06-27'|'model-context-window-exceeded-2025-08-26'|'skills-2025-10-02'|AnthropicBeta>,
     * }|BatchListParams $params
     *
     * @return BaseResponse<Page<MessageBatch>>
     *
     * @throws APIException
     */
    public function list(
        array|BatchListParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        [$parsed, $options] = BatchListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(['afterID', 'beforeID', 'limit']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/messages/batches?beta=true',
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                ['afterID' => 'after_id', 'beforeID' => 'before_id'],
            ),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'message-batches-2024-09-24']],
                $options,
            ),
            convert: MessageBatch::class,
            page: Page::class,
        );
    }

    /**
     * @api
     *
     * Delete a Message Batch.
     *
     * Message Batches can only be deleted once they've finished processing. If you'd like to delete an in-progress batch, you must first cancel it.
     *
     * Learn more about the Message Batches API in our [user guide](https://docs.claude.com/en/docs/build-with-claude/batch-processing)
     *
     * @param string $messageBatchID ID of the Message Batch
     * @param array{
     *   betas?: list<string|'message-batches-2024-09-24'|'prompt-caching-2024-07-31'|'computer-use-2024-10-22'|'computer-use-2025-01-24'|'pdfs-2024-09-25'|'token-counting-2024-11-01'|'token-efficient-tools-2025-02-19'|'output-128k-2025-02-19'|'files-api-2025-04-14'|'mcp-client-2025-04-04'|'mcp-client-2025-11-20'|'dev-full-thinking-2025-05-14'|'interleaved-thinking-2025-05-14'|'code-execution-2025-05-22'|'extended-cache-ttl-2025-04-11'|'context-1m-2025-08-07'|'context-management-2025-06-27'|'model-context-window-exceeded-2025-08-26'|'skills-2025-10-02'|AnthropicBeta>,
     * }|BatchDeleteParams $params
     *
     * @return BaseResponse<DeletedMessageBatch>
     *
     * @throws APIException
     */
    public function delete(
        string $messageBatchID,
        array|BatchDeleteParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = BatchDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/messages/batches/%1$s?beta=true', $messageBatchID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'message-batches-2024-09-24']],
                $options,
            ),
            convert: DeletedMessageBatch::class,
        );
    }

    /**
     * @api
     *
     * Batches may be canceled any time before processing ends. Once cancellation is initiated, the batch enters a `canceling` state, at which time the system may complete any in-progress, non-interruptible requests before finalizing cancellation.
     *
     * The number of canceled requests is specified in `request_counts`. To determine which requests were canceled, check the individual results within the batch. Note that cancellation may not result in any canceled requests if they were non-interruptible.
     *
     * Learn more about the Message Batches API in our [user guide](https://docs.claude.com/en/docs/build-with-claude/batch-processing)
     *
     * @param string $messageBatchID ID of the Message Batch
     * @param array{
     *   betas?: list<string|'message-batches-2024-09-24'|'prompt-caching-2024-07-31'|'computer-use-2024-10-22'|'computer-use-2025-01-24'|'pdfs-2024-09-25'|'token-counting-2024-11-01'|'token-efficient-tools-2025-02-19'|'output-128k-2025-02-19'|'files-api-2025-04-14'|'mcp-client-2025-04-04'|'mcp-client-2025-11-20'|'dev-full-thinking-2025-05-14'|'interleaved-thinking-2025-05-14'|'code-execution-2025-05-22'|'extended-cache-ttl-2025-04-11'|'context-1m-2025-08-07'|'context-management-2025-06-27'|'model-context-window-exceeded-2025-08-26'|'skills-2025-10-02'|AnthropicBeta>,
     * }|BatchCancelParams $params
     *
     * @return BaseResponse<MessageBatch>
     *
     * @throws APIException
     */
    public function cancel(
        string $messageBatchID,
        array|BatchCancelParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = BatchCancelParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/messages/batches/%1$s/cancel?beta=true', $messageBatchID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'message-batches-2024-09-24']],
                $options,
            ),
            convert: MessageBatch::class,
        );
    }

    /**
     * @api
     *
     * Streams the results of a Message Batch as a `.jsonl` file.
     *
     * Each line in the file is a JSON object containing the result of a single request in the Message Batch. Results are not guaranteed to be in the same order as requests. Use the `custom_id` field to match results to requests.
     *
     * Learn more about the Message Batches API in our [user guide](https://docs.claude.com/en/docs/build-with-claude/batch-processing)
     *
     * @param string $messageBatchID ID of the Message Batch
     * @param array{
     *   betas?: list<string|'message-batches-2024-09-24'|'prompt-caching-2024-07-31'|'computer-use-2024-10-22'|'computer-use-2025-01-24'|'pdfs-2024-09-25'|'token-counting-2024-11-01'|'token-efficient-tools-2025-02-19'|'output-128k-2025-02-19'|'files-api-2025-04-14'|'mcp-client-2025-04-04'|'mcp-client-2025-11-20'|'dev-full-thinking-2025-05-14'|'interleaved-thinking-2025-05-14'|'code-execution-2025-05-22'|'extended-cache-ttl-2025-04-11'|'context-1m-2025-08-07'|'context-management-2025-06-27'|'model-context-window-exceeded-2025-08-26'|'skills-2025-10-02'|AnthropicBeta>,
     * }|BatchResultsParams $params
     *
     * @return BaseResponse<MessageBatchIndividualResponse>
     *
     * @throws APIException
     */
    public function results(
        string $messageBatchID,
        array|BatchResultsParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = BatchResultsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/messages/batches/%1$s/results?beta=true', $messageBatchID],
            headers: Util::array_transform_keys(
                ['Accept' => 'application/x-jsonl', ...$parsed],
                ['betas' => 'anthropic-beta'],
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'message-batches-2024-09-24']],
                $options,
            ),
            convert: MessageBatchIndividualResponse::class,
        );
    }

    /**
     * @api
     *
     * @param string $messageBatchID ID of the Message Batch
     * @param array{
     *   betas?: list<string|'message-batches-2024-09-24'|'prompt-caching-2024-07-31'|'computer-use-2024-10-22'|'computer-use-2025-01-24'|'pdfs-2024-09-25'|'token-counting-2024-11-01'|'token-efficient-tools-2025-02-19'|'output-128k-2025-02-19'|'files-api-2025-04-14'|'mcp-client-2025-04-04'|'mcp-client-2025-11-20'|'dev-full-thinking-2025-05-14'|'interleaved-thinking-2025-05-14'|'code-execution-2025-05-22'|'extended-cache-ttl-2025-04-11'|'context-1m-2025-08-07'|'context-management-2025-06-27'|'model-context-window-exceeded-2025-08-26'|'skills-2025-10-02'|AnthropicBeta>,
     * }|BatchResultsParams $params
     *
     * @return BaseResponse<BaseStream<MessageBatchIndividualResponse>>
     *
     * @throws APIException
     */
    public function resultsStream(
        string $messageBatchID,
        array|BatchResultsParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = BatchResultsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/messages/batches/%1$s/results?beta=true', $messageBatchID],
            headers: Util::array_transform_keys(
                ['Accept' => 'application/x-jsonl', ...$parsed],
                ['betas' => 'anthropic-beta'],
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'message-batches-2024-09-24']],
                $options,
            ),
            convert: MessageBatchIndividualResponse::class,
            stream: JsonLStream::class,
        );
    }
}
