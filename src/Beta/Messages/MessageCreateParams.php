<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Messages\MessageCreateParams\ServiceTier;
use Anthropic\Beta\Messages\MessageCreateParams\System;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\Model;

/**
 * Send a structured list of input messages with text and/or image content, and the model will generate the next message in the conversation.
 *
 * The Messages API can be used for either single queries or stateless multi-turn conversations.
 *
 * Learn more about the Messages API in our [user guide](https://docs.claude.com/en/docs/initial-setup)
 *
 * @see Anthropic\Services\Beta\MessagesService::create()
 *
 * @phpstan-import-type BetaMessageParamShape from \Anthropic\Beta\Messages\BetaMessageParam
 * @phpstan-import-type ContainerShape from \Anthropic\Beta\Messages\MessageCreateParams\Container
 * @phpstan-import-type BetaContextManagementConfigShape from \Anthropic\Beta\Messages\BetaContextManagementConfig
 * @phpstan-import-type BetaRequestMCPServerURLDefinitionShape from \Anthropic\Beta\Messages\BetaRequestMCPServerURLDefinition
 * @phpstan-import-type BetaMetadataShape from \Anthropic\Beta\Messages\BetaMetadata
 * @phpstan-import-type BetaOutputConfigShape from \Anthropic\Beta\Messages\BetaOutputConfig
 * @phpstan-import-type BetaJSONOutputFormatShape from \Anthropic\Beta\Messages\BetaJSONOutputFormat
 * @phpstan-import-type SystemShape from \Anthropic\Beta\Messages\MessageCreateParams\System
 * @phpstan-import-type BetaThinkingConfigParamShape from \Anthropic\Beta\Messages\BetaThinkingConfigParam
 * @phpstan-import-type BetaToolChoiceShape from \Anthropic\Beta\Messages\BetaToolChoice
 * @phpstan-import-type BetaToolUnionShape from \Anthropic\Beta\Messages\BetaToolUnion
 *
 * @phpstan-type MessageCreateParamsShape = array{
 *   maxTokens: int,
 *   messages: list<BetaMessageParamShape>,
 *   model: Model|value-of<Model>,
 *   container?: ContainerShape|null,
 *   contextManagement?: BetaContextManagementConfigShape|null,
 *   mcpServers?: list<BetaRequestMCPServerURLDefinitionShape>|null,
 *   metadata?: BetaMetadataShape|null,
 *   outputConfig?: BetaOutputConfigShape|null,
 *   outputFormat?: BetaJSONOutputFormatShape|null,
 *   serviceTier?: null|ServiceTier|value-of<ServiceTier>,
 *   stopSequences?: list<string>|null,
 *   system?: SystemShape|null,
 *   temperature?: float|null,
 *   thinking?: BetaThinkingConfigParamShape|null,
 *   toolChoice?: BetaToolChoiceShape|null,
 *   tools?: list<BetaToolUnionShape>|null,
 *   topK?: int|null,
 *   topP?: float|null,
 *   betas?: list<AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class MessageCreateParams implements BaseModel
{
    /** @use SdkModel<MessageCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * The maximum number of tokens to generate before stopping.
     *
     * Note that our models may stop _before_ reaching this maximum. This parameter only specifies the absolute maximum number of tokens to generate.
     *
     * Different models have different maximum values for this parameter.  See [models](https://docs.claude.com/en/docs/models-overview) for details.
     */
    #[Required('max_tokens')]
    public int $maxTokens;

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
     * @var value-of<Model> $model
     */
    #[Required(enum: Model::class)]
    public string $model;

    /**
     * Container identifier for reuse across requests.
     */
    #[Optional(nullable: true)]
    public string|BetaContainerParams|null $container;

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
     * An object describing metadata about the request.
     */
    #[Optional]
    public ?BetaMetadata $metadata;

    /**
     * Configuration options for the model's output. Controls aspects like how much effort the model puts into its response.
     */
    #[Optional('output_config')]
    public ?BetaOutputConfig $outputConfig;

    /**
     * A schema to specify Claude's output format in responses.
     */
    #[Optional('output_format', nullable: true)]
    public ?BetaJSONOutputFormat $outputFormat;

    /**
     * Determines whether to use priority capacity (if available) or standard capacity for this request.
     *
     * Anthropic offers different levels of service for your API requests. See [service-tiers](https://docs.claude.com/en/api/service-tiers) for details.
     *
     * @var value-of<ServiceTier>|null $serviceTier
     */
    #[Optional('service_tier', enum: ServiceTier::class)]
    public ?string $serviceTier;

    /**
     * Custom text sequences that will cause the model to stop generating.
     *
     * Our models will normally stop when they have naturally completed their turn, which will result in a response `stop_reason` of `"end_turn"`.
     *
     * If you want the model to stop generating when it encounters custom strings of text, you can use the `stop_sequences` parameter. If the model encounters one of the custom sequences, the response `stop_reason` value will be `"stop_sequence"` and the response `stop_sequence` value will contain the matched stop sequence.
     *
     * @var list<string>|null $stopSequences
     */
    #[Optional('stop_sequences', list: 'string')]
    public ?array $stopSequences;

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
     * Amount of randomness injected into the response.
     *
     * Defaults to `1.0`. Ranges from `0.0` to `1.0`. Use `temperature` closer to `0.0` for analytical / multiple choice, and closer to `1.0` for creative and generative tasks.
     *
     * Note that even with `temperature` of `0.0`, the results will not be fully deterministic.
     */
    #[Optional]
    public ?float $temperature;

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
     * @var list<BetaTool|BetaToolBash20241022|BetaToolBash20250124|BetaCodeExecutionTool20250522|BetaCodeExecutionTool20250825|BetaToolComputerUse20241022|BetaMemoryTool20250818|BetaToolComputerUse20250124|BetaToolTextEditor20241022|BetaToolComputerUse20251124|BetaToolTextEditor20250124|BetaToolTextEditor20250429|BetaToolTextEditor20250728|BetaWebSearchTool20250305|BetaWebFetchTool20250910|BetaToolSearchToolBm25_20251119|BetaToolSearchToolRegex20251119|BetaMCPToolset>|null $tools
     */
    #[Optional(list: BetaToolUnion::class)]
    public ?array $tools;

    /**
     * Only sample from the top K options for each subsequent token.
     *
     * Used to remove "long tail" low probability responses. [Learn more technical details here](https://towardsdatascience.com/how-to-sample-from-language-models-682bceb97277).
     *
     * Recommended for advanced use cases only. You usually only need to use `temperature`.
     */
    #[Optional('top_k')]
    public ?int $topK;

    /**
     * Use nucleus sampling.
     *
     * In nucleus sampling, we compute the cumulative distribution over all the options for each subsequent token in decreasing probability order and cut it off once it reaches a particular probability specified by `top_p`. You should either alter `temperature` or `top_p`, but not both.
     *
     * Recommended for advanced use cases only. You usually only need to use `temperature`.
     */
    #[Optional('top_p')]
    public ?float $topP;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new MessageCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MessageCreateParams::with(maxTokens: ..., messages: ..., model: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MessageCreateParams)->withMaxTokens(...)->withMessages(...)->withModel(...)
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
     * @param list<BetaMessageParamShape> $messages
     * @param Model|value-of<Model> $model
     * @param ContainerShape|null $container
     * @param BetaContextManagementConfigShape|null $contextManagement
     * @param list<BetaRequestMCPServerURLDefinitionShape> $mcpServers
     * @param BetaMetadataShape $metadata
     * @param BetaOutputConfigShape $outputConfig
     * @param BetaJSONOutputFormatShape|null $outputFormat
     * @param ServiceTier|value-of<ServiceTier> $serviceTier
     * @param list<string> $stopSequences
     * @param SystemShape $system
     * @param BetaThinkingConfigParamShape $thinking
     * @param BetaToolChoiceShape $toolChoice
     * @param list<BetaToolUnionShape> $tools
     * @param list<AnthropicBeta|value-of<AnthropicBeta>> $betas
     */
    public static function with(
        int $maxTokens,
        array $messages,
        Model|string $model,
        string|BetaContainerParams|array|null $container = null,
        BetaContextManagementConfig|array|null $contextManagement = null,
        ?array $mcpServers = null,
        BetaMetadata|array|null $metadata = null,
        BetaOutputConfig|array|null $outputConfig = null,
        BetaJSONOutputFormat|array|null $outputFormat = null,
        ServiceTier|string|null $serviceTier = null,
        ?array $stopSequences = null,
        string|array|null $system = null,
        ?float $temperature = null,
        BetaThinkingConfigEnabled|array|BetaThinkingConfigDisabled|null $thinking = null,
        BetaToolChoiceAuto|array|BetaToolChoiceAny|BetaToolChoiceTool|BetaToolChoiceNone|null $toolChoice = null,
        ?array $tools = null,
        ?int $topK = null,
        ?float $topP = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        $self['maxTokens'] = $maxTokens;
        $self['messages'] = $messages;
        $self['model'] = $model;

        null !== $container && $self['container'] = $container;
        null !== $contextManagement && $self['contextManagement'] = $contextManagement;
        null !== $mcpServers && $self['mcpServers'] = $mcpServers;
        null !== $metadata && $self['metadata'] = $metadata;
        null !== $outputConfig && $self['outputConfig'] = $outputConfig;
        null !== $outputFormat && $self['outputFormat'] = $outputFormat;
        null !== $serviceTier && $self['serviceTier'] = $serviceTier;
        null !== $stopSequences && $self['stopSequences'] = $stopSequences;
        null !== $system && $self['system'] = $system;
        null !== $temperature && $self['temperature'] = $temperature;
        null !== $thinking && $self['thinking'] = $thinking;
        null !== $toolChoice && $self['toolChoice'] = $toolChoice;
        null !== $tools && $self['tools'] = $tools;
        null !== $topK && $self['topK'] = $topK;
        null !== $topP && $self['topP'] = $topP;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * The maximum number of tokens to generate before stopping.
     *
     * Note that our models may stop _before_ reaching this maximum. This parameter only specifies the absolute maximum number of tokens to generate.
     *
     * Different models have different maximum values for this parameter.  See [models](https://docs.claude.com/en/docs/models-overview) for details.
     */
    public function withMaxTokens(int $maxTokens): self
    {
        $self = clone $this;
        $self['maxTokens'] = $maxTokens;

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
     * @param list<BetaMessageParamShape> $messages
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
     * @param Model|value-of<Model> $model
     */
    public function withModel(Model|string $model): self
    {
        $self = clone $this;
        $self['model'] = $model;

        return $self;
    }

    /**
     * Container identifier for reuse across requests.
     *
     * @param ContainerShape|null $container
     */
    public function withContainer(
        string|BetaContainerParams|array|null $container
    ): self {
        $self = clone $this;
        $self['container'] = $container;

        return $self;
    }

    /**
     * Context management configuration.
     *
     * This allows you to control how Claude manages context across multiple requests, such as whether to clear function results or not.
     *
     * @param BetaContextManagementConfigShape|null $contextManagement
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
     * @param list<BetaRequestMCPServerURLDefinitionShape> $mcpServers
     */
    public function withMCPServers(array $mcpServers): self
    {
        $self = clone $this;
        $self['mcpServers'] = $mcpServers;

        return $self;
    }

    /**
     * An object describing metadata about the request.
     *
     * @param BetaMetadataShape $metadata
     */
    public function withMetadata(BetaMetadata|array $metadata): self
    {
        $self = clone $this;
        $self['metadata'] = $metadata;

        return $self;
    }

    /**
     * Configuration options for the model's output. Controls aspects like how much effort the model puts into its response.
     *
     * @param BetaOutputConfigShape $outputConfig
     */
    public function withOutputConfig(BetaOutputConfig|array $outputConfig): self
    {
        $self = clone $this;
        $self['outputConfig'] = $outputConfig;

        return $self;
    }

    /**
     * A schema to specify Claude's output format in responses.
     *
     * @param BetaJSONOutputFormatShape|null $outputFormat
     */
    public function withOutputFormat(
        BetaJSONOutputFormat|array|null $outputFormat
    ): self {
        $self = clone $this;
        $self['outputFormat'] = $outputFormat;

        return $self;
    }

    /**
     * Determines whether to use priority capacity (if available) or standard capacity for this request.
     *
     * Anthropic offers different levels of service for your API requests. See [service-tiers](https://docs.claude.com/en/api/service-tiers) for details.
     *
     * @param ServiceTier|value-of<ServiceTier> $serviceTier
     */
    public function withServiceTier(ServiceTier|string $serviceTier): self
    {
        $self = clone $this;
        $self['serviceTier'] = $serviceTier;

        return $self;
    }

    /**
     * Custom text sequences that will cause the model to stop generating.
     *
     * Our models will normally stop when they have naturally completed their turn, which will result in a response `stop_reason` of `"end_turn"`.
     *
     * If you want the model to stop generating when it encounters custom strings of text, you can use the `stop_sequences` parameter. If the model encounters one of the custom sequences, the response `stop_reason` value will be `"stop_sequence"` and the response `stop_sequence` value will contain the matched stop sequence.
     *
     * @param list<string> $stopSequences
     */
    public function withStopSequences(array $stopSequences): self
    {
        $self = clone $this;
        $self['stopSequences'] = $stopSequences;

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
     * Amount of randomness injected into the response.
     *
     * Defaults to `1.0`. Ranges from `0.0` to `1.0`. Use `temperature` closer to `0.0` for analytical / multiple choice, and closer to `1.0` for creative and generative tasks.
     *
     * Note that even with `temperature` of `0.0`, the results will not be fully deterministic.
     */
    public function withTemperature(float $temperature): self
    {
        $self = clone $this;
        $self['temperature'] = $temperature;

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
        BetaThinkingConfigEnabled|array|BetaThinkingConfigDisabled $thinking
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
     * @param list<BetaToolUnionShape> $tools
     */
    public function withTools(array $tools): self
    {
        $self = clone $this;
        $self['tools'] = $tools;

        return $self;
    }

    /**
     * Only sample from the top K options for each subsequent token.
     *
     * Used to remove "long tail" low probability responses. [Learn more technical details here](https://towardsdatascience.com/how-to-sample-from-language-models-682bceb97277).
     *
     * Recommended for advanced use cases only. You usually only need to use `temperature`.
     */
    public function withTopK(int $topK): self
    {
        $self = clone $this;
        $self['topK'] = $topK;

        return $self;
    }

    /**
     * Use nucleus sampling.
     *
     * In nucleus sampling, we compute the cumulative distribution over all the options for each subsequent token in decreasing probability order and cut it off once it reaches a particular probability specified by `top_p`. You should either alter `temperature` or `top_p`, but not both.
     *
     * Recommended for advanced use cases only. You usually only need to use `temperature`.
     */
    public function withTopP(float $topP): self
    {
        $self = clone $this;
        $self['topP'] = $topP;

        return $self;
    }

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @param list<AnthropicBeta|value-of<AnthropicBeta>> $betas
     */
    public function withBetas(array $betas): self
    {
        $self = clone $this;
        $self['betas'] = $betas;

        return $self;
    }
}
