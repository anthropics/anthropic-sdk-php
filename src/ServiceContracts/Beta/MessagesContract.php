<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Messages\BetaCacheControlEphemeral\TTL;
use Anthropic\Beta\Messages\BetaMessage;
use Anthropic\Beta\Messages\BetaMessageParam\Role;
use Anthropic\Beta\Messages\BetaMessageTokensCount;
use Anthropic\Beta\Messages\BetaOutputConfig\Effort;
use Anthropic\Beta\Messages\BetaRawContentBlockDeltaEvent;
use Anthropic\Beta\Messages\BetaRawContentBlockStartEvent;
use Anthropic\Beta\Messages\BetaRawContentBlockStopEvent;
use Anthropic\Beta\Messages\BetaRawMessageDeltaEvent;
use Anthropic\Beta\Messages\BetaRawMessageStartEvent;
use Anthropic\Beta\Messages\BetaRawMessageStopEvent;
use Anthropic\Beta\Messages\BetaSkillParams\Type;
use Anthropic\Beta\Messages\MessageCreateParams\ServiceTier;
use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Messages\Model;
use Anthropic\RequestOptions;

interface MessagesContract
{
    /**
     * @api
     *
     * @param int $maxTokens Body param: The maximum number of tokens to generate before stopping.
     *
     * Note that our models may stop _before_ reaching this maximum. This parameter only specifies the absolute maximum number of tokens to generate.
     *
     * Different models have different maximum values for this parameter.  See [models](https://docs.claude.com/en/docs/models-overview) for details.
     * @param list<array{
     *   content: string|list<array<string,mixed>>, role: 'user'|'assistant'|Role
     * }> $messages Body param: Input messages.
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
     * @param string|'claude-opus-4-5-20251101'|'claude-opus-4-5'|'claude-3-7-sonnet-latest'|'claude-3-7-sonnet-20250219'|'claude-3-5-haiku-latest'|'claude-3-5-haiku-20241022'|'claude-haiku-4-5'|'claude-haiku-4-5-20251001'|'claude-sonnet-4-20250514'|'claude-sonnet-4-0'|'claude-4-sonnet-20250514'|'claude-sonnet-4-5'|'claude-sonnet-4-5-20250929'|'claude-opus-4-0'|'claude-opus-4-20250514'|'claude-4-opus-20250514'|'claude-opus-4-1-20250805'|'claude-3-opus-latest'|'claude-3-opus-20240229'|'claude-3-haiku-20240307'|Model $model Body param: The model that will complete your prompt.\n\nSee [models](https://docs.anthropic.com/en/docs/models-overview) for additional details and options.
     * @param string|array{
     *   id?: string|null,
     *   skills?: list<array{
     *     skillID: string, type: 'anthropic'|'custom'|Type, version?: string
     *   }>|null,
     * }|null $container Body param: Container identifier for reuse across requests
     * @param array{
     *   edits?: list<array<string,mixed>>
     * }|null $contextManagement Body param: Context management configuration.
     *
     * This allows you to control how Claude manages context across multiple requests, such as whether to clear function results or not.
     * @param list<array{
     *   name: string,
     *   type?: 'url',
     *   url: string,
     *   authorizationToken?: string|null,
     *   toolConfiguration?: array{
     *     allowedTools?: list<string>|null, enabled?: bool|null
     *   }|null,
     * }> $mcpServers Body param: MCP servers to be utilized in this request
     * @param array{
     *   userID?: string|null
     * } $metadata Body param: An object describing metadata about the request
     * @param array{
     *   effort?: 'low'|'medium'|'high'|Effort|null
     * } $outputConfig Body param: Configuration options for the model's output. Controls aspects like how much effort the model puts into its response.
     * @param array{
     *   schema: array<string,mixed>, type?: 'json_schema'
     * }|null $outputFormat Body param:
     * A schema to specify Claude's output format in responses
     * @param 'auto'|'standard_only'|ServiceTier $serviceTier Body param: Determines whether to use priority capacity (if available) or standard capacity for this request.
     *
     * Anthropic offers different levels of service for your API requests. See [service-tiers](https://docs.claude.com/en/api/service-tiers) for details.
     * @param list<string> $stopSequences Body param: Custom text sequences that will cause the model to stop generating.
     *
     * Our models will normally stop when they have naturally completed their turn, which will result in a response `stop_reason` of `"end_turn"`.
     *
     * If you want the model to stop generating when it encounters custom strings of text, you can use the `stop_sequences` parameter. If the model encounters one of the custom sequences, the response `stop_reason` value will be `"stop_sequence"` and the response `stop_sequence` value will contain the matched stop sequence.
     * @param string|list<array{
     *   text: string,
     *   type?: 'text',
     *   cacheControl?: array{type?: 'ephemeral', ttl?: '5m'|'1h'|TTL}|null,
     *   citations?: list<array<string,mixed>>|null,
     * }> $system Body param: System prompt.
     *
     * A system prompt is a way of providing context and instructions to Claude, such as specifying a particular goal or role. See our [guide to system prompts](https://docs.claude.com/en/docs/system-prompts).
     * @param float $temperature Body param: Amount of randomness injected into the response.
     *
     * Defaults to `1.0`. Ranges from `0.0` to `1.0`. Use `temperature` closer to `0.0` for analytical / multiple choice, and closer to `1.0` for creative and generative tasks.
     *
     * Note that even with `temperature` of `0.0`, the results will not be fully deterministic.
     * @param array<string,mixed> $thinking Body param: Configuration for enabling Claude's extended thinking.
     *
     * When enabled, responses include `thinking` content blocks showing Claude's thinking process before the final answer. Requires a minimum budget of 1,024 tokens and counts towards your `max_tokens` limit.
     *
     * See [extended thinking](https://docs.claude.com/en/docs/build-with-claude/extended-thinking) for details.
     * @param array<string,mixed> $toolChoice Body param: How the model should use the provided tools. The model can use a specific tool, any available tool, decide by itself, or not use tools at all.
     * @param list<array<string,mixed>> $tools Body param: Definitions of tools that the model may use.
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
     * @param list<string|'message-batches-2024-09-24'|'prompt-caching-2024-07-31'|'computer-use-2024-10-22'|'computer-use-2025-01-24'|'pdfs-2024-09-25'|'token-counting-2024-11-01'|'token-efficient-tools-2025-02-19'|'output-128k-2025-02-19'|'files-api-2025-04-14'|'mcp-client-2025-04-04'|'mcp-client-2025-11-20'|'dev-full-thinking-2025-05-14'|'interleaved-thinking-2025-05-14'|'code-execution-2025-05-22'|'extended-cache-ttl-2025-04-11'|'context-1m-2025-08-07'|'context-management-2025-06-27'|'model-context-window-exceeded-2025-08-26'|'skills-2025-10-02'|AnthropicBeta> $betas header param: Optional header to specify the beta version(s) you want to use
     *
     * @throws APIException
     */
    public function create(
        int $maxTokens,
        array $messages,
        string|Model $model,
        string|array|null $container = null,
        ?array $contextManagement = null,
        ?array $mcpServers = null,
        ?array $metadata = null,
        ?array $outputConfig = null,
        ?array $outputFormat = null,
        string|ServiceTier|null $serviceTier = null,
        ?array $stopSequences = null,
        string|array|null $system = null,
        ?float $temperature = null,
        ?array $thinking = null,
        ?array $toolChoice = null,
        ?array $tools = null,
        ?int $topK = null,
        ?float $topP = null,
        ?array $betas = null,
        ?RequestOptions $requestOptions = null,
    ): BetaMessage;

