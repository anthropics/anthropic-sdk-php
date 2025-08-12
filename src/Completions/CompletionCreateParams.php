<?php

declare(strict_types=1);

namespace Anthropic\Completions;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\AnthropicBeta\UnionMember1;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Concerns\Params;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Messages\Metadata;
use Anthropic\Messages\Model;
use Anthropic\Messages\Model\UnionMember0;

/**
 * [Legacy] Create a Text Completion.
 *
 * The Text Completions API is a legacy API. We recommend using the [Messages API](https://docs.anthropic.com/en/api/messages) going forward.
 *
 * Future models and features will not be compatible with Text Completions. See our [migration guide](https://docs.anthropic.com/en/api/migrating-from-text-completions-to-messages) for guidance in migrating from Text Completions to Messages.
 *
 * @phpstan-type create_params = array{
 *   maxTokensToSample: int,
 *   model: UnionMember0::*|string,
 *   prompt: string,
 *   metadata?: Metadata,
 *   stopSequences?: list<string>,
 *   temperature?: float,
 *   topK?: int,
 *   topP?: float,
 *   anthropicBeta?: list<string|UnionMember1::*>,
 * }
 */
final class CompletionCreateParams implements BaseModel
{
    use ModelTrait;
    use Params;

    /**
     * The maximum number of tokens to generate before stopping.
     *
     * Note that our models may stop _before_ reaching this maximum. This parameter only specifies the absolute maximum number of tokens to generate.
     */
    #[Api('max_tokens_to_sample')]
    public int $maxTokensToSample;

    /**
     * The model that will complete your prompt.\n\nSee [models](https://docs.anthropic.com/en/docs/models-overview) for additional details and options.
     *
     * @var string|UnionMember0::* $model
     */
    #[Api(union: Model::class)]
    public string $model;

    /**
     * The prompt that you want Claude to complete.
     *
     * For proper response generation you will need to format your prompt using alternating `\n\nHuman:` and `\n\nAssistant:` conversational turns. For example:
     *
     * ```
     * "\n\nHuman: {userQuestion}\n\nAssistant:"
     * ```
     *
     * See [prompt validation](https://docs.anthropic.com/en/api/prompt-validation) and our guide to [prompt design](https://docs.anthropic.com/en/docs/intro-to-prompting) for more details.
     */
    #[Api]
    public string $prompt;

    /**
     * An object describing metadata about the request.
     */
    #[Api(optional: true)]
    public ?Metadata $metadata;

    /**
     * Sequences that will cause the model to stop generating.
     *
     * Our models stop on `"\n\nHuman:"`, and may include additional built-in stop sequences in the future. By providing the stop_sequences parameter, you may include additional strings that will cause the model to stop generating.
     *
     * @var null|list<string> $stopSequences
     */
    #[Api('stop_sequences', type: new ListOf('string'), optional: true)]
    public ?array $stopSequences;

    /**
     * Amount of randomness injected into the response.
     *
     * Defaults to `1.0`. Ranges from `0.0` to `1.0`. Use `temperature` closer to `0.0` for analytical / multiple choice, and closer to `1.0` for creative and generative tasks.
     *
     * Note that even with `temperature` of `0.0`, the results will not be fully deterministic.
     */
    #[Api(optional: true)]
    public ?float $temperature;

    /**
     * Only sample from the top K options for each subsequent token.
     *
     * Used to remove "long tail" low probability responses. [Learn more technical details here](https://towardsdatascience.com/how-to-sample-from-language-models-682bceb97277).
     *
     * Recommended for advanced use cases only. You usually only need to use `temperature`.
     */
    #[Api('top_k', optional: true)]
    public ?int $topK;

