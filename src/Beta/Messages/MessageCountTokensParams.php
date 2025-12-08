<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Messages\BetaMessageParam\Role;
use Anthropic\Beta\Messages\BetaOutputConfig\Effort;
use Anthropic\Beta\Messages\BetaTool\AllowedCaller;
use Anthropic\Beta\Messages\BetaTool\InputSchema;
use Anthropic\Beta\Messages\BetaTool\Type;
use Anthropic\Beta\Messages\BetaWebSearchTool20250305\UserLocation;
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
 * @phpstan-type MessageCountTokensParamsShape = array{
 *   messages: list<BetaMessageParam|array{
 *     content: string|list<BetaTextBlockParam|BetaImageBlockParam|BetaRequestDocumentBlock|BetaSearchResultBlockParam|BetaThinkingBlockParam|BetaRedactedThinkingBlockParam|BetaToolUseBlockParam|BetaToolResultBlockParam|BetaServerToolUseBlockParam|BetaWebSearchToolResultBlockParam|BetaWebFetchToolResultBlockParam|BetaCodeExecutionToolResultBlockParam|BetaBashCodeExecutionToolResultBlockParam|BetaTextEditorCodeExecutionToolResultBlockParam|BetaToolSearchToolResultBlockParam|BetaMCPToolUseBlockParam|BetaRequestMCPToolResultBlockParam|BetaContainerUploadBlockParam>,
 *     role: value-of<Role>,
 *   }>,
 *   model: string|Model,
 *   context_management?: null|BetaContextManagementConfig|array{
 *     edits?: list<BetaClearToolUses20250919Edit|BetaClearThinking20251015Edit>|null,
 *   },
 *   mcp_servers?: list<BetaRequestMCPServerURLDefinition|array{
 *     name: string,
 *     type: 'url',
 *     url: string,
 *     authorization_token?: string|null,
 *     tool_configuration?: BetaRequestMCPServerToolConfiguration|null,
 *   }>,
 *   output_config?: BetaOutputConfig|array{effort?: value-of<Effort>|null},
 *   output_format?: null|BetaJSONOutputFormat|array{
 *     schema: array<string,mixed>, type: 'json_schema'
 *   },
 *   system?: string|list<BetaTextBlockParam|array{
 *     text: string,
 *     type: 'text',
 *     cache_control?: BetaCacheControlEphemeral|null,
 *     citations?: list<BetaCitationCharLocationParam|BetaCitationPageLocationParam|BetaCitationContentBlockLocationParam|BetaCitationWebSearchResultLocationParam|BetaCitationSearchResultLocationParam>|null,
 *   }>,
 *   thinking?: BetaThinkingConfigEnabled|array{
 *     budget_tokens: int, type: 'enabled'
 *   }|BetaThinkingConfigDisabled|array{type: 'disabled'},
 *   tool_choice?: BetaToolChoiceAuto|array{
 *     type: 'auto', disable_parallel_tool_use?: bool|null
 *   }|BetaToolChoiceAny|array{
 *     type: 'any', disable_parallel_tool_use?: bool|null
 *   }|BetaToolChoiceTool|array{
 *     name: string, type: 'tool', disable_parallel_tool_use?: bool|null
 *   }|BetaToolChoiceNone|array{type: 'none'},
 *   tools?: list<BetaTool|array{
 *     input_schema: InputSchema,
 *     name: string,
 *     allowed_callers?: list<value-of<AllowedCaller>>|null,
 *     cache_control?: BetaCacheControlEphemeral|null,
 *     defer_loading?: bool|null,
 *     description?: string|null,
 *     input_examples?: list<array<string,mixed>>|null,
 *     strict?: bool|null,
 *     type?: value-of<Type>|null,
 *   }|BetaToolBash20241022|array{
 *     name: 'bash',
 *     type: 'bash_20241022',
 *     allowed_callers?: list<value-of<\Anthropic\Beta\Messages\BetaToolBash20241022\AllowedCaller>>|null,
 *     cache_control?: BetaCacheControlEphemeral|null,
 *     defer_loading?: bool|null,
 *     input_examples?: list<array<string,mixed>>|null,
 *     strict?: bool|null,
 *   }|BetaToolBash20250124|array{
 *     name: 'bash',
 *     type: 'bash_20250124',
 *     allowed_callers?: list<value-of<\Anthropic\Beta\Messages\BetaToolBash20250124\AllowedCaller>>|null,
 *     cache_control?: BetaCacheControlEphemeral|null,
 *     defer_loading?: bool|null,
 *     input_examples?: list<array<string,mixed>>|null,
 *     strict?: bool|null,
 *   }|BetaCodeExecutionTool20250522|array{
 *     name: 'code_execution',
 *     type: 'code_execution_20250522',
 *     allowed_callers?: list<value-of<\Anthropic\Beta\Messages\BetaCodeExecutionTool20250522\AllowedCaller>>|null,
 *     cache_control?: BetaCacheControlEphemeral|null,
 *     defer_loading?: bool|null,
 *     strict?: bool|null,
 *   }|BetaCodeExecutionTool20250825|array{
 *     name: 'code_execution',
 *     type: 'code_execution_20250825',
 *     allowed_callers?: list<value-of<\Anthropic\Beta\Messages\BetaCodeExecutionTool20250825\AllowedCaller>>|null,
 *     cache_control?: BetaCacheControlEphemeral|null,
 *     defer_loading?: bool|null,
 *     strict?: bool|null,
 *   }|BetaToolComputerUse20241022|array{
 *     display_height_px: int,
 *     display_width_px: int,
 *     name: 'computer',
 *     type: 'computer_20241022',
 *     allowed_callers?: list<value-of<\Anthropic\Beta\Messages\BetaToolComputerUse20241022\AllowedCaller>>|null,
 *     cache_control?: BetaCacheControlEphemeral|null,
 *     defer_loading?: bool|null,
 *     display_number?: int|null,
 *     input_examples?: list<array<string,mixed>>|null,
 *     strict?: bool|null,
 *   }|BetaMemoryTool20250818|array{
 *     name: 'memory',
 *     type: 'memory_20250818',
 *     allowed_callers?: list<value-of<\Anthropic\Beta\Messages\BetaMemoryTool20250818\AllowedCaller>>|null,
 *     cache_control?: BetaCacheControlEphemeral|null,
 *     defer_loading?: bool|null,
 *     input_examples?: list<array<string,mixed>>|null,
 *     strict?: bool|null,
 *   }|BetaToolComputerUse20250124|array{
 *     display_height_px: int,
 *     display_width_px: int,
 *     name: 'computer',
 *     type: 'computer_20250124',
 *     allowed_callers?: list<value-of<\Anthropic\Beta\Messages\BetaToolComputerUse20250124\AllowedCaller>>|null,
 *     cache_control?: BetaCacheControlEphemeral|null,
 *     defer_loading?: bool|null,
 *     display_number?: int|null,
 *     input_examples?: list<array<string,mixed>>|null,
 *     strict?: bool|null,
 *   }|BetaToolTextEditor20241022|array{
 *     name: 'str_replace_editor',
 *     type: 'text_editor_20241022',
 *     allowed_callers?: list<value-of<\Anthropic\Beta\Messages\BetaToolTextEditor20241022\AllowedCaller>>|null,
 *     cache_control?: BetaCacheControlEphemeral|null,
 *     defer_loading?: bool|null,
 *     input_examples?: list<array<string,mixed>>|null,
 *     strict?: bool|null,
 *   }|BetaToolComputerUse20251124|array{
 *     display_height_px: int,
 *     display_width_px: int,
 *     name: 'computer',
 *     type: 'computer_20251124',
 *     allowed_callers?: list<value-of<\Anthropic\Beta\Messages\BetaToolComputerUse20251124\AllowedCaller>>|null,
 *     cache_control?: BetaCacheControlEphemeral|null,
 *     defer_loading?: bool|null,
 *     display_number?: int|null,
 *     enable_zoom?: bool|null,
 *     input_examples?: list<array<string,mixed>>|null,
 *     strict?: bool|null,
 *   }|BetaToolTextEditor20250124|array{
 *     name: 'str_replace_editor',
 *     type: 'text_editor_20250124',
 *     allowed_callers?: list<value-of<\Anthropic\Beta\Messages\BetaToolTextEditor20250124\AllowedCaller>>|null,
 *     cache_control?: BetaCacheControlEphemeral|null,
 *     defer_loading?: bool|null,
 *     input_examples?: list<array<string,mixed>>|null,
 *     strict?: bool|null,
 *   }|BetaToolTextEditor20250429|array{
 *     name: 'str_replace_based_edit_tool',
 *     type: 'text_editor_20250429',
 *     allowed_callers?: list<value-of<\Anthropic\Beta\Messages\BetaToolTextEditor20250429\AllowedCaller>>|null,
 *     cache_control?: BetaCacheControlEphemeral|null,
 *     defer_loading?: bool|null,
 *     input_examples?: list<array<string,mixed>>|null,
 *     strict?: bool|null,
 *   }|BetaToolTextEditor20250728|array{
 *     name: 'str_replace_based_edit_tool',
 *     type: 'text_editor_20250728',
 *     allowed_callers?: list<value-of<\Anthropic\Beta\Messages\BetaToolTextEditor20250728\AllowedCaller>>|null,
 *     cache_control?: BetaCacheControlEphemeral|null,
 *     defer_loading?: bool|null,
 *     input_examples?: list<array<string,mixed>>|null,
 *     max_characters?: int|null,
 *     strict?: bool|null,
 *   }|BetaWebSearchTool20250305|array{
 *     name: 'web_search',
 *     type: 'web_search_20250305',
 *     allowed_callers?: list<value-of<\Anthropic\Beta\Messages\BetaWebSearchTool20250305\AllowedCaller>>|null,
 *     allowed_domains?: list<string>|null,
 *     blocked_domains?: list<string>|null,
 *     cache_control?: BetaCacheControlEphemeral|null,
 *     defer_loading?: bool|null,
 *     max_uses?: int|null,
 *     strict?: bool|null,
 *     user_location?: UserLocation|null,
 *   }|BetaWebFetchTool20250910|array{
 *     name: 'web_fetch',
 *     type: 'web_fetch_20250910',
 *     allowed_callers?: list<value-of<\Anthropic\Beta\Messages\BetaWebFetchTool20250910\AllowedCaller>>|null,
 *     allowed_domains?: list<string>|null,
 *     blocked_domains?: list<string>|null,
 *     cache_control?: BetaCacheControlEphemeral|null,
 *     citations?: BetaCitationsConfigParam|null,
 *     defer_loading?: bool|null,
 *     max_content_tokens?: int|null,
 *     max_uses?: int|null,
 *     strict?: bool|null,
 *   }|BetaToolSearchToolBm25_20251119|array{
 *     name: 'tool_search_tool_bm25',
 *     type: value-of<\Anthropic\Beta\Messages\BetaToolSearchToolBm25_20251119\Type>,
 *     allowed_callers?: list<value-of<\Anthropic\Beta\Messages\BetaToolSearchToolBm25_20251119\AllowedCaller>>|null,
 *     cache_control?: BetaCacheControlEphemeral|null,
 *     defer_loading?: bool|null,
 *     strict?: bool|null,
 *   }|BetaToolSearchToolRegex20251119|array{
 *     name: 'tool_search_tool_regex',
 *     type: value-of<\Anthropic\Beta\Messages\BetaToolSearchToolRegex20251119\Type>,
 *     allowed_callers?: list<value-of<\Anthropic\Beta\Messages\BetaToolSearchToolRegex20251119\AllowedCaller>>|null,
 *     cache_control?: BetaCacheControlEphemeral|null,
 *     defer_loading?: bool|null,
 *     strict?: bool|null,
 *   }|BetaMCPToolset|array{
 *     mcp_server_name: string,
 *     type: 'mcp_toolset',
 *     cache_control?: BetaCacheControlEphemeral|null,
 *     configs?: array<string,BetaMCPToolConfig>|null,
 *     default_config?: BetaMCPToolDefaultConfig|null,
 *   }>,
 *   betas?: list<string|AnthropicBeta>,
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
    #[Optional(nullable: true)]
    public ?BetaContextManagementConfig $context_management;

    /**
     * MCP servers to be utilized in this request.
     *
     * @var list<BetaRequestMCPServerURLDefinition>|null $mcp_servers
     */
    #[Optional(list: BetaRequestMCPServerURLDefinition::class)]
    public ?array $mcp_servers;

    /**
     * Configuration options for the model's output. Controls aspects like how much effort the model puts into its response.
     */
    #[Optional]
    public ?BetaOutputConfig $output_config;

    /**
     * A schema to specify Claude's output format in responses.
     */
    #[Optional(nullable: true)]
    public ?BetaJSONOutputFormat $output_format;

    /**
     * System prompt.
     *
     * A system prompt is a way of providing context and instructions to Claude, such as specifying a particular goal or role. See our [guide to system prompts](https://docs.claude.com/en/docs/system-prompts).
     *
     * @var string|list<BetaTextBlockParam>|null $system
     */
    #[Optional(union: System::class)]
    public string|array|null $system;

    /**
     * Configuration for enabling Claude's extended thinking.
     *
     * When enabled, responses include `thinking` content blocks showing Claude's thinking process before the final answer. Requires a minimum budget of 1,024 tokens and counts towards your `max_tokens` limit.
     *
     * See [extended thinking](https://docs.claude.com/en/docs/build-with-claude/extended-thinking) for details.
     */
    #[Optional(union: BetaThinkingConfigParam::class)]
    public BetaThinkingConfigEnabled|BetaThinkingConfigDisabled|null $thinking;

    /**
     * How the model should use the provided tools. The model can use a specific tool, any available tool, decide by itself, or not use tools at all.
     */
    #[Optional(union: BetaToolChoice::class)]
    public BetaToolChoiceAuto|BetaToolChoiceAny|BetaToolChoiceTool|BetaToolChoiceNone|null $tool_choice;

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
     * @var list<BetaTool|BetaToolBash20241022|BetaToolBash20250124|BetaCodeExecutionTool20250522|BetaCodeExecutionTool20250825|BetaToolComputerUse20241022|BetaMemoryTool20250818|BetaToolComputerUse20250124|BetaToolTextEditor20241022|BetaToolComputerUse20251124|BetaToolTextEditor20250124|BetaToolTextEditor20250429|BetaToolTextEditor20250728|BetaWebSearchTool20250305|BetaWebFetchTool20250910|BetaToolSearchToolBm25_20251119|BetaToolSearchToolRegex20251119|BetaMCPToolset>|null $tools
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
     * @param list<BetaMessageParam|array{
     *   content: string|list<BetaTextBlockParam|BetaImageBlockParam|BetaRequestDocumentBlock|BetaSearchResultBlockParam|BetaThinkingBlockParam|BetaRedactedThinkingBlockParam|BetaToolUseBlockParam|BetaToolResultBlockParam|BetaServerToolUseBlockParam|BetaWebSearchToolResultBlockParam|BetaWebFetchToolResultBlockParam|BetaCodeExecutionToolResultBlockParam|BetaBashCodeExecutionToolResultBlockParam|BetaTextEditorCodeExecutionToolResultBlockParam|BetaToolSearchToolResultBlockParam|BetaMCPToolUseBlockParam|BetaRequestMCPToolResultBlockParam|BetaContainerUploadBlockParam>,
     *   role: value-of<Role>,
     * }> $messages
     * @param BetaContextManagementConfig|array{
     *   edits?: list<BetaClearToolUses20250919Edit|BetaClearThinking20251015Edit>|null
     * }|null $context_management
     * @param list<BetaRequestMCPServerURLDefinition|array{
     *   name: string,
     *   type: 'url',
     *   url: string,
     *   authorization_token?: string|null,
     *   tool_configuration?: BetaRequestMCPServerToolConfiguration|null,
     * }> $mcp_servers
     * @param BetaOutputConfig|array{effort?: value-of<Effort>|null} $output_config
     * @param BetaJSONOutputFormat|array{
     *   schema: array<string,mixed>, type: 'json_schema'
     * }|null $output_format
     * @param string|list<BetaTextBlockParam|array{
     *   text: string,
     *   type: 'text',
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   citations?: list<BetaCitationCharLocationParam|BetaCitationPageLocationParam|BetaCitationContentBlockLocationParam|BetaCitationWebSearchResultLocationParam|BetaCitationSearchResultLocationParam>|null,
     * }> $system
     * @param BetaThinkingConfigEnabled|array{
     *   budget_tokens: int, type: 'enabled'
     * }|BetaThinkingConfigDisabled|array{type: 'disabled'} $thinking
     * @param BetaToolChoiceAuto|array{
     *   type: 'auto', disable_parallel_tool_use?: bool|null
     * }|BetaToolChoiceAny|array{
     *   type: 'any', disable_parallel_tool_use?: bool|null
     * }|BetaToolChoiceTool|array{
     *   name: string, type: 'tool', disable_parallel_tool_use?: bool|null
     * }|BetaToolChoiceNone|array{type: 'none'} $tool_choice
     * @param list<BetaTool|array{
     *   input_schema: InputSchema,
     *   name: string,
     *   allowed_callers?: list<value-of<AllowedCaller>>|null,
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   defer_loading?: bool|null,
     *   description?: string|null,
     *   input_examples?: list<array<string,mixed>>|null,
     *   strict?: bool|null,
     *   type?: value-of<Type>|null,
     * }|BetaToolBash20241022|array{
     *   name: 'bash',
     *   type: 'bash_20241022',
     *   allowed_callers?: list<value-of<BetaToolBash20241022\AllowedCaller>>|null,
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   defer_loading?: bool|null,
     *   input_examples?: list<array<string,mixed>>|null,
     *   strict?: bool|null,
     * }|BetaToolBash20250124|array{
     *   name: 'bash',
     *   type: 'bash_20250124',
     *   allowed_callers?: list<value-of<BetaToolBash20250124\AllowedCaller>>|null,
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   defer_loading?: bool|null,
     *   input_examples?: list<array<string,mixed>>|null,
     *   strict?: bool|null,
     * }|BetaCodeExecutionTool20250522|array{
     *   name: 'code_execution',
     *   type: 'code_execution_20250522',
     *   allowed_callers?: list<value-of<BetaCodeExecutionTool20250522\AllowedCaller>>|null,
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   defer_loading?: bool|null,
     *   strict?: bool|null,
     * }|BetaCodeExecutionTool20250825|array{
     *   name: 'code_execution',
     *   type: 'code_execution_20250825',
     *   allowed_callers?: list<value-of<BetaCodeExecutionTool20250825\AllowedCaller>>|null,
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   defer_loading?: bool|null,
     *   strict?: bool|null,
     * }|BetaToolComputerUse20241022|array{
     *   display_height_px: int,
     *   display_width_px: int,
     *   name: 'computer',
     *   type: 'computer_20241022',
     *   allowed_callers?: list<value-of<BetaToolComputerUse20241022\AllowedCaller>>|null,
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   defer_loading?: bool|null,
     *   display_number?: int|null,
     *   input_examples?: list<array<string,mixed>>|null,
     *   strict?: bool|null,
     * }|BetaMemoryTool20250818|array{
     *   name: 'memory',
     *   type: 'memory_20250818',
     *   allowed_callers?: list<value-of<BetaMemoryTool20250818\AllowedCaller>>|null,
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   defer_loading?: bool|null,
     *   input_examples?: list<array<string,mixed>>|null,
     *   strict?: bool|null,
     * }|BetaToolComputerUse20250124|array{
     *   display_height_px: int,
     *   display_width_px: int,
     *   name: 'computer',
     *   type: 'computer_20250124',
     *   allowed_callers?: list<value-of<BetaToolComputerUse20250124\AllowedCaller>>|null,
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   defer_loading?: bool|null,
     *   display_number?: int|null,
     *   input_examples?: list<array<string,mixed>>|null,
     *   strict?: bool|null,
     * }|BetaToolTextEditor20241022|array{
     *   name: 'str_replace_editor',
     *   type: 'text_editor_20241022',
     *   allowed_callers?: list<value-of<BetaToolTextEditor20241022\AllowedCaller>>|null,
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   defer_loading?: bool|null,
     *   input_examples?: list<array<string,mixed>>|null,
     *   strict?: bool|null,
     * }|BetaToolComputerUse20251124|array{
     *   display_height_px: int,
     *   display_width_px: int,
     *   name: 'computer',
     *   type: 'computer_20251124',
     *   allowed_callers?: list<value-of<BetaToolComputerUse20251124\AllowedCaller>>|null,
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   defer_loading?: bool|null,
     *   display_number?: int|null,
     *   enable_zoom?: bool|null,
     *   input_examples?: list<array<string,mixed>>|null,
     *   strict?: bool|null,
     * }|BetaToolTextEditor20250124|array{
     *   name: 'str_replace_editor',
     *   type: 'text_editor_20250124',
     *   allowed_callers?: list<value-of<BetaToolTextEditor20250124\AllowedCaller>>|null,
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   defer_loading?: bool|null,
     *   input_examples?: list<array<string,mixed>>|null,
     *   strict?: bool|null,
     * }|BetaToolTextEditor20250429|array{
     *   name: 'str_replace_based_edit_tool',
     *   type: 'text_editor_20250429',
     *   allowed_callers?: list<value-of<BetaToolTextEditor20250429\AllowedCaller>>|null,
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   defer_loading?: bool|null,
     *   input_examples?: list<array<string,mixed>>|null,
     *   strict?: bool|null,
     * }|BetaToolTextEditor20250728|array{
     *   name: 'str_replace_based_edit_tool',
     *   type: 'text_editor_20250728',
     *   allowed_callers?: list<value-of<BetaToolTextEditor20250728\AllowedCaller>>|null,
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   defer_loading?: bool|null,
     *   input_examples?: list<array<string,mixed>>|null,
     *   max_characters?: int|null,
     *   strict?: bool|null,
     * }|BetaWebSearchTool20250305|array{
     *   name: 'web_search',
     *   type: 'web_search_20250305',
     *   allowed_callers?: list<value-of<BetaWebSearchTool20250305\AllowedCaller>>|null,
     *   allowed_domains?: list<string>|null,
     *   blocked_domains?: list<string>|null,
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   defer_loading?: bool|null,
     *   max_uses?: int|null,
     *   strict?: bool|null,
     *   user_location?: UserLocation|null,
     * }|BetaWebFetchTool20250910|array{
     *   name: 'web_fetch',
     *   type: 'web_fetch_20250910',
     *   allowed_callers?: list<value-of<BetaWebFetchTool20250910\AllowedCaller>>|null,
     *   allowed_domains?: list<string>|null,
     *   blocked_domains?: list<string>|null,
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   citations?: BetaCitationsConfigParam|null,
     *   defer_loading?: bool|null,
     *   max_content_tokens?: int|null,
     *   max_uses?: int|null,
     *   strict?: bool|null,
     * }|BetaToolSearchToolBm25_20251119|array{
     *   name: 'tool_search_tool_bm25',
     *   type: value-of<BetaToolSearchToolBm25_20251119\Type>,
     *   allowed_callers?: list<value-of<BetaToolSearchToolBm25_20251119\AllowedCaller>>|null,
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   defer_loading?: bool|null,
     *   strict?: bool|null,
     * }|BetaToolSearchToolRegex20251119|array{
     *   name: 'tool_search_tool_regex',
     *   type: value-of<BetaToolSearchToolRegex20251119\Type>,
     *   allowed_callers?: list<value-of<BetaToolSearchToolRegex20251119\AllowedCaller>>|null,
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   defer_loading?: bool|null,
     *   strict?: bool|null,
     * }|BetaMCPToolset|array{
     *   mcp_server_name: string,
     *   type: 'mcp_toolset',
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   configs?: array<string,BetaMCPToolConfig>|null,
     *   default_config?: BetaMCPToolDefaultConfig|null,
     * }> $tools
     * @param list<string|AnthropicBeta> $betas
     */
    public static function with(
        array $messages,
        string|Model $model,
        BetaContextManagementConfig|array|null $context_management = null,
        ?array $mcp_servers = null,
        BetaOutputConfig|array|null $output_config = null,
        BetaJSONOutputFormat|array|null $output_format = null,
        string|array|null $system = null,
        BetaThinkingConfigEnabled|array|BetaThinkingConfigDisabled|null $thinking = null,
        BetaToolChoiceAuto|array|BetaToolChoiceAny|BetaToolChoiceTool|BetaToolChoiceNone|null $tool_choice = null,
        ?array $tools = null,
        ?array $betas = null,
    ): self {
        $obj = new self;

        $obj['messages'] = $messages;
        $obj['model'] = $model;

        null !== $context_management && $obj['context_management'] = $context_management;
        null !== $mcp_servers && $obj['mcp_servers'] = $mcp_servers;
        null !== $output_config && $obj['output_config'] = $output_config;
        null !== $output_format && $obj['output_format'] = $output_format;
        null !== $system && $obj['system'] = $system;
        null !== $thinking && $obj['thinking'] = $thinking;
        null !== $tool_choice && $obj['tool_choice'] = $tool_choice;
        null !== $tools && $obj['tools'] = $tools;
        null !== $betas && $obj['betas'] = $betas;

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
     * @param list<BetaMessageParam|array{
     *   content: string|list<BetaTextBlockParam|BetaImageBlockParam|BetaRequestDocumentBlock|BetaSearchResultBlockParam|BetaThinkingBlockParam|BetaRedactedThinkingBlockParam|BetaToolUseBlockParam|BetaToolResultBlockParam|BetaServerToolUseBlockParam|BetaWebSearchToolResultBlockParam|BetaWebFetchToolResultBlockParam|BetaCodeExecutionToolResultBlockParam|BetaBashCodeExecutionToolResultBlockParam|BetaTextEditorCodeExecutionToolResultBlockParam|BetaToolSearchToolResultBlockParam|BetaMCPToolUseBlockParam|BetaRequestMCPToolResultBlockParam|BetaContainerUploadBlockParam>,
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
     * Context management configuration.
     *
     * This allows you to control how Claude manages context across multiple requests, such as whether to clear function results or not.
     *
     * @param BetaContextManagementConfig|array{
     *   edits?: list<BetaClearToolUses20250919Edit|BetaClearThinking20251015Edit>|null
     * }|null $contextManagement
     */
    public function withContextManagement(
        BetaContextManagementConfig|array|null $contextManagement
    ): self {
        $obj = clone $this;
        $obj['context_management'] = $contextManagement;

        return $obj;
    }

    /**
     * MCP servers to be utilized in this request.
     *
     * @param list<BetaRequestMCPServerURLDefinition|array{
     *   name: string,
     *   type: 'url',
     *   url: string,
     *   authorization_token?: string|null,
     *   tool_configuration?: BetaRequestMCPServerToolConfiguration|null,
     * }> $mcpServers
     */
    public function withMCPServers(array $mcpServers): self
    {
        $obj = clone $this;
        $obj['mcp_servers'] = $mcpServers;

        return $obj;
    }

    /**
     * Configuration options for the model's output. Controls aspects like how much effort the model puts into its response.
     *
     * @param BetaOutputConfig|array{effort?: value-of<Effort>|null} $outputConfig
     */
    public function withOutputConfig(BetaOutputConfig|array $outputConfig): self
    {
        $obj = clone $this;
        $obj['output_config'] = $outputConfig;

        return $obj;
    }

    /**
     * A schema to specify Claude's output format in responses.
     *
     * @param BetaJSONOutputFormat|array{
     *   schema: array<string,mixed>, type: 'json_schema'
     * }|null $outputFormat
     */
    public function withOutputFormat(
        BetaJSONOutputFormat|array|null $outputFormat
    ): self {
        $obj = clone $this;
        $obj['output_format'] = $outputFormat;

        return $obj;
    }

    /**
     * System prompt.
     *
     * A system prompt is a way of providing context and instructions to Claude, such as specifying a particular goal or role. See our [guide to system prompts](https://docs.claude.com/en/docs/system-prompts).
     *
     * @param string|list<BetaTextBlockParam|array{
     *   text: string,
     *   type: 'text',
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   citations?: list<BetaCitationCharLocationParam|BetaCitationPageLocationParam|BetaCitationContentBlockLocationParam|BetaCitationWebSearchResultLocationParam|BetaCitationSearchResultLocationParam>|null,
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
     * @param BetaThinkingConfigEnabled|array{
     *   budget_tokens: int, type: 'enabled'
     * }|BetaThinkingConfigDisabled|array{type: 'disabled'} $thinking
     */
    public function withThinking(
        BetaThinkingConfigEnabled|array|BetaThinkingConfigDisabled $thinking
    ): self {
        $obj = clone $this;
        $obj['thinking'] = $thinking;

        return $obj;
    }

    /**
     * How the model should use the provided tools. The model can use a specific tool, any available tool, decide by itself, or not use tools at all.
     *
     * @param BetaToolChoiceAuto|array{
     *   type: 'auto', disable_parallel_tool_use?: bool|null
     * }|BetaToolChoiceAny|array{
     *   type: 'any', disable_parallel_tool_use?: bool|null
     * }|BetaToolChoiceTool|array{
     *   name: string, type: 'tool', disable_parallel_tool_use?: bool|null
     * }|BetaToolChoiceNone|array{type: 'none'} $toolChoice
     */
    public function withToolChoice(
        BetaToolChoiceAuto|array|BetaToolChoiceAny|BetaToolChoiceTool|BetaToolChoiceNone $toolChoice,
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
     * @param list<BetaTool|array{
     *   input_schema: InputSchema,
     *   name: string,
     *   allowed_callers?: list<value-of<AllowedCaller>>|null,
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   defer_loading?: bool|null,
     *   description?: string|null,
     *   input_examples?: list<array<string,mixed>>|null,
     *   strict?: bool|null,
     *   type?: value-of<Type>|null,
     * }|BetaToolBash20241022|array{
     *   name: 'bash',
     *   type: 'bash_20241022',
     *   allowed_callers?: list<value-of<BetaToolBash20241022\AllowedCaller>>|null,
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   defer_loading?: bool|null,
     *   input_examples?: list<array<string,mixed>>|null,
     *   strict?: bool|null,
     * }|BetaToolBash20250124|array{
     *   name: 'bash',
     *   type: 'bash_20250124',
     *   allowed_callers?: list<value-of<BetaToolBash20250124\AllowedCaller>>|null,
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   defer_loading?: bool|null,
     *   input_examples?: list<array<string,mixed>>|null,
     *   strict?: bool|null,
     * }|BetaCodeExecutionTool20250522|array{
     *   name: 'code_execution',
     *   type: 'code_execution_20250522',
     *   allowed_callers?: list<value-of<BetaCodeExecutionTool20250522\AllowedCaller>>|null,
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   defer_loading?: bool|null,
     *   strict?: bool|null,
     * }|BetaCodeExecutionTool20250825|array{
     *   name: 'code_execution',
     *   type: 'code_execution_20250825',
     *   allowed_callers?: list<value-of<BetaCodeExecutionTool20250825\AllowedCaller>>|null,
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   defer_loading?: bool|null,
     *   strict?: bool|null,
     * }|BetaToolComputerUse20241022|array{
     *   display_height_px: int,
     *   display_width_px: int,
     *   name: 'computer',
     *   type: 'computer_20241022',
     *   allowed_callers?: list<value-of<BetaToolComputerUse20241022\AllowedCaller>>|null,
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   defer_loading?: bool|null,
     *   display_number?: int|null,
     *   input_examples?: list<array<string,mixed>>|null,
     *   strict?: bool|null,
     * }|BetaMemoryTool20250818|array{
     *   name: 'memory',
     *   type: 'memory_20250818',
     *   allowed_callers?: list<value-of<BetaMemoryTool20250818\AllowedCaller>>|null,
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   defer_loading?: bool|null,
     *   input_examples?: list<array<string,mixed>>|null,
     *   strict?: bool|null,
     * }|BetaToolComputerUse20250124|array{
     *   display_height_px: int,
     *   display_width_px: int,
     *   name: 'computer',
     *   type: 'computer_20250124',
     *   allowed_callers?: list<value-of<BetaToolComputerUse20250124\AllowedCaller>>|null,
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   defer_loading?: bool|null,
     *   display_number?: int|null,
     *   input_examples?: list<array<string,mixed>>|null,
     *   strict?: bool|null,
     * }|BetaToolTextEditor20241022|array{
     *   name: 'str_replace_editor',
     *   type: 'text_editor_20241022',
     *   allowed_callers?: list<value-of<BetaToolTextEditor20241022\AllowedCaller>>|null,
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   defer_loading?: bool|null,
     *   input_examples?: list<array<string,mixed>>|null,
     *   strict?: bool|null,
     * }|BetaToolComputerUse20251124|array{
     *   display_height_px: int,
     *   display_width_px: int,
     *   name: 'computer',
     *   type: 'computer_20251124',
     *   allowed_callers?: list<value-of<BetaToolComputerUse20251124\AllowedCaller>>|null,
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   defer_loading?: bool|null,
     *   display_number?: int|null,
     *   enable_zoom?: bool|null,
     *   input_examples?: list<array<string,mixed>>|null,
     *   strict?: bool|null,
     * }|BetaToolTextEditor20250124|array{
     *   name: 'str_replace_editor',
     *   type: 'text_editor_20250124',
     *   allowed_callers?: list<value-of<BetaToolTextEditor20250124\AllowedCaller>>|null,
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   defer_loading?: bool|null,
     *   input_examples?: list<array<string,mixed>>|null,
     *   strict?: bool|null,
     * }|BetaToolTextEditor20250429|array{
     *   name: 'str_replace_based_edit_tool',
     *   type: 'text_editor_20250429',
     *   allowed_callers?: list<value-of<BetaToolTextEditor20250429\AllowedCaller>>|null,
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   defer_loading?: bool|null,
     *   input_examples?: list<array<string,mixed>>|null,
     *   strict?: bool|null,
     * }|BetaToolTextEditor20250728|array{
     *   name: 'str_replace_based_edit_tool',
     *   type: 'text_editor_20250728',
     *   allowed_callers?: list<value-of<BetaToolTextEditor20250728\AllowedCaller>>|null,
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   defer_loading?: bool|null,
     *   input_examples?: list<array<string,mixed>>|null,
     *   max_characters?: int|null,
     *   strict?: bool|null,
     * }|BetaWebSearchTool20250305|array{
     *   name: 'web_search',
     *   type: 'web_search_20250305',
     *   allowed_callers?: list<value-of<BetaWebSearchTool20250305\AllowedCaller>>|null,
     *   allowed_domains?: list<string>|null,
     *   blocked_domains?: list<string>|null,
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   defer_loading?: bool|null,
     *   max_uses?: int|null,
     *   strict?: bool|null,
     *   user_location?: UserLocation|null,
     * }|BetaWebFetchTool20250910|array{
     *   name: 'web_fetch',
     *   type: 'web_fetch_20250910',
     *   allowed_callers?: list<value-of<BetaWebFetchTool20250910\AllowedCaller>>|null,
     *   allowed_domains?: list<string>|null,
     *   blocked_domains?: list<string>|null,
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   citations?: BetaCitationsConfigParam|null,
     *   defer_loading?: bool|null,
     *   max_content_tokens?: int|null,
     *   max_uses?: int|null,
     *   strict?: bool|null,
     * }|BetaToolSearchToolBm25_20251119|array{
     *   name: 'tool_search_tool_bm25',
     *   type: value-of<BetaToolSearchToolBm25_20251119\Type>,
     *   allowed_callers?: list<value-of<BetaToolSearchToolBm25_20251119\AllowedCaller>>|null,
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   defer_loading?: bool|null,
     *   strict?: bool|null,
     * }|BetaToolSearchToolRegex20251119|array{
     *   name: 'tool_search_tool_regex',
     *   type: value-of<BetaToolSearchToolRegex20251119\Type>,
     *   allowed_callers?: list<value-of<BetaToolSearchToolRegex20251119\AllowedCaller>>|null,
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   defer_loading?: bool|null,
     *   strict?: bool|null,
     * }|BetaMCPToolset|array{
     *   mcp_server_name: string,
     *   type: 'mcp_toolset',
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   configs?: array<string,BetaMCPToolConfig>|null,
     *   default_config?: BetaMCPToolDefaultConfig|null,
     * }> $tools
     */
    public function withTools(array $tools): self
    {
        $obj = clone $this;
        $obj['tools'] = $tools;

        return $obj;
    }

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @param list<string|AnthropicBeta> $betas
     */
    public function withBetas(array $betas): self
    {
        $obj = clone $this;
        $obj['betas'] = $betas;

        return $obj;
    }
}
