<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta;

use Anthropic\Beta\Messages\BetaMessage;
use Anthropic\Beta\Messages\BetaMessageTokensCount;
use Anthropic\Beta\Messages\BetaRawContentBlockDeltaEvent;
use Anthropic\Beta\Messages\BetaRawContentBlockStartEvent;
use Anthropic\Beta\Messages\BetaRawContentBlockStopEvent;
use Anthropic\Beta\Messages\BetaRawMessageDeltaEvent;
use Anthropic\Beta\Messages\BetaRawMessageStartEvent;
use Anthropic\Beta\Messages\BetaRawMessageStopEvent;
use Anthropic\Beta\Messages\BetaRawMessageStreamEvent;
use Anthropic\Beta\Messages\MessageCountTokensParams;
use Anthropic\Beta\Messages\MessageCreateParams;
use Anthropic\Client;
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
     *   max_tokens: int,
     *   messages: list<array{
     *     content: string|list<array<string,mixed>>, role: 'user'|'assistant'
     *   }>,
     *   model: string|Model,
     *   container?: string|array{
     *     id?: string|null, skills?: list<array<mixed>>|null
     *   }|null,
     *   context_management?: array{edits?: list<array<string,mixed>>}|null,
     *   mcp_servers?: list<array{
     *     name: string,
     *     type: 'url',
     *     url: string,
     *     authorization_token?: string|null,
     *     tool_configuration?: array{
     *       allowed_tools?: list<string>|null, enabled?: bool|null
     *     }|null,
     *   }>,
     *   metadata?: array{user_id?: string|null},
     *   output_config?: array{effort?: 'low'|'medium'|'high'|null},
     *   output_format?: array{schema: array<string,mixed>, type: 'json_schema'}|null,
     *   service_tier?: 'auto'|'standard_only',
     *   stop_sequences?: list<string>,
     *   system?: string|list<array{
     *     text: string,
     *     type: 'text',
     *     cache_control?: array<mixed>|null,
     *     citations?: list<array<string,mixed>>|null,
     *   }>,
     *   temperature?: float,
     *   thinking?: array<string,mixed>,
     *   tool_choice?: array<string,mixed>,
     *   tools?: list<array<string,mixed>>,
     *   top_k?: int,
     *   top_p?: float,
     *   betas?: list<string>,
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

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
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
    }

    /**
     * @api
     *
     * @param array{
     *   max_tokens: int,
     *   messages: list<array{
     *     content: string|list<array<string,mixed>>, role: 'user'|'assistant'
     *   }>,
     *   model: string|Model,
     *   container?: string|array{
     *     id?: string|null, skills?: list<array<mixed>>|null
     *   }|null,
     *   context_management?: array{edits?: list<array<string,mixed>>}|null,
     *   mcp_servers?: list<array{
     *     name: string,
     *     type: 'url',
     *     url: string,
     *     authorization_token?: string|null,
     *     tool_configuration?: array{
     *       allowed_tools?: list<string>|null, enabled?: bool|null
     *     }|null,
     *   }>,
     *   metadata?: array{user_id?: string|null},
     *   output_config?: array{effort?: 'low'|'medium'|'high'|null},
     *   output_format?: array{schema: array<string,mixed>, type: 'json_schema'}|null,
     *   service_tier?: 'auto'|'standard_only',
     *   stop_sequences?: list<string>,
     *   system?: string|list<array{
     *     text: string,
     *     type: 'text',
     *     cache_control?: array<mixed>|null,
     *     citations?: list<array<string,mixed>>|null,
     *   }>,
     *   temperature?: float,
     *   thinking?: array<string,mixed>,
     *   tool_choice?: array<string,mixed>,
     *   tools?: list<array<string,mixed>>,
     *   top_k?: int,
     *   top_p?: float,
     *   betas?: list<string>,
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

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
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
     *     content: string|list<array<string,mixed>>, role: 'user'|'assistant'
     *   }>,
     *   model: string|Model,
     *   context_management?: array{edits?: list<array<string,mixed>>}|null,
     *   mcp_servers?: list<array{
     *     name: string,
     *     type: 'url',
     *     url: string,
     *     authorization_token?: string|null,
     *     tool_configuration?: array{
     *       allowed_tools?: list<string>|null, enabled?: bool|null
     *     }|null,
     *   }>,
     *   output_config?: array{effort?: 'low'|'medium'|'high'|null},
     *   output_format?: array{schema: array<string,mixed>, type: 'json_schema'}|null,
     *   system?: string|list<array{
     *     text: string,
     *     type: 'text',
     *     cache_control?: array<mixed>|null,
     *     citations?: list<array<string,mixed>>|null,
     *   }>,
     *   thinking?: array<string,mixed>,
     *   tool_choice?: array<string,mixed>,
     *   tools?: list<array<string,mixed>>,
     *   betas?: list<string>,
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

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
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
    }
}
