<?php

declare(strict_types=1);

namespace Anthropic\Messages\Batches\BatchCreateParams\Request;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\Batches\BatchCreateParams\Request\Params\ServiceTier;
use Anthropic\Messages\Batches\BatchCreateParams\Request\Params\System;
use Anthropic\Messages\MessageParam;
use Anthropic\Messages\Metadata;
use Anthropic\Messages\Model;
use Anthropic\Messages\OutputConfig;
use Anthropic\Messages\ThinkingConfigAdaptive;
use Anthropic\Messages\ThinkingConfigDisabled;
use Anthropic\Messages\ThinkingConfigEnabled;
use Anthropic\Messages\ThinkingConfigParam;
use Anthropic\Messages\ToolChoice;
use Anthropic\Messages\ToolChoiceAny;
use Anthropic\Messages\ToolChoiceAuto;
use Anthropic\Messages\ToolChoiceNone;
use Anthropic\Messages\ToolChoiceTool;
use Anthropic\Messages\ToolUnion;

/**
 * Messages API creation parameters for the individual request.
 *
 * See the [Messages API reference](https://docs.claude.com/en/api/messages) for full documentation on available parameters.
 *
 * @phpstan-import-type SystemVariants from \Anthropic\Messages\Batches\BatchCreateParams\Request\Params\System
 * @phpstan-import-type ThinkingConfigParamVariants from \Anthropic\Messages\ThinkingConfigParam
 * @phpstan-import-type ToolChoiceVariants from \Anthropic\Messages\ToolChoice
 * @phpstan-import-type ToolUnionVariants from \Anthropic\Messages\ToolUnion
 * @phpstan-import-type MessageParamShape from \Anthropic\Messages\MessageParam
 * @phpstan-import-type MetadataShape from \Anthropic\Messages\Metadata
 * @phpstan-import-type OutputConfigShape from \Anthropic\Messages\OutputConfig
 * @phpstan-import-type SystemShape from \Anthropic\Messages\Batches\BatchCreateParams\Request\Params\System
 * @phpstan-import-type ThinkingConfigParamShape from \Anthropic\Messages\ThinkingConfigParam
 * @phpstan-import-type ToolChoiceShape from \Anthropic\Messages\ToolChoice
 * @phpstan-import-type ToolUnionShape from \Anthropic\Messages\ToolUnion
 *
 * @phpstan-type ParamsShape = array{
 *   maxTokens: int,
 *   messages: list<MessageParam|MessageParamShape>,
 *   model: string|Model|value-of<Model>,
 *   inferenceGeo?: string|null,
 *   metadata?: null|Metadata|MetadataShape,
 *   outputConfig?: null|OutputConfig|OutputConfigShape,
 *   serviceTier?: null|ServiceTier|value-of<ServiceTier>,
 *   stopSequences?: list<string>|null,
 *   stream?: bool|null,
 *   system?: SystemShape|null,
 *   temperature?: float|null,
 *   thinking?: ThinkingConfigParamShape|null,
 *   toolChoice?: ToolChoiceShape|null,
 *   tools?: list<ToolUnionShape>|null,
 *   topK?: int|null,
 *   topP?: float|null,
 * }
 */
final class Params implements BaseModel
{
    /** @use SdkModel<ParamsShape> */
    use SdkModel;

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
     * @var list<MessageParam> $messages
     */
    #[Required(list: MessageParam::class)]
    public array $messages;

    /**
     * The model that will complete your prompt.\n\nSee [models](https://docs.anthropic.com/en/docs/models-overview) for additional details and options.
     *
     * @var string|value-of<Model> $model
     */
    #[Required(enum: Model::class)]
    public string $model;

    /**
     * Specifies the geographic region for inference processing. If not specified, the workspace's `default_inference_geo` is used.
     */
    #[Optional('inference_geo', nullable: true)]
    public ?string $inferenceGeo;

    /**
     * An object describing metadata about the request.
     */
    #[Optional]
    public ?Metadata $metadata;