    /**
     * @api
     *
     * @param int $maxTokens Body param: The maximum number of tokens to generate before stopping.
     *
     * Note that our models may stop _before_ reaching this maximum. This parameter only specifies the absolute maximum number of tokens to generate.
     *
     * Different models have different maximum values for this parameter.  See [models](https://docs.claude.com/en/docs/models-overview) for details.
     * @param list<array{
     *   content: string|list<array<string,mixed>>, role: 'user'|'assistant'|Role
     * }> $messages Body param: Input messages.
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
     * @param string|'claude-opus-4-5-20251101'|'claude-opus-4-5'|'claude-3-7-sonnet-latest'|'claude-3-7-sonnet-20250219'|'claude-3-5-haiku-latest'|'claude-3-5-haiku-20241022'|'claude-haiku-4-5'|'claude-haiku-4-5-20251001'|'claude-sonnet-4-20250514'|'claude-sonnet-4-0'|'claude-4-sonnet-20250514'|'claude-sonnet-4-5'|'claude-sonnet-4-5-20250929'|'claude-opus-4-0'|'claude-opus-4-20250514'|'claude-4-opus-20250514'|'claude-opus-4-1-20250805'|'claude-3-opus-latest'|'claude-3-opus-20240229'|'claude-3-haiku-20240307'|Model $model Body param: The model that will complete your prompt.\n\nSee [models](https://docs.anthropic.com/en/docs/models-overview) for additional details and options.
     * @param string|array{
     *   id?: string|null,
     *   skills?: list<array{
     *     skillID: string, type: 'anthropic'|'custom'|Type, version?: string
     *   }>|null,
     * }|null $container Body param: Container identifier for reuse across requests
     * @param array{
     *   edits?: list<array<string,mixed>>
     * }|null $contextManagement Body param: Context management configuration.
     *
     * This allows you to control how Claude manages context across multiple requests, such as whether to clear function results or not.
     * @param list<array{
     *   name: string,
     *   type?: 'url',
     *   url: string,
     *   authorizationToken?: string|null,
     *   toolConfiguration?: array{
     *     allowedTools?: list<string>|null, enabled?: bool|null
     *   }|null,
     * }> $mcpServers Body param: MCP servers to be utilized in this request
     * @param array{
     *   userID?: string|null
     * } $metadata Body param: An object describing metadata about the request
     * @param array{
     *   effort?: 'low'|'medium'|'high'|Effort|null
     * } $outputConfig Body param: Configuration options for the model's output. Controls aspects like how much effort the model puts into its response.
     * @param array{
     *   schema: array<string,mixed>, type?: 'json_schema'
     * }|null $outputFormat Body param:
     * A schema to specify Claude's output format in responses
     * @param 'auto'|'standard_only'|ServiceTier $serviceTier Body param: Determines whether to use priority capacity (if available) or standard capacity for this request.
     *
     * Anthropic offers different levels of service for your API requests. See [service-tiers](https://docs.claude.com/en/api/service-tiers) for details.
     * @param list<string> $stopSequences Body param: Custom text sequences that will cause the model to stop generating.
     *
     * Our models will normally stop when they have naturally completed their turn, which will result in a response `stop_reason` of `"end_turn"`.
     *
     * If you want the model to stop generating when it encounters custom strings of text, you can use the `stop_sequences` parameter. If the model encounters one of the custom sequences, the response `stop_reason` value will be `"stop_sequence"` and the response `stop_sequence` value will contain the matched stop sequence.
     * @param string|list<array{
     *   text: string,
     *   type?: 'text',
     *   cacheControl?: array{type?: 'ephemeral', ttl?: '5m'|'1h'|TTL}|null,
     *   citations?: list<array<string,mixed>>|null,
     * }> $system Body param: System prompt.
     *
     * A system prompt is a way of providing context and instructions to Claude, such as specifying a particular goal or role. See our [guide to system prompts](https://docs.claude.com/en/docs/system-prompts).
     * @param float $temperature Body param: Amount of randomness injected into the response.
     *
     * Defaults to `1.0`. Ranges from `0.0` to `1.0`. Use `temperature` closer to `0.0` for analytical / multiple choice, and closer to `1.0` for creative and generative tasks.
     *
     * Note that even with `temperature` of `0.0`, the results will not be fully deterministic.
     * @param array<string,mixed> $thinking Body param: Configuration for enabling Claude's extended thinking.
     *
     * When enabled, responses include `thinking` content blocks showing Claude's thinking process before the final answer. Requires a minimum budget of 1,024 tokens and counts towards your `max_tokens` limit.
     *
     * See [extended thinking](https://docs.claude.com/en/docs/build-with-claude/extended-thinking) for details.
     * @param array<string,mixed> $toolChoice Body param: How the model should use the provided tools. The model can use a specific tool, any available tool, decide by itself, or not use tools at all.
     * @param list<array<string,mixed>> $tools Body param: Definitions of tools that the model may use.
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
     * @param list<string|'message-batches-2024-09-24'|'prompt-caching-2024-07-31'|'computer-use-2024-10-22'|'computer-use-2025-01-24'|'pdfs-2024-09-25'|'token-counting-2024-11-01'|'token-efficient-tools-2025-02-19'|'output-128k-2025-02-19'|'files-api-2025-04-14'|'mcp-client-2025-04-04'|'mcp-client-2025-11-20'|'dev-full-thinking-2025-05-14'|'interleaved-thinking-2025-05-14'|'code-execution-2025-05-22'|'extended-cache-ttl-2025-04-11'|'context-1m-2025-08-07'|'context-management-2025-06-27'|'model-context-window-exceeded-2025-08-26'|'skills-2025-10-02'|AnthropicBeta> $betas header param: Optional header to specify the beta version(s) you want to use
     *
     * @return BaseStream<BetaRawMessageStartEvent|BetaRawMessageDeltaEvent|BetaRawMessageStopEvent|BetaRawContentBlockStartEvent|BetaRawContentBlockDeltaEvent|BetaRawContentBlockStopEvent,>
     *
     * @throws APIException
     */
    public function createStream(
        int $maxTokens,
        array $messages,
        string|Model $model,
        string|array|null $container = null,
        ?array $contextManagement = null,
        ?array $mcpServers = null,
        ?array $metadata = null,
        ?array $outputConfig = null,
        ?array $outputFormat = null,
        string|ServiceTier|null $serviceTier = null,
        ?array $stopSequences = null,
        string|array|null $system = null,
        ?float $temperature = null,
        ?array $thinking = null,
        ?array $toolChoice = null,
        ?array $tools = null,
        ?int $topK = null,
        ?float $topP = null,
        ?array $betas = null,
        ?RequestOptions $requestOptions = null,
    ): BaseStream;

