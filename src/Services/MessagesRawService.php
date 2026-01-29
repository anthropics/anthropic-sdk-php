<?php

declare(strict_types=1);

namespace Anthropic\Services;

use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Messages\Message;
use Anthropic\Messages\MessageCountTokensParams;
use Anthropic\Messages\MessageCreateParams;
use Anthropic\Messages\MessageCreateParams\ServiceTier;
use Anthropic\Messages\MessageParam;
use Anthropic\Messages\MessageTokensCount;
use Anthropic\Messages\Metadata;
use Anthropic\Messages\Model;
use Anthropic\Messages\OutputConfig;
use Anthropic\Messages\RawContentBlockDeltaEvent;
use Anthropic\Messages\RawContentBlockStartEvent;
use Anthropic\Messages\RawContentBlockStopEvent;
use Anthropic\Messages\RawMessageDeltaEvent;
use Anthropic\Messages\RawMessageStartEvent;
use Anthropic\Messages\RawMessageStopEvent;
use Anthropic\Messages\RawMessageStreamEvent;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\MessagesRawContract;
use Anthropic\SSEStream;

/**
 * @phpstan-import-type SystemShape from \Anthropic\Messages\MessageCountTokensParams\System
 * @phpstan-import-type MessageCountTokensToolShape from \Anthropic\Messages\MessageCountTokensTool
 * @phpstan-import-type MessageParamShape from \Anthropic\Messages\MessageParam
 * @phpstan-import-type MetadataShape from \Anthropic\Messages\Metadata
 * @phpstan-import-type OutputConfigShape from \Anthropic\Messages\OutputConfig
 * @phpstan-import-type SystemShape from \Anthropic\Messages\MessageCreateParams\System as SystemShape1
 * @phpstan-import-type ThinkingConfigParamShape from \Anthropic\Messages\ThinkingConfigParam
 * @phpstan-import-type ToolChoiceShape from \Anthropic\Messages\ToolChoice
 * @phpstan-import-type ToolUnionShape from \Anthropic\Messages\ToolUnion
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class MessagesRawService implements MessagesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

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
     *   messages: list<MessageParam|MessageParamShape>,
     *   model: string|Model|value-of<Model>,
     *   metadata?: Metadata|MetadataShape,
     *   outputConfig?: OutputConfig|OutputConfigShape,
     *   serviceTier?: ServiceTier|value-of<ServiceTier>,
     *   stopSequences?: list<string>,
     *   system?: SystemShape1,
     *   temperature?: float,
     *   thinking?: ThinkingConfigParamShape,
     *   toolChoice?: ToolChoiceShape,
     *   tools?: list<ToolUnionShape>,
     *   topK?: int,
     *   topP?: float,
     * }|MessageCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Message>
     *
     * @throws APIException
     */
    public function create(
        array|MessageCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
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
     *   maxTokens: int,
     *   messages: list<MessageParam|MessageParamShape>,
     *   model: string|Model|value-of<Model>,
     *   metadata?: Metadata|MetadataShape,
     *   outputConfig?: OutputConfig|OutputConfigShape,
     *   serviceTier?: ServiceTier|value-of<ServiceTier>,
     *   stopSequences?: list<string>,
     *   system?: SystemShape1,
     *   temperature?: float,
     *   thinking?: ThinkingConfigParamShape,
     *   toolChoice?: ToolChoiceShape,
     *   tools?: list<ToolUnionShape>,
     *   topK?: int,
     *   topP?: float,
     * }|MessageCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BaseStream<RawMessageStartEvent|RawMessageDeltaEvent|RawMessageStopEvent|RawContentBlockStartEvent|RawContentBlockDeltaEvent|RawContentBlockStopEvent,>,>
     *
     * @throws APIException
     */
    public function createStream(
        array|MessageCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
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
     *   messages: list<MessageParam|MessageParamShape>,
     *   model: string|Model|value-of<Model>,
     *   outputConfig?: OutputConfig|OutputConfigShape,
     *   system?: SystemShape,
     *   thinking?: ThinkingConfigParamShape,
     *   toolChoice?: ToolChoiceShape,
     *   tools?: list<MessageCountTokensToolShape>,
     * }|MessageCountTokensParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<MessageTokensCount>
     *
     * @throws APIException
     */
    public function countTokens(
        array|MessageCountTokensParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
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
