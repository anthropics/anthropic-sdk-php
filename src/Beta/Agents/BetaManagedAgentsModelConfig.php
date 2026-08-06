<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Agents\BetaManagedAgentsModelConfig\Effort;
use Anthropic\Beta\Agents\BetaManagedAgentsModelConfig\Speed;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Model identifier and configuration.
 *
 * @phpstan-import-type EffortVariants from \Anthropic\Beta\Agents\BetaManagedAgentsModelConfig\Effort
 * @phpstan-import-type EffortShape from \Anthropic\Beta\Agents\BetaManagedAgentsModelConfig\Effort
 *
 * @phpstan-type BetaManagedAgentsModelConfigShape = array{
 *   id: string|BetaManagedAgentsModel|value-of<BetaManagedAgentsModel>,
 *   effort?: EffortShape|null,
 *   inferenceGeo?: string|null,
 *   speed?: null|Speed|value-of<Speed>,
 * }
 */
final class BetaManagedAgentsModelConfig implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsModelConfigShape> */
    use SdkModel;

    /**
     * The model that will power your agent.
     *
     * See [models](https://docs.anthropic.com/en/docs/models-overview) for additional details and options.
     *
     * @var string|value-of<BetaManagedAgentsModel> $id
     */
    #[Required(enum: BetaManagedAgentsModel::class)]
    public string $id;

    /**
     * How hard Claude works on each turn. Sets `output_config.effort` on every Messages call the session makes.
     *
     * @var EffortVariants|null $effort
     */
    #[Optional(union: Effort::class)]
    public BetaManagedAgentsEffortLow|BetaManagedAgentsEffortMedium|BetaManagedAgentsEffortHigh|BetaManagedAgentsEffortXhigh|BetaManagedAgentsEffortMax|null $effort;

    /**
     * Geographic region for model inference. When unset, requests fall through to the workspace's default_inference_geo.
     */
    #[Optional('inference_geo')]
    public ?string $inferenceGeo;

    /**
     * Inference speed mode. `fast` provides significantly faster output token generation at premium pricing. Not all models support `fast`; invalid combinations are rejected at create time.
     *
     * @var value-of<Speed>|null $speed
     */
    #[Optional(enum: Speed::class)]
    public ?string $speed;

    /**
     * `new BetaManagedAgentsModelConfig()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsModelConfig::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsModelConfig)->withID(...)
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
     * @param string|BetaManagedAgentsModel|value-of<BetaManagedAgentsModel> $id
     * @param EffortShape|null $effort
     * @param Speed|value-of<Speed>|null $speed
     */
    public static function with(
        BetaManagedAgentsModel|string $id,
        BetaManagedAgentsEffortLow|array|BetaManagedAgentsEffortMedium|BetaManagedAgentsEffortHigh|BetaManagedAgentsEffortXhigh|BetaManagedAgentsEffortMax|null $effort = null,
        ?string $inferenceGeo = null,
        Speed|string|null $speed = null,
    ): self {
        $self = new self;

        $self['id'] = $id;

        null !== $effort && $self['effort'] = $effort;
        null !== $inferenceGeo && $self['inferenceGeo'] = $inferenceGeo;
        null !== $speed && $self['speed'] = $speed;

        return $self;
    }

    /**
     * The model that will power your agent.
     *
     * See [models](https://docs.anthropic.com/en/docs/models-overview) for additional details and options.
     *
     * @param string|BetaManagedAgentsModel|value-of<BetaManagedAgentsModel> $id
     */
    public function withID(BetaManagedAgentsModel|string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * How hard Claude works on each turn. Sets `output_config.effort` on every Messages call the session makes.
     *
     * @param EffortShape $effort
     */
    public function withEffort(
        BetaManagedAgentsEffortLow|array|BetaManagedAgentsEffortMedium|BetaManagedAgentsEffortHigh|BetaManagedAgentsEffortXhigh|BetaManagedAgentsEffortMax $effort,
    ): self {
        $self = clone $this;
        $self['effort'] = $effort;

        return $self;
    }

    /**
     * Geographic region for model inference. When unset, requests fall through to the workspace's default_inference_geo.
     */
    public function withInferenceGeo(string $inferenceGeo): self
    {
        $self = clone $this;
        $self['inferenceGeo'] = $inferenceGeo;

        return $self;
    }

    /**
     * Inference speed mode. `fast` provides significantly faster output token generation at premium pricing. Not all models support `fast`; invalid combinations are rejected at create time.
     *
     * @param Speed|value-of<Speed> $speed
     */
    public function withSpeed(Speed|string $speed): self
    {
        $self = clone $this;
        $self['speed'] = $speed;

        return $self;
    }
}
