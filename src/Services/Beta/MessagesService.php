<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Messages\BetaContainerParams;
use Anthropic\Beta\Messages\BetaContextManagementConfig;
use Anthropic\Beta\Messages\BetaJSONOutputFormat;
use Anthropic\Beta\Messages\BetaMessage;
use Anthropic\Beta\Messages\BetaMessageParam;
use Anthropic\Beta\Messages\BetaMessageTokensCount;
use Anthropic\Beta\Messages\BetaMetadata;
use Anthropic\Beta\Messages\BetaOutputConfig;
use Anthropic\Beta\Messages\BetaRawContentBlockDeltaEvent;
use Anthropic\Beta\Messages\BetaRawContentBlockStartEvent;
use Anthropic\Beta\Messages\BetaRawContentBlockStopEvent;
use Anthropic\Beta\Messages\BetaRawMessageDeltaEvent;
use Anthropic\Beta\Messages\BetaRawMessageStartEvent;
use Anthropic\Beta\Messages\BetaRawMessageStopEvent;
use Anthropic\Beta\Messages\BetaRequestMCPServerURLDefinition;
use Anthropic\Beta\Messages\BetaThinkingConfigAdaptive;
use Anthropic\Beta\Messages\BetaThinkingConfigDisabled;
use Anthropic\Beta\Messages\BetaThinkingConfigEnabled;
use Anthropic\Beta\Messages\BetaToolChoiceAny;
use Anthropic\Beta\Messages\BetaToolChoiceAuto;
use Anthropic\Beta\Messages\BetaToolChoiceNone;
use Anthropic\Beta\Messages\BetaToolChoiceTool;
use Anthropic\Beta\Messages\MessageCreateParams\ServiceTier;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\Messages\Model;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\MessagesContract;
use Anthropic\Services\Beta\Messages\BatchesService;

