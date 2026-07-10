<?php

declare(strict_types=1);

namespace Anthropic\Beta\Dreams;

use Anthropic\Beta\Dreams\BetaDreamModelConfigParam\Speed;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Model identifier and configuration applied to every pipeline stage.
 *
 * @phpstan-type BetaDreamModelConfigParamShape = array{
 *   id: string, speed?: null|Speed|value-of<Speed>
 * }
 */
final class BetaDreamModelConfigParam implements BaseModel
{
    /** @use SdkModel<BetaDreamModelConfigParamShape> */
    use SdkModel;

    /**
     * Model identifier, e.g. "claude-opus-4-7". 1-256 characters.
     */
    #[Required]
    public string $id;

    /**
     * Inference speed mode. `fast` provides significantly faster output token generation at premium pricing. Not all models support `fast`; invalid combinations are rejected at create time.
     *
     * @var value-of<Speed>|null $speed
     */
    #[Optional(enum: Speed::class, nullable: true)]
    public ?string $speed;

    /**
     * `new BetaDreamModelConfigParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaDreamModelConfigParam::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaDreamModelConfigParam)->withID(...)
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
     * @param Speed|value-of<Speed>|null $speed
     */
    public static function with(
        string $id,
        Speed|string|null $speed = null
    ): self {
        $self = new self;

        $self['id'] = $id;

        null !== $speed && $self['speed'] = $speed;

        return $self;
    }

    /**
     * Model identifier, e.g. "claude-opus-4-7". 1-256 characters.
     */
    public function withID(string $id): self
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
