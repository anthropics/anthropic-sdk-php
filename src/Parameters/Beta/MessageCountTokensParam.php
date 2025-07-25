<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Concerns\Params;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Models\AnthropicBeta;
use Anthropic\Models\AnthropicBeta\UnionMember1;
use Anthropic\Models\Beta\BetaCodeExecutionTool20250522;
use Anthropic\Models\Beta\BetaMessageParam;
use Anthropic\Models\Beta\BetaRequestMCPServerURLDefinition;
use Anthropic\Models\Beta\BetaTextBlockParam;
use Anthropic\Models\Beta\BetaThinkingConfigDisabled;
use Anthropic\Models\Beta\BetaThinkingConfigEnabled;
use Anthropic\Models\Beta\BetaThinkingConfigParam;
use Anthropic\Models\Beta\BetaTool;
use Anthropic\Models\Beta\BetaToolBash20241022;
use Anthropic\Models\Beta\BetaToolBash20250124;
use Anthropic\Models\Beta\BetaToolChoice;
use Anthropic\Models\Beta\BetaToolChoiceAny;
use Anthropic\Models\Beta\BetaToolChoiceAuto;
use Anthropic\Models\Beta\BetaToolChoiceNone;
use Anthropic\Models\Beta\BetaToolChoiceTool;
use Anthropic\Models\Beta\BetaToolComputerUse20241022;
use Anthropic\Models\Beta\BetaToolComputerUse20250124;
use Anthropic\Models\Beta\BetaToolTextEditor20241022;
use Anthropic\Models\Beta\BetaToolTextEditor20250124;
use Anthropic\Models\Beta\BetaToolTextEditor20250429;
use Anthropic\Models\Beta\BetaWebSearchTool20250305;
use Anthropic\Models\Model;
use Anthropic\Models\Model\UnionMember0;
use Anthropic\Parameters\Beta\MessageCountTokensParam\System;
use Anthropic\Parameters\Beta\MessageCountTokensParam\Tool;

/**
 * Count the number of tokens in a Message.
 *
 * The Token Count API can be used to count the number of tokens in a Message, including tools, images, and documents, without creating it.
 *
 * Learn more about token counting in our [user guide](/en/docs/build-with-claude/token-counting)
 *
 * @phpstan-type count_tokens_params = array{
 *   messages: list<BetaMessageParam>,
 *   model: UnionMember0::*|string,
 *   mcpServers?: list<BetaRequestMCPServerURLDefinition>,
 *   system?: string|list<BetaTextBlockParam>,
 *   thinking?: BetaThinkingConfigEnabled|BetaThinkingConfigDisabled,
 *   toolChoice?: BetaToolChoiceAuto|BetaToolChoiceAny|BetaToolChoiceTool|BetaToolChoiceNone,
 *   tools?: list<BetaTool|BetaToolBash20241022|BetaToolBash20250124|BetaCodeExecutionTool20250522|BetaToolComputerUse20241022|BetaToolComputerUse20250124|BetaToolTextEditor20241022|BetaToolTextEditor20250124|BetaToolTextEditor20250429|BetaWebSearchTool20250305>,
 *   anthropicBeta?: list<string|UnionMember1::*>,
 * }
 */
final class MessageCountTokensParam implements BaseModel
{
    use ModelTrait;
    use Params;

