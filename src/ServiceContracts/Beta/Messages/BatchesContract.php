<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Messages;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Messages\Batches\BatchCreateParams\Request\Params\ServiceTier;
use Anthropic\Beta\Messages\Batches\DeletedMessageBatch;
use Anthropic\Beta\Messages\Batches\MessageBatch;
use Anthropic\Beta\Messages\Batches\MessageBatchIndividualResponse;
use Anthropic\Beta\Messages\BetaCacheControlEphemeral\TTL;
use Anthropic\Beta\Messages\BetaMessageParam\Role;
use Anthropic\Beta\Messages\BetaOutputConfig\Effort;
use Anthropic\Beta\Messages\BetaSkillParams\Type;
use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Exceptions\APIException;
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
     *     container?: string|array{
     *       id?: string|null,
     *       skills?: list<array{
     *         skillID: string, type: 'anthropic'|'custom'|Type, version?: string
     *       }>|null,
     *     }|null,
     *     contextManagement?: array{edits?: list<array<string,mixed>>}|null,
     *     mcpServers?: list<array{
     *       name: string,
     *       type?: 'url',
     *       url: string,
     *       authorizationToken?: string|null,
     *       toolConfiguration?: array{
     *         allowedTools?: list<string>|null, enabled?: bool|null
     *       }|null,
     *     }>,
     *     metadata?: array{userID?: string|null},
     *     outputConfig?: array{effort?: 'low'|'medium'|'high'|Effort|null},
     *     outputFormat?: array{
     *       schema: array<string,mixed>, type?: 'json_schema'
     *     }|null,
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
     * }> $requests Body param: List of requests for prompt completion. Each is an individual request to create a Message.
     * @param list<string|'message-batches-2024-09-24'|'prompt-caching-2024-07-31'|'computer-use-2024-10-22'|'computer-use-2025-01-24'|'pdfs-2024-09-25'|'token-counting-2024-11-01'|'token-efficient-tools-2025-02-19'|'output-128k-2025-02-19'|'files-api-2025-04-14'|'mcp-client-2025-04-04'|'mcp-client-2025-11-20'|'dev-full-thinking-2025-05-14'|'interleaved-thinking-2025-05-14'|'code-execution-2025-05-22'|'extended-cache-ttl-2025-04-11'|'context-1m-2025-08-07'|'context-management-2025-06-27'|'model-context-window-exceeded-2025-08-26'|'skills-2025-10-02'|AnthropicBeta> $betas header param: Optional header to specify the beta version(s) you want to use
     *
     * @throws APIException
     */
    public function create(
        array $requests,
        ?array $betas = null,
        ?RequestOptions $requestOptions = null,
    ): MessageBatch;

    /**
     * @api
     *
     * @param string $messageBatchID ID of the Message Batch
     * @param list<string|'message-batches-2024-09-24'|'prompt-caching-2024-07-31'|'computer-use-2024-10-22'|'computer-use-2025-01-24'|'pdfs-2024-09-25'|'token-counting-2024-11-01'|'token-efficient-tools-2025-02-19'|'output-128k-2025-02-19'|'files-api-2025-04-14'|'mcp-client-2025-04-04'|'mcp-client-2025-11-20'|'dev-full-thinking-2025-05-14'|'interleaved-thinking-2025-05-14'|'code-execution-2025-05-22'|'extended-cache-ttl-2025-04-11'|'context-1m-2025-08-07'|'context-management-2025-06-27'|'model-context-window-exceeded-2025-08-26'|'skills-2025-10-02'|AnthropicBeta> $betas optional header to specify the beta version(s) you want to use
     *
     * @throws APIException
     */
    public function retrieve(
        string $messageBatchID,
        ?array $betas = null,
        ?RequestOptions $requestOptions = null,
    ): MessageBatch;

    /**
     * @api
     *
     * @param string $afterID Query param: ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately after this object.
     * @param string $beforeID Query param: ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately before this object.
     * @param int $limit Query param: Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     * @param list<string|'message-batches-2024-09-24'|'prompt-caching-2024-07-31'|'computer-use-2024-10-22'|'computer-use-2025-01-24'|'pdfs-2024-09-25'|'token-counting-2024-11-01'|'token-efficient-tools-2025-02-19'|'output-128k-2025-02-19'|'files-api-2025-04-14'|'mcp-client-2025-04-04'|'mcp-client-2025-11-20'|'dev-full-thinking-2025-05-14'|'interleaved-thinking-2025-05-14'|'code-execution-2025-05-22'|'extended-cache-ttl-2025-04-11'|'context-1m-2025-08-07'|'context-management-2025-06-27'|'model-context-window-exceeded-2025-08-26'|'skills-2025-10-02'|AnthropicBeta> $betas header param: Optional header to specify the beta version(s) you want to use
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
        ?RequestOptions $requestOptions = null,
    ): Page;

    /**
     * @api
     *
     * @param string $messageBatchID ID of the Message Batch
     * @param list<string|'message-batches-2024-09-24'|'prompt-caching-2024-07-31'|'computer-use-2024-10-22'|'computer-use-2025-01-24'|'pdfs-2024-09-25'|'token-counting-2024-11-01'|'token-efficient-tools-2025-02-19'|'output-128k-2025-02-19'|'files-api-2025-04-14'|'mcp-client-2025-04-04'|'mcp-client-2025-11-20'|'dev-full-thinking-2025-05-14'|'interleaved-thinking-2025-05-14'|'code-execution-2025-05-22'|'extended-cache-ttl-2025-04-11'|'context-1m-2025-08-07'|'context-management-2025-06-27'|'model-context-window-exceeded-2025-08-26'|'skills-2025-10-02'|AnthropicBeta> $betas optional header to specify the beta version(s) you want to use
     *
     * @throws APIException
     */
    public function delete(
        string $messageBatchID,
        ?array $betas = null,
        ?RequestOptions $requestOptions = null,
    ): DeletedMessageBatch;

    /**
     * @api
     *
     * @param string $messageBatchID ID of the Message Batch
     * @param list<string|'message-batches-2024-09-24'|'prompt-caching-2024-07-31'|'computer-use-2024-10-22'|'computer-use-2025-01-24'|'pdfs-2024-09-25'|'token-counting-2024-11-01'|'token-efficient-tools-2025-02-19'|'output-128k-2025-02-19'|'files-api-2025-04-14'|'mcp-client-2025-04-04'|'mcp-client-2025-11-20'|'dev-full-thinking-2025-05-14'|'interleaved-thinking-2025-05-14'|'code-execution-2025-05-22'|'extended-cache-ttl-2025-04-11'|'context-1m-2025-08-07'|'context-management-2025-06-27'|'model-context-window-exceeded-2025-08-26'|'skills-2025-10-02'|AnthropicBeta> $betas optional header to specify the beta version(s) you want to use
     *
     * @throws APIException
     */
    public function cancel(
        string $messageBatchID,
        ?array $betas = null,
        ?RequestOptions $requestOptions = null,
    ): MessageBatch;

    /**
     * @api
     *
     * @param string $messageBatchID ID of the Message Batch
     * @param list<string|'message-batches-2024-09-24'|'prompt-caching-2024-07-31'|'computer-use-2024-10-22'|'computer-use-2025-01-24'|'pdfs-2024-09-25'|'token-counting-2024-11-01'|'token-efficient-tools-2025-02-19'|'output-128k-2025-02-19'|'files-api-2025-04-14'|'mcp-client-2025-04-04'|'mcp-client-2025-11-20'|'dev-full-thinking-2025-05-14'|'interleaved-thinking-2025-05-14'|'code-execution-2025-05-22'|'extended-cache-ttl-2025-04-11'|'context-1m-2025-08-07'|'context-management-2025-06-27'|'model-context-window-exceeded-2025-08-26'|'skills-2025-10-02'|AnthropicBeta> $betas optional header to specify the beta version(s) you want to use
     *
     * @throws APIException
     */
    public function results(
        string $messageBatchID,
        ?array $betas = null,
        ?RequestOptions $requestOptions = null,
    ): MessageBatchIndividualResponse;

    /**
     * @api
     *
     * @param string $messageBatchID ID of the Message Batch
     * @param list<string|'message-batches-2024-09-24'|'prompt-caching-2024-07-31'|'computer-use-2024-10-22'|'computer-use-2025-01-24'|'pdfs-2024-09-25'|'token-counting-2024-11-01'|'token-efficient-tools-2025-02-19'|'output-128k-2025-02-19'|'files-api-2025-04-14'|'mcp-client-2025-04-04'|'mcp-client-2025-11-20'|'dev-full-thinking-2025-05-14'|'interleaved-thinking-2025-05-14'|'code-execution-2025-05-22'|'extended-cache-ttl-2025-04-11'|'context-1m-2025-08-07'|'context-management-2025-06-27'|'model-context-window-exceeded-2025-08-26'|'skills-2025-10-02'|AnthropicBeta> $betas optional header to specify the beta version(s) you want to use
     *
     * @return BaseStream<MessageBatchIndividualResponse>
     *
     * @throws APIException
     */
    public function resultsStream(
        string $messageBatchID,
        ?array $betas = null,
        ?RequestOptions $requestOptions = null,
    ): BaseStream;
}
