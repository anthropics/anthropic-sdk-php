<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Effort (reasoning_effort) capability details.
 *
 * @phpstan-import-type CapabilitySupportShape from \Anthropic\Models\CapabilitySupport
 *
 * @phpstan-type EffortCapabilityShape = array{
 *   high: CapabilitySupport|CapabilitySupportShape,
 *   low: CapabilitySupport|CapabilitySupportShape,
 *   max: CapabilitySupport|CapabilitySupportShape,
 *   medium: CapabilitySupport|CapabilitySupportShape,
 *   supported: bool,
 * }
 */
final class EffortCapability implements BaseModel
{
    /** @use SdkModel<EffortCapabilityShape> */
    use SdkModel;

    /**
     * Whether the model supports high effort level.
     */
    #[Required]
    public CapabilitySupport $high;

    /**
     * Whether the model supports low effort level.
     */
    #[Required]
    public CapabilitySupport $low;

    /**
     * Whether the model supports max effort level.
     */
    #[Required]
    public CapabilitySupport $max;

    /**
     * Whether the model supports medium effort level.
     */
    #[Required]
    public CapabilitySupport $medium;

    /**
     * Whether this capability is supported by the model.
     */
    #[Required]
    public bool $supported;

    /**
     * `new EffortCapability()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * EffortCapability::with(
     *   high: ..., low: ..., max: ..., medium: ..., supported: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new EffortCapability)
     *   ->withHigh(...)
     *   ->withLow(...)
     *   ->withMax(...)
     *   ->withMedium(...)
     *   ->withSupported(...)
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
     * @param CapabilitySupport|CapabilitySupportShape $high
     * @param CapabilitySupport|CapabilitySupportShape $low
     * @param CapabilitySupport|CapabilitySupportShape $max
     * @param CapabilitySupport|CapabilitySupportShape $medium
     */
    public static function with(
        CapabilitySupport|array $high,
        CapabilitySupport|array $low,
        CapabilitySupport|array $max,
        CapabilitySupport|array $medium,
        bool $supported,
    ): self {
        $self = new self;

        $self['high'] = $high;
        $self['low'] = $low;
        $self['max'] = $max;
        $self['medium'] = $medium;
        $self['supported'] = $supported;

        return $self;
    }

    /**
     * Whether the model supports high effort level.
     *
     * @param CapabilitySupport|CapabilitySupportShape $high
     */
    public function withHigh(CapabilitySupport|array $high): self
    {
        $self = clone $this;
        $self['high'] = $high;

        return $self;
    }

    /**
     * Whether the model supports low effort level.
     *
     * @param CapabilitySupport|CapabilitySupportShape $low
     */
    public function withLow(CapabilitySupport|array $low): self
    {
        $self = clone $this;
        $self['low'] = $low;

        return $self;
    }

    /**
     * Whether the model supports max effort level.
     *
     * @param CapabilitySupport|CapabilitySupportShape $max
     */
    public function withMax(CapabilitySupport|array $max): self
    {
        $self = clone $this;
        $self['max'] = $max;

        return $self;
    }

    /**
     * Whether the model supports medium effort level.
     *
     * @param CapabilitySupport|CapabilitySupportShape $medium
     */
    public function withMedium(CapabilitySupport|array $medium): self
    {
        $self = clone $this;
        $self['medium'] = $medium;

        return $self;
    }

    /**
     * Whether this capability is supported by the model.
     */
    public function withSupported(bool $supported): self
    {
        $self = clone $this;
        $self['supported'] = $supported;

        return $self;
    }
}
