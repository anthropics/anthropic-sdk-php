<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Messages\BetaMessage;
use Anthropic\Beta\Messages\BetaMessageParam\Role;
use Anthropic\Beta\Messages\BetaMessageTokensCount;
use Anthropic\Beta\Messages\BetaOutputConfig\Effort;
use Anthropic\Beta\Messages\BetaRawContentBlockDeltaEvent;
use Anthropic\Beta\Messages\BetaRawContentBlockStartEvent;
use Anthropic\Beta\Messages\BetaRawContentBlockStopEvent;
use Anthropic\Beta\Messages\BetaRawMessageDeltaEvent;
use Anthropic\Beta\Messages\BetaRawMessageStartEvent;
use Anthropic\Beta\Messages\BetaRawMessageStopEvent;
use Anthropic\Beta\Messages\BetaRawMessageStreamEvent;
use Anthropic\Beta\Messages\MessageCountTokensParams;
use Anthropic\Beta\Messages\MessageCreateParams;
use Anthropic\Beta\Messages\MessageCreateParams\ServiceTier;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\Messages\Model;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\MessagesContract;
use Anthropic\Services\Beta\Messages\BatchesService;
use Anthropic\SSEStream;

final class MessagesService implements MessagesContract
{
    /**
     * @api
     */
    public BatchesService $batches;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->batches = new BatchesService($client);
    }

    /**
     * @api
     *
     * Send a structured list of input messages with text and/or image content, and the model will generate the next message in the conversation.
     *
     * The Messages API can be used for either single queries or stateless multi-turn conversations.
     *
     * Learn more about the Messages API in our [user guide](https://docs.claude.com/en/docs/initial-setup)
     *
     * @param array{
     *   maxTokens: int,
     *   messages: list<array{
     *     content: string|list<array<string,mixed>>, role: 'user'|'assistant'|Role
     *   }>,
     *   model: string|'claude-opus-4-5-20251101'|'claude-opus-4-5'|'claude-3-7-sonnet-latest'|'claude-3-7-sonnet-20250219'|'claude-3-5-haiku-latest'|'claude-3-5-haiku-20241022'|'claude-haiku-4-5'|'claude-haiku-4-5-20251001'|'claude-sonnet-4-20250514'|'claude-sonnet-4-0'|'claude-4-sonnet-20250514'|'claude-sonnet-4-5'|'claude-sonnet-4-5-20250929'|'claude-opus-4-0'|'claude-opus-4-20250514'|'claude-4-opus-20250514'|'claude-opus-4-1-20250805'|'claude-3-opus-latest'|'claude-3-opus-20240229'|'claude-3-haiku-20240307'|Model,
     *   container?: string|array{
     *     id?: string|null, skills?: list<array<mixed>>|null
     *   }|null,
     *   contextManagement?: array{edits?: list<array<string,mixed>>}|null,
     *   mcpServers?: list<array{
     *     name: string,
     *     type?: 'url',
     *     url: string,
     *     authorizationToken?: string|null,
     *     toolConfiguration?: array{
     *       allowedTools?: list<string>|null, enabled?: bool|null
     *     }|null,
     *   }>,
     *   metadata?: array{userID?: string|null},
     *   outputConfig?: array{effort?: 'low'|'medium'|'high'|Effort|null},
     *   outputFormat?: array{schema: array<string,mixed>, type?: 'json_schema'}|null,
     *   serviceTier?: 'auto'|'standard_only'|ServiceTier,
     *   stopSequences?: list<string>,
     *   system?: string|list<array{
     *     text: string,
     *     type?: 'text',
     *     cacheControl?: array<mixed>|null,
     *     citations?: list<array<string,mixed>>|null,
     *   }>,
     *   temperature?: float,
     *   thinking?: array<string,mixed>,
     *   toolChoice?: array<string,mixed>,
     *   tools?: list<array<string,mixed>>,
     *   topK?: int,
     *   topP?: float,
     *   betas?: list<string|'message-batches-2024-09-24'|'prompt-caching-2024-07-31'|'computer-use-2024-10-22'|'computer-use-2025-01-24'|'pdfs-2024-09-25'|'token-counting-2024-11-01'|'token-efficient-tools-2025-02-19'|'output-128k-2025-02-19'|'files-api-2025-04-14'|'mcp-client-2025-04-04'|'mcp-client-2025-11-20'|'dev-full-thinking-2025-05-14'|'interleaved-thinking-2025-05-14'|'code-execution-2025-05-22'|'extended-cache-ttl-2025-04-11'|'context-1m-2025-08-07'|'context-management-2025-06-27'|'model-context-window-exceeded-2025-08-26'|'skills-2025-10-02'|AnthropicBeta>,
     * }|MessageCreateParams $params
     *
     * @throws APIException
     */
    public function create(
        array|MessageCreateParams $params,
        ?RequestOptions $requestOptions = null
    ): BetaMessage {
        [$parsed, $options] = MessageCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        /** @var BaseResponse<BetaMessage> */
        $response = $this->client->request(
            method: 'post',
            path: 'v1/messages?beta=true',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_keys($header_params)),
                $header_params
            ),
            body: (object) array_diff_key($parsed, array_keys($header_params)),
            options: $options,
            convert: BetaMessage::class,
        );

        return $response->parse();
    }

    /**
     * @api
     *
     * @param array{
     *   maxTokens: int,
     *   messages: list<array{
     *     content: string|list<array<string,mixed>>, role: 'user'|'assistant'|Role
     *   }>,
     *   model: string|'claude-opus-4-5-20251101'|'claude-opus-4-5'|'claude-3-7-sonnet-latest'|'claude-3-7-sonnet-20250219'|'claude-3-5-haiku-latest'|'claude-3-5-haiku-20241022'|'claude-haiku-4-5'|'claude-haiku-4-5-20251001'|'claude-sonnet-4-20250514'|'claude-sonnet-4-0'|'claude-4-sonnet-20250514'|'claude-sonnet-4-5'|'claude-sonnet-4-5-20250929'|'claude-opus-4-0'|'claude-opus-4-20250514'|'claude-4-opus-20250514'|'claude-opus-4-1-20250805'|'claude-3-opus-latest'|'claude-3-opus-20240229'|'claude-3-haiku-20240307'|Model,
     *   container?: string|array{
     *     id?: string|null, skills?: list<array<mixed>>|null
     *   }|null,
     *   contextManagement?: array{edits?: list<array<string,mixed>>}|null,
     *   mcpServers?: list<array{
     *     name: string,
     *     type?: 'url',
     *     url: string,
     *     authorizationToken?: string|null,
     *     toolConfiguration?: array{
     *       allowedTools?: list<string>|null, enabled?: bool|null
     *     }|null,
     *   }>,
     *   metadata?: array{userID?: string|null},
     *   outputConfig?: array{effort?: 'low'|'medium'|'high'|Effort|null},
     *   outputFormat?: array{schema: array<string,mixed>, type?: 'json_schema'}|null,
     *   serviceTier?: 'auto'|'standard_only'|ServiceTier,
     *   stopSequences?: list<string>,
     *   system?: string|list<array{
     *     text: string,
     *     type?: 'text',
     *     cacheControl?: array<mixed>|null,
     *     citations?: list<array<string,mixed>>|null,
     *   }>,
     *   temperature?: float,
     *   thinking?: array<string,mixed>,
     *   toolChoice?: array<string,mixed>,
     *   tools?: list<array<string,mixed>>,
     *   topK?: int,
     *   topP?: float,
     *   betas?: list<string|'message-batches-2024-09-24'|'prompt-caching-2024-07-31'|'computer-use-2024-10-22'|'computer-use-2025-01-24'|'pdfs-2024-09-25'|'token-counting-2024-11-01'|'token-efficient-tools-2025-02-19'|'output-128k-2025-02-19'|'files-api-2025-04-14'|'mcp-client-2025-04-04'|'mcp-client-2025-11-20'|'dev-full-thinking-2025-05-14'|'interleaved-thinking-2025-05-14'|'code-execution-2025-05-22'|'extended-cache-ttl-2025-04-11'|'context-1m-2025-08-07'|'context-management-2025-06-27'|'model-context-window-exceeded-2025-08-26'|'skills-2025-10-02'|AnthropicBeta>,
     * }|MessageCreateParams $params
     *
     * @return BaseStream<BetaRawMessageStartEvent|BetaRawMessageDeltaEvent|BetaRawMessageStopEvent|BetaRawContentBlockStartEvent|BetaRawContentBlockDeltaEvent|BetaRawContentBlockStopEvent,>
     *
     * @throws APIException
     */
    public function createStream(
        array|MessageCreateParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseStream {
        [$parsed, $options] = MessageCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $parsed['stream'] = true;
        $header_params = ['betas' => 'anthropic-beta'];

        /** @var BaseResponse<BaseStream<BetaRawMessageStartEvent|BetaRawMessageDeltaEvent|BetaRawMessageStopEvent|BetaRawContentBlockStartEvent|BetaRawContentBlockDeltaEvent|BetaRawContentBlockStopEvent,>,> */
        $response = $this->client->request(
            method: 'post',
            path: 'v1/messages?beta=true',
            headers: Util::array_transform_keys(
                [
                    'Accept' => 'text/event-stream',
                    ...array_intersect_key($parsed, array_keys($header_params)),
                ],
                $header_params,
            ),
            body: (object) array_diff_key($parsed, array_keys($header_params)),
            options: $options,
            convert: BetaRawMessageStreamEvent::class,
            stream: SSEStream::class,
        );

        return $response->parse();
    }

    /**
     * @api
     *
     * Count the number of tokens in a Message.
     *
     * The Token Count API can be used to count the number of tokens in a Message, including tools, images, and documents, without creating it.
     *
     * Learn more about token counting in our [user guide](https://docs.claude.com/en/docs/build-with-claude/token-counting)
     *
     * @param array{
     *   messages: list<array{
     *     content: string|list<array<string,mixed>>, role: 'user'|'assistant'|Role
     *   }>,
     *   model: string|'claude-opus-4-5-20251101'|'claude-opus-4-5'|'claude-3-7-sonnet-latest'|'claude-3-7-sonnet-20250219'|'claude-3-5-haiku-latest'|'claude-3-5-haiku-20241022'|'claude-haiku-4-5'|'claude-haiku-4-5-20251001'|'claude-sonnet-4-20250514'|'claude-sonnet-4-0'|'claude-4-sonnet-20250514'|'claude-sonnet-4-5'|'claude-sonnet-4-5-20250929'|'claude-opus-4-0'|'claude-opus-4-20250514'|'claude-4-opus-20250514'|'claude-opus-4-1-20250805'|'claude-3-opus-latest'|'claude-3-opus-20240229'|'claude-3-haiku-20240307'|Model,
     *   contextManagement?: array{edits?: list<array<string,mixed>>}|null,
     *   mcpServers?: list<array{
     *     name: string,
     *     type?: 'url',
     *     url: string,
     *     authorizationToken?: string|null,
     *     toolConfiguration?: array{
     *       allowedTools?: list<string>|null, enabled?: bool|null
     *     }|null,
     *   }>,
     *   outputConfig?: array{effort?: 'low'|'medium'|'high'|Effort|null},
     *   outputFormat?: array{schema: array<string,mixed>, type?: 'json_schema'}|null,
     *   system?: string|list<array{
     *     text: string,
     *     type?: 'text',
     *     cacheControl?: array<mixed>|null,
     *     citations?: list<array<string,mixed>>|null,
     *   }>,
     *   thinking?: array<string,mixed>,
     *   toolChoice?: array<string,mixed>,
     *   tools?: list<array<string,mixed>>,
     *   betas?: list<string|'message-batches-2024-09-24'|'prompt-caching-2024-07-31'|'computer-use-2024-10-22'|'computer-use-2025-01-24'|'pdfs-2024-09-25'|'token-counting-2024-11-01'|'token-efficient-tools-2025-02-19'|'output-128k-2025-02-19'|'files-api-2025-04-14'|'mcp-client-2025-04-04'|'mcp-client-2025-11-20'|'dev-full-thinking-2025-05-14'|'interleaved-thinking-2025-05-14'|'code-execution-2025-05-22'|'extended-cache-ttl-2025-04-11'|'context-1m-2025-08-07'|'context-management-2025-06-27'|'model-context-window-exceeded-2025-08-26'|'skills-2025-10-02'|AnthropicBeta>,
     * }|MessageCountTokensParams $params
     *
     * @throws APIException
     */
    public function countTokens(
        array|MessageCountTokensParams $params,
        ?RequestOptions $requestOptions = null,
    ): BetaMessageTokensCount {
        [$parsed, $options] = MessageCountTokensParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        /** @var BaseResponse<BetaMessageTokensCount> */
        $response = $this->client->request(
            method: 'post',
            path: 'v1/messages/count_tokens?beta=true',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_keys($header_params)),
                $header_params
            ),
            body: (object) array_diff_key($parsed, array_keys($header_params)),
            options: $options,
            convert: BetaMessageTokensCount::class,
        );

        return $response->parse();
    }
}