    /**
     * Use nucleus sampling.
     *
     * In nucleus sampling, we compute the cumulative distribution over all the options for each subsequent token in decreasing probability order and cut it off once it reaches a particular probability specified by `top_p`. You should either alter `temperature` or `top_p`, but not both.
     *
     * Recommended for advanced use cases only. You usually only need to use `temperature`.
     */
    #[Api('top_p', optional: true)]
    public ?float $topP;

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
     * @param string|UnionMember0::* $model
     * @param null|list<string> $stopSequences
     * @param null|list<string|UnionMember1::*> $anthropicBeta
     */
    public static function from(
        int $maxTokensToSample,
        string $model,
        string $prompt,
        ?Metadata $metadata = null,
        ?array $stopSequences = null,
        ?float $temperature = null,
        ?int $topK = null,
        ?float $topP = null,
        ?array $anthropicBeta = null,
    ): self {
        $obj = new self;

        $obj->maxTokensToSample = $maxTokensToSample;
        $obj->model = $model;
        $obj->prompt = $prompt;

        null !== $metadata && $obj->metadata = $metadata;
        null !== $stopSequences && $obj->stopSequences = $stopSequences;
        null !== $temperature && $obj->temperature = $temperature;
        null !== $topK && $obj->topK = $topK;
        null !== $topP && $obj->topP = $topP;
        null !== $anthropicBeta && $obj->anthropicBeta = $anthropicBeta;

        return $obj;
    }

    /**
     * The maximum number of tokens to generate before stopping.
     *
     * Note that our models may stop _before_ reaching this maximum. This parameter only specifies the absolute maximum number of tokens to generate.
     */
    public function setMaxTokensToSample(int $maxTokensToSample): self
    {
        $this->maxTokensToSample = $maxTokensToSample;

        return $this;
    }

    /**
     * The model that will complete your prompt.\n\nSee [models](https://docs.anthropic.com/en/docs/models-overview) for additional details and options.
     *
     * @param string|UnionMember0::* $model
     */
    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    /**
     * The prompt that you want Claude to complete.
     *
     * For proper response generation you will need to format your prompt using alternating `\n\nHuman:` and `\n\nAssistant:` conversational turns. For example:
     *
     * ```
     * "\n\nHuman: {userQuestion}\n\nAssistant:"
     * ```
     *
     * See [prompt validation](https://docs.anthropic.com/en/api/prompt-validation) and our guide to [prompt design](https://docs.anthropic.com/en/docs/intro-to-prompting) for more details.
     */
    public function setPrompt(string $prompt): self
    {
        $this->prompt = $prompt;

        return $this;
    }

    /**
     * An object describing metadata about the request.
     */
    public function setMetadata(Metadata $metadata): self
    {
        $this->metadata = $metadata;

        return $this;
    }

    /**
     * Sequences that will cause the model to stop generating.
     *
     * Our models stop on `"\n\nHuman:"`, and may include additional built-in stop sequences in the future. By providing the stop_sequences parameter, you may include additional strings that will cause the model to stop generating.
     *
     * @param list<string> $stopSequences
     */
    public function setStopSequences(array $stopSequences): self
    {
        $this->stopSequences = $stopSequences;

        return $this;
    }

    /**
     * Amount of randomness injected into the response.
     *
     * Defaults to `1.0`. Ranges from `0.0` to `1.0`. Use `temperature` closer to `0.0` for analytical / multiple choice, and closer to `1.0` for creative and generative tasks.
     *
     * Note that even with `temperature` of `0.0`, the results will not be fully deterministic.
     */
    public function setTemperature(float $temperature): self
    {
        $this->temperature = $temperature;

        return $this;
    }

    /**
     * Only sample from the top K options for each subsequent token.
     *
     * Used to remove "long tail" low probability responses. [Learn more technical details here](https://towardsdatascience.com/how-to-sample-from-language-models-682bceb97277).
     *
     * Recommended for advanced use cases only. You usually only need to use `temperature`.
     */
    public function setTopK(int $topK): self
    {
        $this->topK = $topK;

        return $this;
    }

    /**
     * Use nucleus sampling.
     *
     * In nucleus sampling, we compute the cumulative distribution over all the options for each subsequent token in decreasing probability order and cut it off once it reaches a particular probability specified by `top_p`. You should either alter `temperature` or `top_p`, but not both.
     *
     * Recommended for advanced use cases only. You usually only need to use `temperature`.
     */
    public function setTopP(float $topP): self
    {
        $this->topP = $topP;

        return $this;
    }

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @param list<string|UnionMember1::*> $betas
     */
    public function setBetas(array $betas): self
    {
        $this->anthropicBeta = $betas;

        return $this;
    }
}