    /**
     * Configuration options for the model's output, such as the output format.
     */
    #[Optional('output_config')]
    public ?OutputConfig $outputConfig;

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
     * Whether to incrementally stream the response using server-sent events.
     *
     * See [streaming](https://docs.claude.com/en/api/messages-streaming) for details.
     */
    #[Optional]
    public ?bool $stream;

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
     *
     * @var ThinkingConfigParamVariants|null $thinking
     */
    #[Optional(union: ThinkingConfigParam::class)]
    public ThinkingConfigEnabled|ThinkingConfigDisabled|ThinkingConfigAdaptive|null $thinking;

    /**
     * How the model should use the provided tools. The model can use a specific tool, any available tool, decide by itself, or not use tools at all.
     *
     * @var ToolChoiceVariants|null $toolChoice
     */
    #[Optional('tool_choice', union: ToolChoice::class)]
    public ToolChoiceAuto|ToolChoiceAny|ToolChoiceTool|ToolChoiceNone|null $toolChoice;

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
     * @var list<ToolUnionVariants>|null $tools
     */
    #[Optional(list: ToolUnion::class)]
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
     * `new Params()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Params::with(maxTokens: ..., messages: ..., model: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Params)->withMaxTokens(...)->withMessages(...)->withModel(...)
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
     * @param list<MessageParam|MessageParamShape> $messages
     * @param string|Model|value-of<Model> $model
     * @param Metadata|MetadataShape|null $metadata
     * @param OutputConfig|OutputConfigShape|null $outputConfig
     * @param ServiceTier|value-of<ServiceTier>|null $serviceTier
     * @param list<string>|null $stopSequences
     * @param SystemShape|null $system
     * @param ThinkingConfigParamShape|null $thinking
     * @param ToolChoiceShape|null $toolChoice
     * @param list<ToolUnionShape>|null $tools
     */
    public static function with(
        int $maxTokens,
        array $messages,
        Model|string $model,
        ?string $inferenceGeo = null,
        Metadata|array|null $metadata = null,
        OutputConfig|array|null $outputConfig = null,
        ServiceTier|string|null $serviceTier = null,
        ?array $stopSequences = null,
        ?bool $stream = null,
        string|array|null $system = null,
        ?float $temperature = null,
        ThinkingConfigEnabled|array|ThinkingConfigDisabled|ThinkingConfigAdaptive|null $thinking = null,
        ToolChoiceAuto|array|ToolChoiceAny|ToolChoiceTool|ToolChoiceNone|null $toolChoice = null,
        ?array $tools = null,
        ?int $topK = null,
        ?float $topP = null,
    ): self {
        $self = new self;

        $self['maxTokens'] = $maxTokens;
        $self['messages'] = $messages;
        $self['model'] = $model;

        null !== $inferenceGeo && $self['inferenceGeo'] = $inferenceGeo;
        null !== $metadata && $self['metadata'] = $metadata;
        null !== $outputConfig && $self['outputConfig'] = $outputConfig;
        null !== $serviceTier && $self['serviceTier'] = $serviceTier;
        null !== $stopSequences && $self['stopSequences'] = $stopSequences;
        null !== $stream && $self['stream'] = $stream;
        null !== $system && $self['system'] = $system;
        null !== $temperature && $self['temperature'] = $temperature;
        null !== $thinking && $self['thinking'] = $thinking;
        null !== $toolChoice && $self['toolChoice'] = $toolChoice;
        null !== $tools && $self['tools'] = $tools;
        null !== $topK && $self['topK'] = $topK;
        null !== $topP && $self['topP'] = $topP;

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
     * @param list<MessageParam|MessageParamShape> $messages
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
     * Specifies the geographic region for inference processing. If not specified, the workspace's `default_inference_geo` is used.
     */
    public function withInferenceGeo(?string $inferenceGeo): self
    {
        $self = clone $this;
        $self['inferenceGeo'] = $inferenceGeo;

        return $self;
    }

    /**
     * An object describing metadata about the request.
     *
     * @param Metadata|MetadataShape $metadata
     */
    public function withMetadata(Metadata|array $metadata): self
    {
        $self = clone $this;
        $self['metadata'] = $metadata;

        return $self;
    }

    /**
     * Configuration options for the model's output, such as the output format.
     *
     * @param OutputConfig|OutputConfigShape $outputConfig
     */
    public function withOutputConfig(OutputConfig|array $outputConfig): self
    {
        $self = clone $this;
        $self['outputConfig'] = $outputConfig;

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
     * Whether to incrementally stream the response using server-sent events.
     *
     * See [streaming](https://docs.claude.com/en/api/messages-streaming) for details.
     */
    public function withStream(bool $stream): self
    {
        $self = clone $this;
        $self['stream'] = $stream;

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
     * @param ThinkingConfigParamShape $thinking
     */
    public function withThinking(
        ThinkingConfigEnabled|array|ThinkingConfigDisabled|ThinkingConfigAdaptive $thinking,
    ): self {
        $self = clone $this;
        $self['thinking'] = $thinking;

        return $self;
    }

    /**
     * How the model should use the provided tools. The model can use a specific tool, any available tool, decide by itself, or not use tools at all.
     *
     * @param ToolChoiceShape $toolChoice
     */
    public function withToolChoice(
        ToolChoiceAuto|array|ToolChoiceAny|ToolChoiceTool|ToolChoiceNone $toolChoice
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
     * @param list<ToolUnionShape> $tools
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
}
