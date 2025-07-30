<?php

declare(strict_types=1);

namespace Anthropic\Resources;

use Anthropic\Client;
use Anthropic\Contracts\MessagesContract;
use Anthropic\Core\Conversion;
use Anthropic\Models\Message;
use Anthropic\Models\MessageParam;
use Anthropic\Models\MessageTokensCount;
use Anthropic\Models\Metadata;
use Anthropic\Models\Model\UnionMember0;
use Anthropic\Models\TextBlockParam;
use Anthropic\Models\ThinkingConfigDisabled;
use Anthropic\Models\ThinkingConfigEnabled;
use Anthropic\Models\Tool;
use Anthropic\Models\ToolBash20250124;
use Anthropic\Models\ToolChoiceAny;
use Anthropic\Models\ToolChoiceAuto;
use Anthropic\Models\ToolChoiceNone;
use Anthropic\Models\ToolChoiceTool;
use Anthropic\Models\ToolTextEditor20250124;
use Anthropic\Models\ToolTextEditor20250429;
use Anthropic\Models\ToolTextEditor20250728;
use Anthropic\Models\WebSearchTool20250305;
use Anthropic\Parameters\MessageCountTokensParam;
use Anthropic\Parameters\MessageCreateParam;
use Anthropic\Parameters\MessageCreateParam\ServiceTier;
use Anthropic\RequestOptions;
use Anthropic\Resources\Messages\Batches;

final class Messages implements MessagesContract
{
    public Batches $batches;

    public function __construct(private Client $client)
    {
        $this->batches = new Batches($this->client);
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
     *   model: string|UnionMember0::*,
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
     * }|MessageCreateParam $params
     */
    public function create(
        array|MessageCreateParam $params,
        ?RequestOptions $requestOptions = null
    ): Message {
        [$parsed, $options] = MessageCreateParam::parseRequest(
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
     * Count the number of tokens in a Message.
     *
     * The Token Count API can be used to count the number of tokens in a Message, including tools, images, and documents, without creating it.
     *
     * Learn more about token counting in our [user guide](/en/docs/build-with-claude/token-counting)
     *
     * @param array{
     *   messages: list<MessageParam>,
     *   model: string|UnionMember0::*,
     *   system?: list<TextBlockParam>|string,
     *   thinking?: ThinkingConfigDisabled|ThinkingConfigEnabled,
     *   toolChoice?: ToolChoiceAny|ToolChoiceAuto|ToolChoiceNone|ToolChoiceTool,
     *   tools?: list<Tool|ToolBash20250124|ToolTextEditor20250124|ToolTextEditor20250429|ToolTextEditor20250728|WebSearchTool20250305>,
     * }|MessageCountTokensParam $params
     */
    public function countTokens(
        array|MessageCountTokensParam $params,
        ?RequestOptions $requestOptions = null,
    ): MessageTokensCount {
        [$parsed, $options] = MessageCountTokensParam::parseRequest(
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