    /**
     * Input messages.
     *
     * Our models are trained to operate on alternating `user` and `assistant` conversational turns. When creating a new `Message`, you specify the prior conversational turns with the `messages` parameter, and the model then generates the next `Message` in the conversation. Consecutive `user` or `assistant` turns in your request will be combined into a single turn.
     *
     * Each input message must be an object with a `role` and `content`. You can specify a single `user`-role message, or you can include multiple `user` and `assistant` messages.
     *
     * If the final message uses the `assistant` role, the response content will continue immediately from the content in that message. This can be used to constrain part of the model's response.
     *
     * Example with a single `user` message:
     *
     * ```json
     * [{"role": "user", "content": "Hello, Claude"}]
     * ```
     *
     * Example with multiple conversational turns:
     *
     * ```json
     * [
     *   {"role": "user", "content": "Hello there."},
     *   {"role": "assistant", "content": "Hi, I'm Claude. How can I help you?"},
     *   {"role": "user", "content": "Can you explain LLMs in plain English?"},
     * ]
     * ```
     *
     * Example with a partially-filled response from Claude:
     *
     * ```json
     * [
     *   {"role": "user", "content": "What's the Greek name for Sun? (A) Sol (B) Helios (C) Sun"},
     *   {"role": "assistant", "content": "The best answer is ("},
     * ]
     * ```
     *
     * Each input message `content` may be either a single `string` or an array of content blocks, where each block has a specific `type`. Using a `string` for `content` is shorthand for an array of one content block of type `"text"`. The following input messages are equivalent:
     *
     * ```json
     * {"role": "user", "content": "Hello, Claude"}
     * ```
     *
     * ```json
     * {"role": "user", "content": [{"type": "text", "text": "Hello, Claude"}]}
     * ```
     *
     * Starting with Claude 3 models, you can also send image content blocks:
     *
     * ```json
     * {"role": "user", "content": [
     *   {
     *     "type": "image",
     *     "source": {
     *       "type": "base64",
     *       "media_type": "image/jpeg",
     *       "data": "/9j/4AAQSkZJRg...",
     *     }
     *   },
     *   {"type": "text", "text": "What is in this image?"}
     * ]}
     * ```
     *
     * We currently support the `base64` source type for images, and the `image/jpeg`, `image/png`, `image/gif`, and `image/webp` media types.
     *
     * See [examples](https://docs.anthropic.com/en/api/messages-examples#vision) for more input examples.
     *
     * Note that if you want to include a [system prompt](https://docs.anthropic.com/en/docs/system-prompts), you can use the top-level `system` parameter — there is no `"system"` role for input messages in the Messages API.
     *
     * There is a limit of 100,000 messages in a single request.
     *
     * @var list<BetaMessageParam> $messages
     */
    #[Api(type: new ListOf(BetaMessageParam::class))]
    public array $messages;

    /**
     * The model that will complete your prompt.\n\nSee [models](https://docs.anthropic.com/en/docs/models-overview) for additional details and options.
     *
     * @var string|UnionMember0::* $model
     */
    #[Api(union: Model::class)]
    public string $model;

