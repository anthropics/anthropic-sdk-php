<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Client;
use Anthropic\Contracts\MessagesContract;
use Anthropic\Core\Contracts\CloseableStream;
use Anthropic\Core\Conversion;
use Anthropic\Core\Streaming\SSEStream;
use Anthropic\Messages\Batches\BatchesService;
use Anthropic\Messages\MessageCreateParams\ServiceTier;
use Anthropic\RequestOptions;

final class MessagesService implements MessagesContract
{
    public BatchesService $batches;

    public function __construct(private Client $client)
    {
        $this->batches = new BatchesService($this->client);
    }

    /**
     * Send a structured list of input messages with text and/or image content, and the model will generate the next message in the conversation.
     *
     * The Messages API can be used for either single queries or stateless multi-turn conversations.
     *
     * Learn more about the Messages API in our [user guide](/en/docs/initial-setup)
     *
     * @param array{
     *   maxTokens: int,
     *   messages: list<MessageParam>,
     *   model: Model::*|string,
     *   metadata?: Metadata,
     *   serviceTier?: ServiceTier::*,
     *   stopSequences?: list<string>,
     *   system?: list<TextBlockParam>|string,
     *   temperature?: float,
     *   thinking?: ThinkingConfigDisabled|ThinkingConfigEnabled,
     *   toolChoice?: ToolChoiceAny|ToolChoiceAuto|ToolChoiceNone|ToolChoiceTool,
     *   tools?: list<Tool|ToolBash20250124|ToolTextEditor20250124|ToolTextEditor20250429|ToolTextEditor20250728|WebSearchTool20250305>,
     *   topK?: int,
     *   topP?: float,
     * }|MessageCreateParams $params
     */
    public function create(
        array|MessageCreateParams $params,
        ?RequestOptions $requestOptions = null
    ): Message {
        [$parsed, $options] = MessageCreateParams::parseRequest(
            $params,
            $requestOptions
        );
        $resp = $this->client->request(
            method: 'post',
            path: 'v1/messages',
            body: (object) $parsed,
            options: array_merge(['timeout' => 600], $options),
        );

        // @phpstan-ignore-next-line;
        return Conversion::coerce(Message::class, value: $resp);
    }

    /**
     * @param array{
     *   maxTokens: int,
     *   messages: list<MessageParam>,
     *   model: Model::*|string,
     *   metadata?: Metadata,
     *   serviceTier?: ServiceTier::*,
     *   stopSequences?: list<string>,
     *   system?: list<TextBlockParam>|string,
     *   temperature?: float,
     *   thinking?: ThinkingConfigDisabled|ThinkingConfigEnabled,
     *   toolChoice?: ToolChoiceAny|ToolChoiceAuto|ToolChoiceNone|ToolChoiceTool,
     *   tools?: list<Tool|ToolBash20250124|ToolTextEditor20250124|ToolTextEditor20250429|ToolTextEditor20250728|WebSearchTool20250305>,
     *   topK?: int,
     *   topP?: float,
     * }|MessageCreateParams $params
     *
     * @return CloseableStream<
     *   RawContentBlockDeltaEvent|RawContentBlockStartEvent|RawContentBlockStopEvent|RawMessageDeltaEvent|RawMessageStartEvent|RawMessageStopEvent,
     * >
     */
    public function createStream(
        array|MessageCreateParams $params,
        ?RequestOptions $requestOptions = null
    ): CloseableStream {
        [$parsed, $options] = MessageCreateParams::parseRequest(
            $params,
            $requestOptions
        );
        $parsed['stream'] = true;
        $resp = $this->client->request(
            method: 'post',
            path: 'v1/messages',
            body: (object) $parsed,
            options: array_merge(['timeout' => 600], $options),
        );

        // @phpstan-ignore-next-line;
        return new SSEStream(RawMessageStreamEvent::class, $resp);
    }

    /**
     * Count the number of tokens in a Message.
     *
     * The Token Count API can be used to count the number of tokens in a Message, including tools, images, and documents, without creating it.
     *
     * Learn more about token counting in our [user guide](/en/docs/build-with-claude/token-counting)
     *
     * @param array{
     *   messages: list<MessageParam>,
     *   model: Model::*|string,
     *   system?: list<TextBlockParam>|string,
     *   thinking?: ThinkingConfigDisabled|ThinkingConfigEnabled,
     *   toolChoice?: ToolChoiceAny|ToolChoiceAuto|ToolChoiceNone|ToolChoiceTool,
     *   tools?: list<Tool|ToolBash20250124|ToolTextEditor20250124|ToolTextEditor20250429|ToolTextEditor20250728|WebSearchTool20250305>,
     * }|MessageCountTokensParams $params
     */
    public function countTokens(
        array|MessageCountTokensParams $params,
        ?RequestOptions $requestOptions = null,
    ): MessageTokensCount {
        [$parsed, $options] = MessageCountTokensParams::parseRequest(
            $params,
            $requestOptions
        );
        $resp = $this->client->request(
            method: 'post',
            path: 'v1/messages/count_tokens',
            body: (object) $parsed,
            options: $options,
        );

        // @phpstan-ignore-next-line;
        return Conversion::coerce(MessageTokensCount::class, value: $resp);
    }
}
