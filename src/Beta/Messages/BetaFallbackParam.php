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
 * @phpstan-import-type BetaOutputConfigShape from \Anthropic\Beta\Messages\BetaOutputConfig
 * @phpstan-import-type ThinkingShape from \Anthropic\Beta\Messages\BetaFallbackParam\Thinking
 * @phpstan-import-type ThinkingVariants from \Anthropic\Beta\Messages\BetaFallbackParam\Thinking
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

    /**
     * The `max_tokens` for the fallback attempt that uses this `fallbacks` entry's `model`, in place of the request's `max_tokens`. If you leave it out or set it to `null`, the attempt uses the request's `max_tokens`.
     *
     * See the [refusals and fallback guide](https://platform.claude.com/docs/en/build-with-claude/refusals-and-fallback#naming-your-own-fallback-models) to learn more about fallback entries.
     */
    #[Optional('max_tokens', nullable: true)]
    public ?int $maxTokens;

    /**
     * Output parameters for the fallback attempt that uses this `fallbacks` entry's `model`, combined with the request's `output_config` one field at a time.
     *
     * - `format`: If you leave it out, the attempt uses the request's `format`. If you set it to `null`, the attempt runs without a format.
     * - `effort`: If you leave it out, the attempt uses the request's `effort` when `model` supports that level with the attempt's `thinking`. If the request doesn't set `effort`, if `model` doesn't support the level, or if you set `effort` to `null`, the attempt runs at the default effort of `model`.
     * - `task_budget`: If you leave it out, the attempt uses the request's `task_budget` when `model` accepts a task budget of that size. If the request doesn't set `task_budget`, if `model` doesn't accept it, or if you set `task_budget` to `null`, the attempt runs without a task budget.
     *
     * Set `output_config` to `null` to run the attempt without a format or a task budget, at the default effort of `model`.
     *
     * These rules apply with the `server-side-fallback-2026-07-01` beta header.
     */
    #[Optional('output_config', nullable: true)]
    public ?BetaOutputConfig $outputConfig;

    /**
     * The inference speed mode for the fallback attempt that uses this `fallbacks` entry's `model`. If you leave it out, the attempt runs at `fast` speed only when the request sets `speed` to `fast` and your organization can use fast mode on `model`.
     *
     * Otherwise, or when you set this field to `null`, the attempt runs at `standard` speed.
     *
     * These rules apply with the `server-side-fallback-2026-07-01` beta header.
     *
     * @var value-of<Speed>|null $speed
     */
    #[Optional(enum: Speed::class, nullable: true)]
    public ?string $speed;

    /**
     * The thinking configuration for the fallback attempt that uses this `fallbacks` entry's `model`. If you leave it out, the attempt uses the request's `thinking` when `model` supports that thinking `type`.
     *
     * If you leave it out and the request's thinking `type` is `between_tools` but `model` doesn't support `between_tools`, the attempt uses `disabled` if `model` supports it. Otherwise, if `model` doesn't support the request's thinking `type`, if the request doesn't set `thinking`, or if you set this field to `null`, the attempt uses the thinking `type` that `model` uses when a request leaves out `thinking`. The request's `thinking.display` still applies where `model` allows it.
     *
     * These rules apply with the `server-side-fallback-2026-07-01` beta header.
     *
     * @var ThinkingVariants|null $thinking
     */
    #[Optional(union: Thinking::class, nullable: true)]
    public BetaThinkingConfigEnabled|BetaThinkingConfigDisabled|BetaThinkingConfigBetweenTools|BetaThinkingConfigAdaptive|null $thinking;

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
     * (new BetaFallbackParam())->withModel(...)
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
        BetaThinkingConfigEnabled|array|BetaThinkingConfigDisabled|BetaThinkingConfigBetweenTools|BetaThinkingConfigAdaptive|null $thinking = null,
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

    /**
     * The `max_tokens` for the fallback attempt that uses this `fallbacks` entry's `model`, in place of the request's `max_tokens`. If you leave it out or set it to `null`, the attempt uses the request's `max_tokens`.
     *
     * See the [refusals and fallback guide](https://platform.claude.com/docs/en/build-with-claude/refusals-and-fallback#naming-your-own-fallback-models) to learn more about fallback entries.
     */
    public function withMaxTokens(?int $maxTokens): self
    {
        $self = clone $this;
        $self['maxTokens'] = $maxTokens;

        return $self;
    }

    /**
     * Output parameters for the fallback attempt that uses this `fallbacks` entry's `model`, combined with the request's `output_config` one field at a time.
     *
     * - `format`: If you leave it out, the attempt uses the request's `format`. If you set it to `null`, the attempt runs without a format.
     * - `effort`: If you leave it out, the attempt uses the request's `effort` when `model` supports that level with the attempt's `thinking`. If the request doesn't set `effort`, if `model` doesn't support the level, or if you set `effort` to `null`, the attempt runs at the default effort of `model`.
     * - `task_budget`: If you leave it out, the attempt uses the request's `task_budget` when `model` accepts a task budget of that size. If the request doesn't set `task_budget`, if `model` doesn't accept it, or if you set `task_budget` to `null`, the attempt runs without a task budget.
     *
     * Set `output_config` to `null` to run the attempt without a format or a task budget, at the default effort of `model`.
     *
     * These rules apply with the `server-side-fallback-2026-07-01` beta header.
     *
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
     * The inference speed mode for the fallback attempt that uses this `fallbacks` entry's `model`. If you leave it out, the attempt runs at `fast` speed only when the request sets `speed` to `fast` and your organization can use fast mode on `model`.
     *
     * Otherwise, or when you set this field to `null`, the attempt runs at `standard` speed.
     *
     * These rules apply with the `server-side-fallback-2026-07-01` beta header.
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
     * The thinking configuration for the fallback attempt that uses this `fallbacks` entry's `model`. If you leave it out, the attempt uses the request's `thinking` when `model` supports that thinking `type`.
     *
     * If you leave it out and the request's thinking `type` is `between_tools` but `model` doesn't support `between_tools`, the attempt uses `disabled` if `model` supports it. Otherwise, if `model` doesn't support the request's thinking `type`, if the request doesn't set `thinking`, or if you set this field to `null`, the attempt uses the thinking `type` that `model` uses when a request leaves out `thinking`. The request's `thinking.display` still applies where `model` allows it.
     *
     * These rules apply with the `server-side-fallback-2026-07-01` beta header.
     *
     * @param ThinkingShape|null $thinking
     */
    public function withThinking(
        BetaThinkingConfigEnabled|array|BetaThinkingConfigDisabled|BetaThinkingConfigBetweenTools|BetaThinkingConfigAdaptive|null $thinking,
    ): self {
        $self = clone $this;
        $self['thinking'] = $thinking;

        return $self;
    }
}