    /**
     * @api
     *
     * @param list<array{
     *   content: string|list<array<string,mixed>>, role: 'user'|'assistant'|Role
     * }> $messages Body param: Input messages.
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
     * @param string|'claude-opus-4-5-20251101'|'claude-opus-4-5'|'claude-3-7-sonnet-latest'|'claude-3-7-sonnet-20250219'|'claude-3-5-haiku-latest'|'claude-3-5-haiku-20241022'|'claude-haiku-4-5'|'claude-haiku-4-5-20251001'|'claude-sonnet-4-20250514'|'claude-sonnet-4-0'|'claude-4-sonnet-20250514'|'claude-sonnet-4-5'|'claude-sonnet-4-5-20250929'|'claude-opus-4-0'|'claude-opus-4-20250514'|'claude-4-opus-20250514'|'claude-opus-4-1-20250805'|'claude-3-opus-latest'|'claude-3-opus-20240229'|'claude-3-haiku-20240307'|Model $model Body param: The model that will complete your prompt.\n\nSee [models](https://docs.anthropic.com/en/docs/models-overview) for additional details and options.
     * @param array{
     *   edits?: list<array<string,mixed>>
     * }|null $contextManagement Body param: Context management configuration.
     *
     * This allows you to control how Claude manages context across multiple requests, such as whether to clear function results or not.
     * @param list<array{
     *   name: string,
     *   type?: 'url',
     *   url: string,
     *   authorizationToken?: string|null,
     *   toolConfiguration?: array{
     *     allowedTools?: list<string>|null, enabled?: bool|null
     *   }|null,
     * }> $mcpServers Body param: MCP servers to be utilized in this request
     * @param array{
     *   effort?: 'low'|'medium'|'high'|Effort|null
     * } $outputConfig Body param: Configuration options for the model's output. Controls aspects like how much effort the model puts into its response.
     * @param array{
     *   schema: array<string,mixed>, type?: 'json_schema'
     * }|null $outputFormat Body param:
     * A schema to specify Claude's output format in responses
     * @param string|list<array{
     *   text: string,
     *   type?: 'text',
     *   cacheControl?: array{type?: 'ephemeral', ttl?: '5m'|'1h'|TTL}|null,
     *   citations?: list<array<string,mixed>>|null,
     * }> $system Body param: System prompt.
     *
     * A system prompt is a way of providing context and instructions to Claude, such as specifying a particular goal or role. See our [guide to system prompts](https://docs.claude.com/en/docs/system-prompts).
     * @param array<string,mixed> $thinking Body param: Configuration for enabling Claude's extended thinking.
     *
     * When enabled, responses include `thinking` content blocks showing Claude's thinking process before the final answer. Requires a minimum budget of 1,024 tokens and counts towards your `max_tokens` limit.
     *
     * See [extended thinking](https://docs.claude.com/en/docs/build-with-claude/extended-thinking) for details.
     * @param array<string,mixed> $toolChoice Body param: How the model should use the provided tools. The model can use a specific tool, any available tool, decide by itself, or not use tools at all.
     * @param list<array<string,mixed>> $tools Body param: Definitions of tools that the model may use.
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
     * @param list<string|'message-batches-2024-09-24'|'prompt-caching-2024-07-31'|'computer-use-2024-10-22'|'computer-use-2025-01-24'|'pdfs-2024-09-25'|'token-counting-2024-11-01'|'token-efficient-tools-2025-02-19'|'output-128k-2025-02-19'|'files-api-2025-04-14'|'mcp-client-2025-04-04'|'mcp-client-2025-11-20'|'dev-full-thinking-2025-05-14'|'interleaved-thinking-2025-05-14'|'code-execution-2025-05-22'|'extended-cache-ttl-2025-04-11'|'context-1m-2025-08-07'|'context-management-2025-06-27'|'model-context-window-exceeded-2025-08-26'|'skills-2025-10-02'|AnthropicBeta> $betas header param: Optional header to specify the beta version(s) you want to use
     *
     * @throws APIException
     */
    public function countTokens(
        array $messages,
        string|Model $model,
        ?array $contextManagement = null,
        ?array $mcpServers = null,
        ?array $outputConfig = null,
        ?array $outputFormat = null,
        string|array|null $system = null,
        ?array $thinking = null,
        ?array $toolChoice = null,
        ?array $tools = null,
        ?array $betas = null,
        ?RequestOptions $requestOptions = null,
    ): BetaMessageTokensCount;
}
