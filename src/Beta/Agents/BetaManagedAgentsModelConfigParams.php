<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Agents\BetaManagedAgentsModelConfigParams\Speed;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * An object that defines additional configuration control over model use.
 *
 * @phpstan-type BetaManagedAgentsModelConfigParamsShape = array{
 *   id: string|BetaManagedAgentsModel|value-of<BetaManagedAgentsModel>,
 *   speed?: null|Speed|value-of<Speed>,
 * }
 */
final class BetaManagedAgentsModelConfigParams implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsModelConfigParamsShape> */
    use SdkModel;

    /**
     * The model that will power your agent.\n\nSee [models](https://docs.anthropic.com/en/docs/models-overview) for additional details and options.
     *
     * @var string|value-of<BetaManagedAgentsModel> $id
     */
    #[Required(enum: BetaManagedAgentsModel::class)]
    public string $id;

    /**
     * Inference speed mode. `fast` provides significantly faster output token generation at premium pricing. Not all models support `fast`; invalid combinations are rejected at create time.
     *
     * @var value-of<Speed>|null $speed
     */
    #[Optional(enum: Speed::class, nullable: true)]
    public ?string $speed;

    /**
     * `new BetaManagedAgentsModelConfigParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsModelConfigParams::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsModelConfigParams)->withID(...)
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
     * @param Speed|value-of<Speed>|null $speed
     */
    public static function with(
        BetaManagedAgentsModel|string $id,
        Speed|string|null $speed = null
    ): self {
        $self = new self;

        $self['id'] = $id;

        null !== $speed && $self['speed'] = $speed;

        return $self;
    }

    /**
     * The model that will power your agent.\n\nSee [models](https://docs.anthropic.com/en/docs/models-overview) for additional details and options.
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
}
