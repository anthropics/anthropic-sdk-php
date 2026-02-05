<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Messages\MessageCountTokensParams\System;
use Anthropic\Beta\Messages\MessageCountTokensParams\Tool;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\Model;

/**
 * Count the number of tokens in a Message.
 *
 * The Token Count API can be used to count the number of tokens in a Message, including tools, images, and documents, without creating it.
 *
 * Learn more about token counting in our [user guide](https://docs.claude.com/en/docs/build-with-claude/token-counting)
 *
 * @see Anthropic\Services\Beta\MessagesService::countTokens()
 *
 * @phpstan-import-type SystemVariants from \Anthropic\Beta\Messages\MessageCountTokensParams\System
 * @phpstan-import-type BetaThinkingConfigParamVariants from \Anthropic\Beta\Messages\BetaThinkingConfigParam
 * @phpstan-import-type BetaToolChoiceVariants from \Anthropic\Beta\Messages\BetaToolChoice
 * @phpstan-import-type ToolVariants from \Anthropic\Beta\Messages\MessageCountTokensParams\Tool
 * @phpstan-import-type BetaMessageParamShape from \Anthropic\Beta\Messages\BetaMessageParam
 * @phpstan-import-type BetaContextManagementConfigShape from \Anthropic\Beta\Messages\BetaContextManagementConfig
 * @phpstan-import-type BetaRequestMCPServerURLDefinitionShape from \Anthropic\Beta\Messages\BetaRequestMCPServerURLDefinition
 * @phpstan-import-type BetaOutputConfigShape from \Anthropic\Beta\Messages\BetaOutputConfig
 * @phpstan-import-type BetaJSONOutputFormatShape from \Anthropic\Beta\Messages\BetaJSONOutputFormat
 * @phpstan-import-type SystemShape from \Anthropic\Beta\Messages\MessageCountTokensParams\System
 * @phpstan-import-type BetaThinkingConfigParamShape from \Anthropic\Beta\Messages\BetaThinkingConfigParam
 * @phpstan-import-type BetaToolChoiceShape from \Anthropic\Beta\Messages\BetaToolChoice
 * @phpstan-import-type ToolShape from \Anthropic\Beta\Messages\MessageCountTokensParams\Tool
 *
 * @phpstan-type MessageCountTokensParamsShape = array{
 *   messages: list<BetaMessageParam|BetaMessageParamShape>,
 *   model: string|Model|value-of<Model>,
 *   contextManagement?: null|BetaContextManagementConfig|BetaContextManagementConfigShape,
 *   mcpServers?: list<BetaRequestMCPServerURLDefinition|BetaRequestMCPServerURLDefinitionShape>|null,
 *   outputConfig?: null|BetaOutputConfig|BetaOutputConfigShape,
 *   outputFormat?: null|BetaJSONOutputFormat|BetaJSONOutputFormatShape,
 *   system?: SystemShape|null,
 *   thinking?: BetaThinkingConfigParamShape|null,
 *   toolChoice?: BetaToolChoiceShape|null,
 *   tools?: list<ToolShape>|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
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
     * @var list<BetaMessageParam> $messages
     */
    #[Required(list: BetaMessageParam::class)]
    public array $messages;

    /**
     * The model that will complete your prompt.\n\nSee [models](https://docs.anthropic.com/en/docs/models-overview) for additional details and options.
     *
     * @var string|value-of<Model> $model
     */
    #[Required(enum: Model::class)]
    public string $model;

    /**
     * Context management configuration.
     *
     * This allows you to control how Claude manages context across multiple requests, such as whether to clear function results or not.
     */
    #[Optional('context_management', nullable: true)]
    public ?BetaContextManagementConfig $contextManagement;

    /**
     * MCP servers to be utilized in this request.
     *
     * @var list<BetaRequestMCPServerURLDefinition>|null $mcpServers
     */
    #[Optional('mcp_servers', list: BetaRequestMCPServerURLDefinition::class)]
    public ?array $mcpServers;

    /**
     * Configuration options for the model's output, such as the output format.
     */
    #[Optional('output_config')]
    public ?BetaOutputConfig $outputConfig;

    /**
     * @deprecated
     *
     * Deprecated: Use `output_config.format` instead. See [structured outputs](https://platform.claude.com/docs/en/build-with-claude/structured-outputs)
     *
     * A schema to specify Claude's output format in responses. This parameter will be removed in a future release.
     */
    #[Optional('output_format', nullable: true)]
    public ?BetaJSONOutputFormat $outputFormat;

    /**
     * System prompt.
     *
     * A system prompt is a way of providing context and instructions to Claude, such as specifying a particular goal or role. See our [guide to system prompts](https://docs.claude.com/en/docs/system-prompts).
     *
     * @var SystemVariants|null $system
     */
    #[Optional(union: System::class)]
    public string|array|null $system;

    /**
     * Configuration for enabling Claude's extended thinking.
     *
     * When enabled, responses include `thinking` content blocks showing Claude's thinking process before the final answer. Requires a minimum budget of 1,024 tokens and counts towards your `max_tokens` limit.
     *
     * See [extended thinking](https://docs.claude.com/en/docs/build-with-claude/extended-thinking) for details.
     *
     * @var BetaThinkingConfigParamVariants|null $thinking
     */
    #[Optional(union: BetaThinkingConfigParam::class)]
    public BetaThinkingConfigEnabled|BetaThinkingConfigDisabled|BetaThinkingConfigAdaptive|null $thinking;

    /**
     * How the model should use the provided tools. The model can use a specific tool, any available tool, decide by itself, or not use tools at all.
     *
     * @var BetaToolChoiceVariants|null $toolChoice
     */
    #[Optional('tool_choice', union: BetaToolChoice::class)]
    public BetaToolChoiceAuto|BetaToolChoiceAny|BetaToolChoiceTool|BetaToolChoiceNone|null $toolChoice;

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
     * @var list<ToolVariants>|null $tools
     */
    #[Optional(list: Tool::class)]
    public ?array $tools;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

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
     * @param list<BetaMessageParam|BetaMessageParamShape> $messages
     * @param string|Model|value-of<Model> $model
     * @param BetaContextManagementConfig|BetaContextManagementConfigShape|null $contextManagement
     * @param list<BetaRequestMCPServerURLDefinition|BetaRequestMCPServerURLDefinitionShape>|null $mcpServers
     * @param BetaOutputConfig|BetaOutputConfigShape|null $outputConfig
     * @param BetaJSONOutputFormat|BetaJSONOutputFormatShape|null $outputFormat
     * @param SystemShape|null $system
     * @param BetaThinkingConfigParamShape|null $thinking
     * @param BetaToolChoiceShape|null $toolChoice
     * @param list<ToolShape>|null $tools
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        array $messages,
        Model|string $model,
        BetaContextManagementConfig|array|null $contextManagement = null,
        ?array $mcpServers = null,
        BetaOutputConfig|array|null $outputConfig = null,
        BetaJSONOutputFormat|array|null $outputFormat = null,
        string|array|null $system = null,
        BetaThinkingConfigEnabled|array|BetaThinkingConfigDisabled|BetaThinkingConfigAdaptive|null $thinking = null,
        BetaToolChoiceAuto|array|BetaToolChoiceAny|BetaToolChoiceTool|BetaToolChoiceNone|null $toolChoice = null,
        ?array $tools = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        $self['messages'] = $messages;
        $self['model'] = $model;

        null !== $contextManagement && $self['contextManagement'] = $contextManagement;
        null !== $mcpServers && $self['mcpServers'] = $mcpServers;
        null !== $outputConfig && $self['outputConfig'] = $outputConfig;
        null !== $outputFormat && $self['outputFormat'] = $outputFormat;
        null !== $system && $self['system'] = $system;
        null !== $thinking && $self['thinking'] = $thinking;
        null !== $toolChoice && $self['toolChoice'] = $toolChoice;
        null !== $tools && $self['tools'] = $tools;
        null !== $betas && $self['betas'] = $betas;

        return $self;
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
     * @param list<BetaMessageParam|BetaMessageParamShape> $messages
     */
    public function withMessages(array $messages): self
    {
        $self = clone $this;
        $self['messages'] = $messages;

        return $self;
    }

    /**
     * The model that will complete your prompt.\n\nSee [models](https://docs.anthropic.com/en/docs/models-overview) for additional details and options.
     *
     * @param string|Model|value-of<Model> $model
     */
    public function withModel(Model|string $model): self
    {
        $self = clone $this;
        $self['model'] = $model;

        return $self;
    }

    /**
     * Context management configuration.
     *
     * This allows you to control how Claude manages context across multiple requests, such as whether to clear function results or not.
     *
     * @param BetaContextManagementConfig|BetaContextManagementConfigShape|null $contextManagement
     */
    public function withContextManagement(
        BetaContextManagementConfig|array|null $contextManagement
    ): self {
        $self = clone $this;
        $self['contextManagement'] = $contextManagement;

        return $self;
    }

    /**
     * MCP servers to be utilized in this request.
     *
     * @param list<BetaRequestMCPServerURLDefinition|BetaRequestMCPServerURLDefinitionShape> $mcpServers
     */
    public function withMCPServers(array $mcpServers): self
    {
        $self = clone $this;
        $self['mcpServers'] = $mcpServers;

        return $self;
    }

    /**
     * Configuration options for the model's output, such as the output format.
     *
     * @param BetaOutputConfig|BetaOutputConfigShape $outputConfig
     */
    public function withOutputConfig(BetaOutputConfig|array $outputConfig): self
    {
        $self = clone $this;
        $self['outputConfig'] = $outputConfig;

        return $self;
    }

    /**
     * Deprecated: Use `output_config.format` instead. See [structured outputs](https://platform.claude.com/docs/en/build-with-claude/structured-outputs).
     *
     * A schema to specify Claude's output format in responses. This parameter will be removed in a future release.
     *
     * @param BetaJSONOutputFormat|BetaJSONOutputFormatShape|null $outputFormat
     */
    public function withOutputFormat(
        BetaJSONOutputFormat|array|null $outputFormat
    ): self {
        $self = clone $this;
        $self['outputFormat'] = $outputFormat;

        return $self;
    }

    /**
     * System prompt.
     *
     * A system prompt is a way of providing context and instructions to Claude, such as specifying a particular goal or role. See our [guide to system prompts](https://docs.claude.com/en/docs/system-prompts).
     *
     * @param SystemShape $system
     */
    public function withSystem(string|array $system): self
    {
        $self = clone $this;
        $self['system'] = $system;

        return $self;
    }

    /**
     * Configuration for enabling Claude's extended thinking.
     *
     * When enabled, responses include `thinking` content blocks showing Claude's thinking process before the final answer. Requires a minimum budget of 1,024 tokens and counts towards your `max_tokens` limit.
     *
     * See [extended thinking](https://docs.claude.com/en/docs/build-with-claude/extended-thinking) for details.
     *
     * @param BetaThinkingConfigParamShape $thinking
     */
    public function withThinking(
        BetaThinkingConfigEnabled|array|BetaThinkingConfigDisabled|BetaThinkingConfigAdaptive $thinking,
    ): self {
        $self = clone $this;
        $self['thinking'] = $thinking;

        return $self;
    }

    /**
     * How the model should use the provided tools. The model can use a specific tool, any available tool, decide by itself, or not use tools at all.
     *
     * @param BetaToolChoiceShape $toolChoice
     */
    public function withToolChoice(
        BetaToolChoiceAuto|array|BetaToolChoiceAny|BetaToolChoiceTool|BetaToolChoiceNone $toolChoice,
    ): self {
        $self = clone $this;
        $self['toolChoice'] = $toolChoice;

        return $self;
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
     * @param list<ToolShape> $tools
     */
    public function withTools(array $tools): self
    {
        $self = clone $this;
        $self['tools'] = $tools;

        return $self;
    }

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas
     */
    public function withBetas(array $betas): self
    {
        $self = clone $this;
        $self['betas'] = $betas;

        return $self;
    }
}