    /**
     * MCP servers to be utilized in this request.
     *
     * @var null|list<BetaRequestMCPServerURLDefinition> $mcpServers
     */
    #[Api(
        'mcp_servers',
        type: new ListOf(BetaRequestMCPServerURLDefinition::class),
        optional: true,
    )]
    public ?array $mcpServers;

    /**
     * System prompt.
     *
     * A system prompt is a way of providing context and instructions to Claude, such as specifying a particular goal or role. See our [guide to system prompts](https://docs.anthropic.com/en/docs/system-prompts).
     *
     * @var null|list<BetaTextBlockParam>|string $system
     */
    #[Api(union: System::class, optional: true)]
    public null|array|string $system;

    /**
     * Configuration for enabling Claude's extended thinking.
     *
     * When enabled, responses include `thinking` content blocks showing Claude's thinking process before the final answer. Requires a minimum budget of 1,024 tokens and counts towards your `max_tokens` limit.
     *
     * See [extended thinking](https://docs.anthropic.com/en/docs/build-with-claude/extended-thinking) for details.
     */
    #[Api(union: BetaThinkingConfigParam::class, optional: true)]
    public null|BetaThinkingConfigDisabled|BetaThinkingConfigEnabled $thinking;

    /**
     * How the model should use the provided tools. The model can use a specific tool, any available tool, decide by itself, or not use tools at all.
     */
    #[Api('tool_choice', union: BetaToolChoice::class, optional: true)]
    public null|BetaToolChoiceAny|BetaToolChoiceAuto|BetaToolChoiceNone|BetaToolChoiceTool $toolChoice;

    /**
     * Definitions of tools that the model may use.
     *
     * If you include `tools` in your API request, the model may return `tool_use` content blocks that represent the model's use of those tools. You can then run those tools using the tool input generated by the model and then optionally return results back to the model using `tool_result` content blocks.
     *
     * There are two types of tools: **client tools** and **server tools**. The behavior described below applies to client tools. For [server tools](https://docs.anthropic.com/en/docs/agents-and-tools/tool-use/overview\#server-tools), see their individual documentation as each has its own behavior (e.g., the [web search tool](https://docs.anthropic.com/en/docs/agents-and-tools/tool-use/web-search-tool)).
     *
     * Each tool definition includes:
     *
     * * `name`: Name of the tool.
     * * `description`: Optional, but strongly-recommended description of the tool.
     * * `input_schema`: [JSON schema](https://json-schema.org/draft/2020-12) for the tool `input` shape that the model will produce in `tool_use` output content blocks.
     *
     * For example, if you defined `tools` as:
     *
     * ```json
     * [
     *   {
     *     "name": "get_stock_price",
     *     "description": "Get the current stock price for a given ticker symbol.",
     *     "input_schema": {
     *       "type": "object",
     *       "properties": {
     *         "ticker": {
     *           "type": "string",
     *           "description": "The stock ticker symbol, e.g. AAPL for Apple Inc."
     *         }
     *       },
     *       "required": ["ticker"]
     *     }
     *   }
     * ]
     * ```
     *
     * And then asked the model "What's the S&P 500 at today?", the model might produce `tool_use` content blocks in the response like this:
     *
     * ```json
     * [
     *   {
     *     "type": "tool_use",
     *     "id": "toolu_01D7FLrfh4GYq7yT1ULFeyMV",
     *     "name": "get_stock_price",
     *     "input": { "ticker": "^GSPC" }
     *   }
     * ]
     * ```
     *
     * You might then run your `get_stock_price` tool with `{"ticker": "^GSPC"}` as an input, and return the following back to the model in a subsequent `user` message:
     *
     * ```json
     * [
     *   {
     *     "type": "tool_result",
     *     "tool_use_id": "toolu_01D7FLrfh4GYq7yT1ULFeyMV",
     *     "content": "259.75 USD"
     *   }
     * ]
     * ```
     *
     * Tools can be used for workflows that include running client-side tools and functions, or more generally whenever you want the model to produce a particular JSON structure of output.
     *
     * See our [guide](https://docs.anthropic.com/en/docs/tool-use) for more details.
     *
     * @var null|list<BetaCodeExecutionTool20250522|BetaTool|BetaToolBash20241022|BetaToolBash20250124|BetaToolComputerUse20241022|BetaToolComputerUse20250124|BetaToolTextEditor20241022|BetaToolTextEditor20250124|BetaToolTextEditor20250429|BetaWebSearchTool20250305> $tools
     */
    #[Api(type: new ListOf(union: Tool::class), optional: true)]
    public ?array $tools;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var null|list<string|UnionMember1::*> $anthropicBeta
     */
    #[Api(type: new ListOf(union: AnthropicBeta::class), optional: true)]
    public ?array $anthropicBeta;

    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<BetaMessageParam> $messages
     * @param string|UnionMember0::* $model
     * @param null|list<BetaRequestMCPServerURLDefinition> $mcpServers
     * @param null|list<BetaTextBlockParam>|string $system
     * @param null|list<BetaCodeExecutionTool20250522|BetaTool|BetaToolBash20241022|BetaToolBash20250124|BetaToolComputerUse20241022|BetaToolComputerUse20250124|BetaToolTextEditor20241022|BetaToolTextEditor20250124|BetaToolTextEditor20250429|BetaWebSearchTool20250305> $tools
     * @param null|list<string|UnionMember1::*> $anthropicBeta
     */
    public static function new(
        array $messages,
        string $model,
        ?array $mcpServers = null,
        null|array|string $system = null,
        null|BetaThinkingConfigDisabled|BetaThinkingConfigEnabled $thinking = null,
        null|BetaToolChoiceAny|BetaToolChoiceAuto|BetaToolChoiceNone|BetaToolChoiceTool $toolChoice = null,
        ?array $tools = null,
        ?array $anthropicBeta = null,
    ): self {
        $obj = new self;

        $obj->messages = $messages;
        $obj->model = $model;

        null !== $mcpServers && $obj->mcpServers = $mcpServers;
        null !== $system && $obj->system = $system;
        null !== $thinking && $obj->thinking = $thinking;
        null !== $toolChoice && $obj->toolChoice = $toolChoice;
        null !== $tools && $obj->tools = $tools;
        null !== $anthropicBeta && $obj->anthropicBeta = $anthropicBeta;

        return $obj;
    }
}
