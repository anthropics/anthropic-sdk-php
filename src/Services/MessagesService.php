<?php

declare(strict_types=1);

namespace Anthropic\Services;

use Anthropic\Client;
use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Messages\Message;
use Anthropic\Messages\MessageCountTokensParams;
use Anthropic\Messages\MessageCreateParams;
use Anthropic\Messages\MessageTokensCount;
use Anthropic\Messages\Model;
use Anthropic\Messages\RawContentBlockDeltaEvent;
use Anthropic\Messages\RawContentBlockStartEvent;
use Anthropic\Messages\RawContentBlockStopEvent;
use Anthropic\Messages\RawMessageDeltaEvent;
use Anthropic\Messages\RawMessageStartEvent;
use Anthropic\Messages\RawMessageStopEvent;
use Anthropic\Messages\RawMessageStreamEvent;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\MessagesContract;
use Anthropic\Services\Messages\BatchesService;
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
     *   metadata?: array{user_id?: string|null},
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
     * }|MessageCreateParams $params
     *
     * @throws APIException
     */
    public function create(
        array|MessageCreateParams $params,
        ?RequestOptions $requestOptions = null
    ): Message {
        [$parsed, $options] = MessageCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/messages',
            body: (object) $parsed,
            options: $options,
            convert: Message::class,
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
     *   metadata?: array{user_id?: string|null},
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
     * }|MessageCreateParams $params
     *
     * @return BaseStream<RawMessageStartEvent|RawMessageDeltaEvent|RawMessageStopEvent|RawContentBlockStartEvent|RawContentBlockDeltaEvent|RawContentBlockStopEvent,>
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

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/messages',
            headers: ['Accept' => 'text/event-stream'],
            body: (object) $parsed,
            options: $options,
            convert: RawMessageStreamEvent::class,
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
     *   system?: string|list<array{
     *     text: string,
     *     type: 'text',
     *     cache_control?: array<mixed>|null,
     *     citations?: list<array<string,mixed>>|null,
     *   }>,
     *   thinking?: array<string,mixed>,
     *   tool_choice?: array<string,mixed>,
     *   tools?: list<array<string,mixed>>,
     * }|MessageCountTokensParams $params
     *
     * @throws APIException
     */
    public function countTokens(
        array|MessageCountTokensParams $params,
        ?RequestOptions $requestOptions = null,
    ): MessageTokensCount {
        [$parsed, $options] = MessageCountTokensParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/messages/count_tokens',
            body: (object) $parsed,
            options: $options,
            convert: MessageTokensCount::class,
        );
    }
}
