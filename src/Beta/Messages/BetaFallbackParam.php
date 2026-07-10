<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaFallbackParam\Speed;
use Anthropic\Beta\Messages\BetaFallbackParam\Thinking;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\Model;

/**
 * One entry in the `fallbacks` chain on a `/v1/messages` request.
 *
 * `model` is required. The override fields (`max_tokens`, `thinking`,
 * `output_config`, and `speed`) set the corresponding parameter for this
 * attempt only and are validated as if the request were made to `model`.
 * Any other key is rejected at parse time.
 *
 * @phpstan-import-type ThinkingVariants from \Anthropic\Beta\Messages\BetaFallbackParam\Thinking
 * @phpstan-import-type BetaOutputConfigShape from \Anthropic\Beta\Messages\BetaOutputConfig
 * @phpstan-import-type ThinkingShape from \Anthropic\Beta\Messages\BetaFallbackParam\Thinking
 *
 * @phpstan-type BetaFallbackParamShape = array{
 *   model: string|Model|value-of<Model>,
 *   maxTokens?: int|null,
 *   outputConfig?: null|BetaOutputConfig|BetaOutputConfigShape,
 *   speed?: null|Speed|value-of<Speed>,
 *   thinking?: ThinkingShape|null,
 * }
 */
final class BetaFallbackParam implements BaseModel
{
    /** @use SdkModel<BetaFallbackParamShape> */
    use SdkModel;

    /**
     * The model that will complete your prompt.
     *
     * See [models](https://docs.anthropic.com/en/docs/models-overview) for additional details and options.
     *
     * @var string|value-of<Model> $model
     */
    #[Required(enum: Model::class)]
    public string $model;

    #[Optional('max_tokens', nullable: true)]
    public ?int $maxTokens;

    #[Optional('output_config', nullable: true)]
    public ?BetaOutputConfig $outputConfig;

    /**
     * Inference speed mode. `fast` provides significantly faster output token generation at premium pricing. Not all models support `fast`; invalid combinations are rejected at create time.
     *
     * @var value-of<Speed>|null $speed
     */
    #[Optional(enum: Speed::class, nullable: true)]
    public ?string $speed;

    /** @var ThinkingVariants|null $thinking */
    #[Optional(union: Thinking::class, nullable: true)]
    public BetaThinkingConfigEnabled|BetaThinkingConfigDisabled|BetaThinkingConfigAdaptive|null $thinking;

    /**
     * `new BetaFallbackParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaFallbackParam::with(model: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaFallbackParam)->withModel(...)
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
     * @param string|Model|value-of<Model> $model
     * @param BetaOutputConfig|BetaOutputConfigShape|null $outputConfig
     * @param Speed|value-of<Speed>|null $speed
     * @param ThinkingShape|null $thinking
     */
    public static function with(
        Model|string $model,
        ?int $maxTokens = null,
        BetaOutputConfig|array|null $outputConfig = null,
        Speed|string|null $speed = null,
        BetaThinkingConfigEnabled|array|BetaThinkingConfigDisabled|BetaThinkingConfigAdaptive|null $thinking = null,
    ): self {
        $self = new self;

        $self['model'] = $model;

        null !== $maxTokens && $self['maxTokens'] = $maxTokens;
        null !== $outputConfig && $self['outputConfig'] = $outputConfig;
        null !== $speed && $self['speed'] = $speed;
        null !== $thinking && $self['thinking'] = $thinking;

        return $self;
    }

    /**
     * The model that will complete your prompt.
     *
     * See [models](https://docs.anthropic.com/en/docs/models-overview) for additional details and options.
     *
     * @param string|Model|value-of<Model> $model
     */
    public function withModel(Model|string $model): self
    {
        $self = clone $this;
        $self['model'] = $model;

        return $self;
    }

    public function withMaxTokens(?int $maxTokens): self
    {
        $self = clone $this;
        $self['maxTokens'] = $maxTokens;

        return $self;
    }

    /**
     * @param BetaOutputConfig|BetaOutputConfigShape|null $outputConfig
     */
    public function withOutputConfig(
        BetaOutputConfig|array|null $outputConfig
    ): self {
        $self = clone $this;
        $self['outputConfig'] = $outputConfig;

        return $self;
    }

    /**
     * Inference speed mode. `fast` provides significantly faster output token generation at premium pricing. Not all models support `fast`; invalid combinations are rejected at create time.
     *
     * @param Speed|value-of<Speed>|null $speed
     */
    public function withSpeed(Speed|string|null $speed): self
    {
        $self = clone $this;
        $self['speed'] = $speed;

        return $self;
    }

    /**
     * @param ThinkingShape|null $thinking
     */
    public function withThinking(
        BetaThinkingConfigEnabled|array|BetaThinkingConfigDisabled|BetaThinkingConfigAdaptive|null $thinking,
    ): self {
        $self = clone $this;
        $self['thinking'] = $thinking;

        return $self;
    }
}