/**
 * @phpstan-import-type SystemShape from \Anthropic\Beta\Messages\MessageCountTokensParams\System
 * @phpstan-import-type ToolShape from \Anthropic\Beta\Messages\MessageCountTokensParams\Tool
 * @phpstan-import-type BetaMessageParamShape from \Anthropic\Beta\Messages\BetaMessageParam
 * @phpstan-import-type ContainerShape from \Anthropic\Beta\Messages\MessageCreateParams\Container
 * @phpstan-import-type BetaContextManagementConfigShape from \Anthropic\Beta\Messages\BetaContextManagementConfig
 * @phpstan-import-type BetaRequestMCPServerURLDefinitionShape from \Anthropic\Beta\Messages\BetaRequestMCPServerURLDefinition
 * @phpstan-import-type BetaMetadataShape from \Anthropic\Beta\Messages\BetaMetadata
 * @phpstan-import-type BetaOutputConfigShape from \Anthropic\Beta\Messages\BetaOutputConfig
 * @phpstan-import-type BetaJSONOutputFormatShape from \Anthropic\Beta\Messages\BetaJSONOutputFormat
 * @phpstan-import-type SystemShape from \Anthropic\Beta\Messages\MessageCreateParams\System as SystemShape1
 * @phpstan-import-type BetaThinkingConfigParamShape from \Anthropic\Beta\Messages\BetaThinkingConfigParam
 * @phpstan-import-type BetaToolChoiceShape from \Anthropic\Beta\Messages\BetaToolChoice
 * @phpstan-import-type BetaToolUnionShape from \Anthropic\Beta\Messages\BetaToolUnion
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class MessagesService implements MessagesContract
{
    /**
     * @api
     */
    public MessagesRawService $raw;

    /**
     * @api
     */
    public BatchesService $batches;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new MessagesRawService($client);
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
     * @param int $maxTokens Body param: The maximum number of tokens to generate before stopping.
     *
     * Note that our models may stop _before_ reaching this maximum. This parameter only specifies the absolute maximum number of tokens to generate.
     *
     * Different models have different maximum values for this parameter.  See [models](https://docs.claude.com/en/docs/models-overview) for details.
     * @param list<BetaMessageParam|BetaMessageParamShape> $messages Body param: Input messages.
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
     * @param string|Model|value-of<Model> $model Body param: The model that will complete your prompt.\n\nSee [models](https://docs.anthropic.com/en/docs/models-overview) for additional details and options.
     * @param ContainerShape|null $container body param: Container identifier for reuse across requests
     * @param BetaContextManagementConfig|BetaContextManagementConfigShape|null $contextManagement Body param: Context management configuration.
     *
     * This allows you to control how Claude manages context across multiple requests, such as whether to clear function results or not.
     * @param string|null $inferenceGeo Body param: Specifies the geographic region for inference processing. If not specified, the workspace's `default_inference_geo` is used.
     * @param list<BetaRequestMCPServerURLDefinition|BetaRequestMCPServerURLDefinitionShape> $mcpServers Body param: MCP servers to be utilized in this request
     * @param BetaMetadata|BetaMetadataShape $metadata body param: An object describing metadata about the request
     * @param BetaOutputConfig|BetaOutputConfigShape $outputConfig body param: Configuration options for the model's output, such as the output format
     * @param BetaJSONOutputFormat|BetaJSONOutputFormatShape|null $outputFormat Body param: Deprecated: Use `output_config.format` instead. See [structured outputs](https://platform.claude.com/docs/en/build-with-claude/structured-outputs)
     *
     * A schema to specify Claude's output format in responses. This parameter will be removed in a future release.
     * @param ServiceTier|value-of<ServiceTier> $serviceTier Body param: Determines whether to use priority capacity (if available) or standard capacity for this request.
     *
     * Anthropic offers different levels of service for your API requests. See [service-tiers](https://docs.claude.com/en/api/service-tiers) for details.
     * @param list<string> $stopSequences Body param: Custom text sequences that will cause the model to stop generating.
     *
     * Our models will normally stop when they have naturally completed their turn, which will result in a response `stop_reason` of `"end_turn"`.
     *
     * If you want the model to stop generating when it encounters custom strings of text, you can use the `stop_sequences` parameter. If the model encounters one of the custom sequences, the response `stop_reason` value will be `"stop_sequence"` and the response `stop_sequence` value will contain the matched stop sequence.
     * @param SystemShape1 $system Body param: System prompt.
     *
     * A system prompt is a way of providing context and instructions to Claude, such as specifying a particular goal or role. See our [guide to system prompts](https://docs.claude.com/en/docs/system-prompts).
     * @param float $temperature Body param: Amount of randomness injected into the response.
     *
     * Defaults to `1.0`. Ranges from `0.0` to `1.0`. Use `temperature` closer to `0.0` for analytical / multiple choice, and closer to `1.0` for creative and generative tasks.
     *
     * Note that even with `temperature` of `0.0`, the results will not be fully deterministic.
     * @param BetaThinkingConfigParamShape $thinking Body param: Configuration for enabling Claude's extended thinking.
     *
     * When enabled, responses include `thinking` content blocks showing Claude's thinking process before the final answer. Requires a minimum budget of 1,024 tokens and counts towards your `max_tokens` limit.
     *
     * See [extended thinking](https://docs.claude.com/en/docs/build-with-claude/extended-thinking) for details.
     * @param BetaToolChoiceShape $toolChoice Body param: How the model should use the provided tools. The model can use a specific tool, any available tool, decide by itself, or not use tools at all.
     * @param list<BetaToolUnionShape> $tools Body param: Definitions of tools that the model may use.
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
     * @param int $topK Body param: Only sample from the top K options for each subsequent token.
     *
     * Used to remove "long tail" low probability responses. [Learn more technical details here](https://towardsdatascience.com/how-to-sample-from-language-models-682bceb97277).
     *
     * Recommended for advanced use cases only. You usually only need to use `temperature`.
     * @param float $topP Body param: Use nucleus sampling.
     *
     * In nucleus sampling, we compute the cumulative distribution over all the options for each subsequent token in decreasing probability order and cut it off once it reaches a particular probability specified by `top_p`. You should either alter `temperature` or `top_p`, but not both.
     *
     * Recommended for advanced use cases only. You usually only need to use `temperature`.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        int $maxTokens,
        array $messages,
        Model|string $model,
        string|BetaContainerParams|array|null $container = null,
        BetaContextManagementConfig|array|null $contextManagement = null,
        ?string $inferenceGeo = null,
        ?array $mcpServers = null,
        BetaMetadata|array|null $metadata = null,
        BetaOutputConfig|array|null $outputConfig = null,
        BetaJSONOutputFormat|array|null $outputFormat = null,
        ServiceTier|string|null $serviceTier = null,
        ?array $stopSequences = null,
        string|array|null $system = null,
        ?float $temperature = null,
        BetaThinkingConfigEnabled|array|BetaThinkingConfigDisabled|BetaThinkingConfigAdaptive|null $thinking = null,
        BetaToolChoiceAuto|array|BetaToolChoiceAny|BetaToolChoiceTool|BetaToolChoiceNone|null $toolChoice = null,
        ?array $tools = null,
        ?int $topK = null,
        ?float $topP = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaMessage {
        $params = Util::removeNulls(
            [
                'maxTokens' => $maxTokens,
                'messages' => $messages,
                'model' => $model,
                'container' => $container,
                'contextManagement' => $contextManagement,
                'inferenceGeo' => $inferenceGeo,
                'mcpServers' => $mcpServers,
                'metadata' => $metadata,
                'outputConfig' => $outputConfig,
                'outputFormat' => $outputFormat,
                'serviceTier' => $serviceTier,
                'stopSequences' => $stopSequences,
                'system' => $system,
                'temperature' => $temperature,
                'thinking' => $thinking,
                'toolChoice' => $toolChoice,
                'tools' => $tools,
                'topK' => $topK,
                'topP' => $topP,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * @param int $maxTokens Body param: The maximum number of tokens to generate before stopping.
     *
     * Note that our models may stop _before_ reaching this maximum. This parameter only specifies the absolute maximum number of tokens to generate.
     *
     * Different models have different maximum values for this parameter.  See [models](https://docs.claude.com/en/docs/models-overview) for details.
     * @param list<BetaMessageParam|BetaMessageParamShape> $messages Body param: Input messages.
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
     * @param string|Model|value-of<Model> $model Body param: The model that will complete your prompt.\n\nSee [models](https://docs.anthropic.com/en/docs/models-overview) for additional details and options.
     * @param ContainerShape|null $container body param: Container identifier for reuse across requests
     * @param BetaContextManagementConfig|BetaContextManagementConfigShape|null $contextManagement Body param: Context management configuration.
     *
     * This allows you to control how Claude manages context across multiple requests, such as whether to clear function results or not.
     * @param string|null $inferenceGeo Body param: Specifies the geographic region for inference processing. If not specified, the workspace's `default_inference_geo` is used.
     * @param list<BetaRequestMCPServerURLDefinition|BetaRequestMCPServerURLDefinitionShape> $mcpServers Body param: MCP servers to be utilized in this request
     * @param BetaMetadata|BetaMetadataShape $metadata body param: An object describing metadata about the request
     * @param BetaOutputConfig|BetaOutputConfigShape $outputConfig body param: Configuration options for the model's output, such as the output format
     * @param BetaJSONOutputFormat|BetaJSONOutputFormatShape|null $outputFormat Body param: Deprecated: Use `output_config.format` instead. See [structured outputs](https://platform.claude.com/docs/en/build-with-claude/structured-outputs)
     *
     * A schema to specify Claude's output format in responses. This parameter will be removed in a future release.
     * @param ServiceTier|value-of<ServiceTier> $serviceTier Body param: Determines whether to use priority capacity (if available) or standard capacity for this request.
     *
     * Anthropic offers different levels of service for your API requests. See [service-tiers](https://docs.claude.com/en/api/service-tiers) for details.
     * @param list<string> $stopSequences Body param: Custom text sequences that will cause the model to stop generating.
     *
     * Our models will normally stop when they have naturally completed their turn, which will result in a response `stop_reason` of `"end_turn"`.
     *
     * If you want the model to stop generating when it encounters custom strings of text, you can use the `stop_sequences` parameter. If the model encounters one of the custom sequences, the response `stop_reason` value will be `"stop_sequence"` and the response `stop_sequence` value will contain the matched stop sequence.
     * @param SystemShape1 $system Body param: System prompt.
     *
     * A system prompt is a way of providing context and instructions to Claude, such as specifying a particular goal or role. See our [guide to system prompts](https://docs.claude.com/en/docs/system-prompts).
     * @param float $temperature Body param: Amount of randomness injected into the response.
     *
     * Defaults to `1.0`. Ranges from `0.0` to `1.0`. Use `temperature` closer to `0.0` for analytical / multiple choice, and closer to `1.0` for creative and generative tasks.
     *
     * Note that even with `temperature` of `0.0`, the results will not be fully deterministic.
     * @param BetaThinkingConfigParamShape $thinking Body param: Configuration for enabling Claude's extended thinking.
     *
     * When enabled, responses include `thinking` content blocks showing Claude's thinking process before the final answer. Requires a minimum budget of 1,024 tokens and counts towards your `max_tokens` limit.
     *
     * See [extended thinking](https://docs.claude.com/en/docs/build-with-claude/extended-thinking) for details.
     * @param BetaToolChoiceShape $toolChoice Body param: How the model should use the provided tools. The model can use a specific tool, any available tool, decide by itself, or not use tools at all.
     * @param list<BetaToolUnionShape> $tools Body param: Definitions of tools that the model may use.
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
     * @param int $topK Body param: Only sample from the top K options for each subsequent token.
     *
     * Used to remove "long tail" low probability responses. [Learn more technical details here](https://towardsdatascience.com/how-to-sample-from-language-models-682bceb97277).
     *
     * Recommended for advanced use cases only. You usually only need to use `temperature`.
     * @param float $topP Body param: Use nucleus sampling.
     *
     * In nucleus sampling, we compute the cumulative distribution over all the options for each subsequent token in decreasing probability order and cut it off once it reaches a particular probability specified by `top_p`. You should either alter `temperature` or `top_p`, but not both.
     *
     * Recommended for advanced use cases only. You usually only need to use `temperature`.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseStream<BetaRawMessageStartEvent|BetaRawMessageDeltaEvent|BetaRawMessageStopEvent|BetaRawContentBlockStartEvent|BetaRawContentBlockDeltaEvent|BetaRawContentBlockStopEvent,>
     *
     * @throws APIException
     */
    public function createStream(
        int $maxTokens,
        array $messages,
        Model|string $model,
        string|BetaContainerParams|array|null $container = null,
        BetaContextManagementConfig|array|null $contextManagement = null,
        ?string $inferenceGeo = null,
        ?array $mcpServers = null,
        BetaMetadata|array|null $metadata = null,
        BetaOutputConfig|array|null $outputConfig = null,
        BetaJSONOutputFormat|array|null $outputFormat = null,
        ServiceTier|string|null $serviceTier = null,
        ?array $stopSequences = null,
        string|array|null $system = null,
        ?float $temperature = null,
        BetaThinkingConfigEnabled|array|BetaThinkingConfigDisabled|BetaThinkingConfigAdaptive|null $thinking = null,
        BetaToolChoiceAuto|array|BetaToolChoiceAny|BetaToolChoiceTool|BetaToolChoiceNone|null $toolChoice = null,
        ?array $tools = null,
        ?int $topK = null,
        ?float $topP = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BaseStream {
        $params = Util::removeNulls(
            [
                'maxTokens' => $maxTokens,
                'messages' => $messages,
                'model' => $model,
                'container' => $container,
                'contextManagement' => $contextManagement,
                'inferenceGeo' => $inferenceGeo,
                'mcpServers' => $mcpServers,
                'metadata' => $metadata,
                'outputConfig' => $outputConfig,
                'outputFormat' => $outputFormat,
                'serviceTier' => $serviceTier,
                'stopSequences' => $stopSequences,
                'system' => $system,
                'temperature' => $temperature,
                'thinking' => $thinking,
                'toolChoice' => $toolChoice,
                'tools' => $tools,
                'topK' => $topK,
                'topP' => $topP,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->createStream(params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
     * @param list<BetaMessageParam|BetaMessageParamShape> $messages Body param: Input messages.
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
     * @param string|Model|value-of<Model> $model Body param: The model that will complete your prompt.\n\nSee [models](https://docs.anthropic.com/en/docs/models-overview) for additional details and options.
     * @param BetaContextManagementConfig|BetaContextManagementConfigShape|null $contextManagement Body param: Context management configuration.
     *
     * This allows you to control how Claude manages context across multiple requests, such as whether to clear function results or not.
     * @param list<BetaRequestMCPServerURLDefinition|BetaRequestMCPServerURLDefinitionShape> $mcpServers Body param: MCP servers to be utilized in this request
     * @param BetaOutputConfig|BetaOutputConfigShape $outputConfig body param: Configuration options for the model's output, such as the output format
     * @param BetaJSONOutputFormat|BetaJSONOutputFormatShape|null $outputFormat Body param: Deprecated: Use `output_config.format` instead. See [structured outputs](https://platform.claude.com/docs/en/build-with-claude/structured-outputs)
     *
     * A schema to specify Claude's output format in responses. This parameter will be removed in a future release.
     * @param SystemShape $system Body param: System prompt.
     *
     * A system prompt is a way of providing context and instructions to Claude, such as specifying a particular goal or role. See our [guide to system prompts](https://docs.claude.com/en/docs/system-prompts).
     * @param BetaThinkingConfigParamShape $thinking Body param: Configuration for enabling Claude's extended thinking.
     *
     * When enabled, responses include `thinking` content blocks showing Claude's thinking process before the final answer. Requires a minimum budget of 1,024 tokens and counts towards your `max_tokens` limit.
     *
     * See [extended thinking](https://docs.claude.com/en/docs/build-with-claude/extended-thinking) for details.
     * @param BetaToolChoiceShape $toolChoice Body param: How the model should use the provided tools. The model can use a specific tool, any available tool, decide by itself, or not use tools at all.
     * @param list<ToolShape> $tools Body param: Definitions of tools that the model may use.
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
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function countTokens(
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
        RequestOptions|array|null $requestOptions = null,
    ): BetaMessageTokensCount {
        $params = Util::removeNulls(
            [
                'messages' => $messages,
                'model' => $model,
                'contextManagement' => $contextManagement,
                'mcpServers' => $mcpServers,
                'outputConfig' => $outputConfig,
                'outputFormat' => $outputFormat,
                'system' => $system,
                'thinking' => $thinking,
                'toolChoice' => $toolChoice,
                'tools' => $tools,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->countTokens(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
