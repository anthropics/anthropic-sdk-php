<?php

declare(strict_types=1);

namespace Anthropic\Resources;

use Anthropic\Client;
use Anthropic\Contracts\MessagesContract;
use Anthropic\Core\Conversion;
use Anthropic\Models\Message;
use Anthropic\Models\MessageCountTokensTool\TextEditor20250429 as TextEditor202504291;
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
use Anthropic\Models\ToolTextEditor20250728;
use Anthropic\Models\ToolUnion\TextEditor20250429;
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
     * @param MessageCreateParam|array{
     *   maxTokens: int,
     *   messages: list<MessageParam>,
     *   model: UnionMember0::*|string,
     *   metadata?: Metadata,
     *   serviceTier?: ServiceTier::*,
     *   stopSequences?: list<string>,
     *   system?: string|list<TextBlockParam>,
     *   temperature?: float,
     *   thinking?: ThinkingConfigEnabled|ThinkingConfigDisabled,
     *   toolChoice?: ToolChoiceAuto|ToolChoiceAny|ToolChoiceTool|ToolChoiceNone,
     *   tools?: list<Tool|ToolBash20250124|ToolTextEditor20250124|TextEditor20250429|ToolTextEditor20250728|WebSearchTool20250305>,
     *   topK?: int,
     *   topP?: float,
     * } $params
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
     * @param MessageCountTokensParam|array{
     *   messages: list<MessageParam>,
     *   model: UnionMember0::*|string,
     *   system?: string|list<TextBlockParam>,
     *   thinking?: ThinkingConfigEnabled|ThinkingConfigDisabled,
     *   toolChoice?: ToolChoiceAuto|ToolChoiceAny|ToolChoiceTool|ToolChoiceNone,
     *   tools?: list<Tool|ToolBash20250124|ToolTextEditor20250124|TextEditor202504291|ToolTextEditor20250728|WebSearchTool20250305>,
     * } $params
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
