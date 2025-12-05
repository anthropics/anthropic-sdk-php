<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\MessageCountTokensParams\System;
use Anthropic\Messages\MessageParam\Role;
use Anthropic\Messages\Tool\InputSchema;
use Anthropic\Messages\Tool\Type;
use Anthropic\Messages\WebSearchTool20250305\UserLocation;

/**
 * Count the number of tokens in a Message.
 *
 * The Token Count API can be used to count the number of tokens in a Message, including tools, images, and documents, without creating it.
 *
 * Learn more about token counting in our [user guide](https://docs.claude.com/en/docs/build-with-claude/token-counting)
 *
 * @see Anthropic\Services\MessagesService::countTokens()
 *
 * @phpstan-type MessageCountTokensParamsShape = array{
 *   messages: list<MessageParam|array{
 *     content: string|list<TextBlockParam|ImageBlockParam|DocumentBlockParam|SearchResultBlockParam|ThinkingBlockParam|RedactedThinkingBlockParam|ToolUseBlockParam|ToolResultBlockParam|ServerToolUseBlockParam|WebSearchToolResultBlockParam>,
 *     role: value-of<Role>,
 *   }>,
 *   model: string|Model,
 *   system?: string|list<TextBlockParam|array{
 *     text: string,
 *     type: 'text',
 *     cache_control?: CacheControlEphemeral|null,
 *     citations?: list<CitationCharLocationParam|CitationPageLocationParam|CitationContentBlockLocationParam|CitationWebSearchResultLocationParam|CitationSearchResultLocationParam>|null,
 *   }>,
 *   thinking?: ThinkingConfigEnabled|array{
 *     budget_tokens: int, type: 'enabled'
 *   }|ThinkingConfigDisabled|array{type: 'disabled'},
 *   tool_choice?: ToolChoiceAuto|array{
 *     type: 'auto', disable_parallel_tool_use?: bool|null
 *   }|ToolChoiceAny|array{
 *     type: 'any', disable_parallel_tool_use?: bool|null
 *   }|ToolChoiceTool|array{
 *     name: string, type: 'tool', disable_parallel_tool_use?: bool|null
 *   }|ToolChoiceNone|array{type: 'none'},
 *   tools?: list<Tool|array{
 *     input_schema: InputSchema,
 *     name: string,
 *     cache_control?: CacheControlEphemeral|null,
 *     description?: string|null,
 *     type?: value-of<Type>|null,
 *   }|ToolBash20250124|array{
 *     name: 'bash',
 *     type: 'bash_20250124',
 *     cache_control?: CacheControlEphemeral|null,
 *   }|ToolTextEditor20250124|array{
 *     name: 'str_replace_editor',
 *     type: 'text_editor_20250124',
 *     cache_control?: CacheControlEphemeral|null,
 *   }|ToolTextEditor20250429|array{
 *     name: 'str_replace_based_edit_tool',
 *     type: 'text_editor_20250429',
 *     cache_control?: CacheControlEphemeral|null,
 *   }|ToolTextEditor20250728|array{
 *     name: 'str_replace_based_edit_tool',
 *     type: 'text_editor_20250728',
 *     cache_control?: CacheControlEphemeral|null,
 *     max_characters?: int|null,
 *   }|WebSearchTool20250305|array{
 *     name: 'web_search',
 *     type: 'web_search_20250305',
 *     allowed_domains?: list<string>|null,
 *     blocked_domains?: list<string>|null,
 *     cache_control?: CacheControlEphemeral|null,
 *     max_uses?: int|null,
 *     user_location?: UserLocation|null,
 *   }>,
 * }
 */
final class MessageCountTokensParams implements BaseModel
{
    /** @use SdkModel<MessageCountTokensParamsShape> */
    use SdkModel;
    use SdkParams;

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
     * See [input examples](https://docs.claude.com/en/api/messages-examples).
     *
     * Note that if you want to include a [system prompt](https://docs.claude.com/en/docs/system-prompts), you can use the top-level `system` parameter — there is no `"system"` role for input messages in the Messages API.
     *
     * There is a limit of 100,000 messages in a single request.
     *
     * @var list<MessageParam> $messages
     */
    #[Api(list: MessageParam::class)]
    public array $messages;

    /**
     * The model that will complete your prompt.\n\nSee [models](https://docs.anthropic.com/en/docs/models-overview) for additional details and options.
     *
     * @var string|value-of<Model> $model
     */
    #[Api(enum: Model::class)]
    public string $model;

    /**
     * System prompt.
     *
     * A system prompt is a way of providing context and instructions to Claude, such as specifying a particular goal or role. See our [guide to system prompts](https://docs.claude.com/en/docs/system-prompts).
     *
     * @var string|list<TextBlockParam>|null $system
     */
    #[Api(union: System::class, optional: true)]
    public string|array|null $system;

    /**
     * Configuration for enabling Claude's extended thinking.
     *
     * When enabled, responses include `thinking` content blocks showing Claude's thinking process before the final answer. Requires a minimum budget of 1,024 tokens and counts towards your `max_tokens` limit.
     *
     * See [extended thinking](https://docs.claude.com/en/docs/build-with-claude/extended-thinking) for details.
     */
    #[Api(union: ThinkingConfigParam::class, optional: true)]
    public ThinkingConfigEnabled|ThinkingConfigDisabled|null $thinking;

    /**
     * How the model should use the provided tools. The model can use a specific tool, any available tool, decide by itself, or not use tools at all.
     */
    #[Api(union: ToolChoice::class, optional: true)]
    public ToolChoiceAuto|ToolChoiceAny|ToolChoiceTool|ToolChoiceNone|null $tool_choice;

    /**
     * Definitions of tools that the model may use.
     *
     * If you include `tools` in your API request, the model may return `tool_use` content blocks that represent the model's use of those tools. You can then run those tools using the tool input generated by the model and then optionally return results back to the model using `tool_result` content blocks.
     *
     * There are two types of tools: **client tools** and **server tools**. The behavior described below applies to client tools. For [server tools](https://docs.claude.com/en/docs/agents-and-tools/tool-use/overview\#server-tools), see their individual documentation as each has its own behavior (e.g., the [web search tool](https://docs.claude.com/en/docs/agents-and-tools/tool-use/web-search-tool)).
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
     * See our [guide](https://docs.claude.com/en/docs/tool-use) for more details.
     *
     * @var list<Tool|ToolBash20250124|ToolTextEditor20250124|ToolTextEditor20250429|ToolTextEditor20250728|WebSearchTool20250305>|null $tools
     */
    #[Api(list: MessageCountTokensTool::class, optional: true)]
    public ?array $tools;

    /**
     * `new MessageCountTokensParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MessageCountTokensParams::with(messages: ..., model: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MessageCountTokensParams)->withMessages(...)->withModel(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<MessageParam|array{
     *   content: string|list<TextBlockParam|ImageBlockParam|DocumentBlockParam|SearchResultBlockParam|ThinkingBlockParam|RedactedThinkingBlockParam|ToolUseBlockParam|ToolResultBlockParam|ServerToolUseBlockParam|WebSearchToolResultBlockParam>,
     *   role: value-of<Role>,
     * }> $messages
     * @param string|list<TextBlockParam|array{
     *   text: string,
     *   type: 'text',
     *   cache_control?: CacheControlEphemeral|null,
     *   citations?: list<CitationCharLocationParam|CitationPageLocationParam|CitationContentBlockLocationParam|CitationWebSearchResultLocationParam|CitationSearchResultLocationParam>|null,
     * }> $system
     * @param ThinkingConfigEnabled|array{
     *   budget_tokens: int, type: 'enabled'
     * }|ThinkingConfigDisabled|array{type: 'disabled'} $thinking
     * @param ToolChoiceAuto|array{
     *   type: 'auto', disable_parallel_tool_use?: bool|null
     * }|ToolChoiceAny|array{
     *   type: 'any', disable_parallel_tool_use?: bool|null
     * }|ToolChoiceTool|array{
     *   name: string, type: 'tool', disable_parallel_tool_use?: bool|null
     * }|ToolChoiceNone|array{type: 'none'} $tool_choice
     * @param list<Tool|array{
     *   input_schema: InputSchema,
     *   name: string,
     *   cache_control?: CacheControlEphemeral|null,
     *   description?: string|null,
     *   type?: value-of<Type>|null,
     * }|ToolBash20250124|array{
     *   name: 'bash',
     *   type: 'bash_20250124',
     *   cache_control?: CacheControlEphemeral|null,
     * }|ToolTextEditor20250124|array{
     *   name: 'str_replace_editor',
     *   type: 'text_editor_20250124',
     *   cache_control?: CacheControlEphemeral|null,
     * }|ToolTextEditor20250429|array{
     *   name: 'str_replace_based_edit_tool',
     *   type: 'text_editor_20250429',
     *   cache_control?: CacheControlEphemeral|null,
     * }|ToolTextEditor20250728|array{
     *   name: 'str_replace_based_edit_tool',
     *   type: 'text_editor_20250728',
     *   cache_control?: CacheControlEphemeral|null,
     *   max_characters?: int|null,
     * }|WebSearchTool20250305|array{
     *   name: 'web_search',
     *   type: 'web_search_20250305',
     *   allowed_domains?: list<string>|null,
     *   blocked_domains?: list<string>|null,
     *   cache_control?: CacheControlEphemeral|null,
     *   max_uses?: int|null,
     *   user_location?: UserLocation|null,
     * }> $tools
     */
    public static function with(
        array $messages,
        string|Model $model,
        string|array|null $system = null,
        ThinkingConfigEnabled|array|ThinkingConfigDisabled|null $thinking = null,
        ToolChoiceAuto|array|ToolChoiceAny|ToolChoiceTool|ToolChoiceNone|null $tool_choice = null,
        ?array $tools = null,
    ): self {
        $obj = new self;

        $obj['messages'] = $messages;
        $obj['model'] = $model;

        null !== $system && $obj['system'] = $system;
        null !== $thinking && $obj['thinking'] = $thinking;
        null !== $tool_choice && $obj['tool_choice'] = $tool_choice;
        null !== $tools && $obj['tools'] = $tools;

        return $obj;
    }

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
     * See [input examples](https://docs.claude.com/en/api/messages-examples).
     *
     * Note that if you want to include a [system prompt](https://docs.claude.com/en/docs/system-prompts), you can use the top-level `system` parameter — there is no `"system"` role for input messages in the Messages API.
     *
     * There is a limit of 100,000 messages in a single request.
     *
     * @param list<MessageParam|array{
     *   content: string|list<TextBlockParam|ImageBlockParam|DocumentBlockParam|SearchResultBlockParam|ThinkingBlockParam|RedactedThinkingBlockParam|ToolUseBlockParam|ToolResultBlockParam|ServerToolUseBlockParam|WebSearchToolResultBlockParam>,
     *   role: value-of<Role>,
     * }> $messages
     */
    public function withMessages(array $messages): self
    {
        $obj = clone $this;
        $obj['messages'] = $messages;

        return $obj;
    }

    /**
     * The model that will complete your prompt.\n\nSee [models](https://docs.anthropic.com/en/docs/models-overview) for additional details and options.
     */
    public function withModel(string|Model $model): self
    {
        $obj = clone $this;
        $obj['model'] = $model;

        return $obj;
    }

    /**
     * System prompt.
     *
     * A system prompt is a way of providing context and instructions to Claude, such as specifying a particular goal or role. See our [guide to system prompts](https://docs.claude.com/en/docs/system-prompts).
     *
     * @param string|list<TextBlockParam|array{
     *   text: string,
     *   type: 'text',
     *   cache_control?: CacheControlEphemeral|null,
     *   citations?: list<CitationCharLocationParam|CitationPageLocationParam|CitationContentBlockLocationParam|CitationWebSearchResultLocationParam|CitationSearchResultLocationParam>|null,
     * }> $system
     */
    public function withSystem(string|array $system): self
    {
        $obj = clone $this;
        $obj['system'] = $system;

        return $obj;
    }

    /**
     * Configuration for enabling Claude's extended thinking.
     *
     * When enabled, responses include `thinking` content blocks showing Claude's thinking process before the final answer. Requires a minimum budget of 1,024 tokens and counts towards your `max_tokens` limit.
     *
     * See [extended thinking](https://docs.claude.com/en/docs/build-with-claude/extended-thinking) for details.
     *
     * @param ThinkingConfigEnabled|array{
     *   budget_tokens: int, type: 'enabled'
     * }|ThinkingConfigDisabled|array{type: 'disabled'} $thinking
     */
    public function withThinking(
        ThinkingConfigEnabled|array|ThinkingConfigDisabled $thinking
    ): self {
        $obj = clone $this;
        $obj['thinking'] = $thinking;

        return $obj;
    }

    /**
     * How the model should use the provided tools. The model can use a specific tool, any available tool, decide by itself, or not use tools at all.
     *
     * @param ToolChoiceAuto|array{
     *   type: 'auto', disable_parallel_tool_use?: bool|null
     * }|ToolChoiceAny|array{
     *   type: 'any', disable_parallel_tool_use?: bool|null
     * }|ToolChoiceTool|array{
     *   name: string, type: 'tool', disable_parallel_tool_use?: bool|null
     * }|ToolChoiceNone|array{type: 'none'} $toolChoice
     */
    public function withToolChoice(
        ToolChoiceAuto|array|ToolChoiceAny|ToolChoiceTool|ToolChoiceNone $toolChoice
    ): self {
        $obj = clone $this;
        $obj['tool_choice'] = $toolChoice;

        return $obj;
    }

    /**
     * Definitions of tools that the model may use.
     *
     * If you include `tools` in your API request, the model may return `tool_use` content blocks that represent the model's use of those tools. You can then run those tools using the tool input generated by the model and then optionally return results back to the model using `tool_result` content blocks.
     *
     * There are two types of tools: **client tools** and **server tools**. The behavior described below applies to client tools. For [server tools](https://docs.claude.com/en/docs/agents-and-tools/tool-use/overview\#server-tools), see their individual documentation as each has its own behavior (e.g., the [web search tool](https://docs.claude.com/en/docs/agents-and-tools/tool-use/web-search-tool)).
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
     * See our [guide](https://docs.claude.com/en/docs/tool-use) for more details.
     *
     * @param list<Tool|array{
     *   input_schema: InputSchema,
     *   name: string,
     *   cache_control?: CacheControlEphemeral|null,
     *   description?: string|null,
     *   type?: value-of<Type>|null,
     * }|ToolBash20250124|array{
     *   name: 'bash',
     *   type: 'bash_20250124',
     *   cache_control?: CacheControlEphemeral|null,
     * }|ToolTextEditor20250124|array{
     *   name: 'str_replace_editor',
     *   type: 'text_editor_20250124',
     *   cache_control?: CacheControlEphemeral|null,
     * }|ToolTextEditor20250429|array{
     *   name: 'str_replace_based_edit_tool',
     *   type: 'text_editor_20250429',
     *   cache_control?: CacheControlEphemeral|null,
     * }|ToolTextEditor20250728|array{
     *   name: 'str_replace_based_edit_tool',
     *   type: 'text_editor_20250728',
     *   cache_control?: CacheControlEphemeral|null,
     *   max_characters?: int|null,
     * }|WebSearchTool20250305|array{
     *   name: 'web_search',
     *   type: 'web_search_20250305',
     *   allowed_domains?: list<string>|null,
     *   blocked_domains?: list<string>|null,
     *   cache_control?: CacheControlEphemeral|null,
     *   max_uses?: int|null,
     *   user_location?: UserLocation|null,
     * }> $tools
     */
    public function withTools(array $tools): self
    {
        $obj = clone $this;
        $obj['tools'] = $tools;

        return $obj;
    }
}
