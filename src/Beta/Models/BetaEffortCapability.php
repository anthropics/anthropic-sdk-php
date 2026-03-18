<?php

declare(strict_types=1);

namespace Anthropic\Beta\Models;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Effort (reasoning_effort) capability details.
 *
 * @phpstan-import-type BetaCapabilitySupportShape from \Anthropic\Beta\Models\BetaCapabilitySupport
 *
 * @phpstan-type BetaEffortCapabilityShape = array{
 *   high: BetaCapabilitySupport|BetaCapabilitySupportShape,
 *   low: BetaCapabilitySupport|BetaCapabilitySupportShape,
 *   max: BetaCapabilitySupport|BetaCapabilitySupportShape,
 *   medium: BetaCapabilitySupport|BetaCapabilitySupportShape,
 *   supported: bool,
 * }
 */
final class BetaEffortCapability implements BaseModel
{
    /** @use SdkModel<BetaEffortCapabilityShape> */
    use SdkModel;

    /**
     * Whether the model supports high effort level.
     */
    #[Required]
    public BetaCapabilitySupport $high;

    /**
     * Whether the model supports low effort level.
     */
    #[Required]
    public BetaCapabilitySupport $low;

    /**
     * Whether the model supports max effort level.
     */
    #[Required]
    public BetaCapabilitySupport $max;

    /**
     * Whether the model supports medium effort level.
     */
    #[Required]
    public BetaCapabilitySupport $medium;

    /**
     * Whether this capability is supported by the model.
     */
    #[Required]
    public bool $supported;

    /**
     * `new BetaEffortCapability()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaEffortCapability::with(
     *   high: ..., low: ..., max: ..., medium: ..., supported: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaEffortCapability)
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
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape $high
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape $low
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape $max
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape $medium
     */
    public static function with(
        BetaCapabilitySupport|array $high,
        BetaCapabilitySupport|array $low,
        BetaCapabilitySupport|array $max,
        BetaCapabilitySupport|array $medium,
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
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape $high
     */
    public function withHigh(BetaCapabilitySupport|array $high): self
    {
        $self = clone $this;
        $self['high'] = $high;

        return $self;
    }

    /**
     * Whether the model supports low effort level.
     *
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape $low
     */
    public function withLow(BetaCapabilitySupport|array $low): self
    {
        $self = clone $this;
        $self['low'] = $low;

        return $self;
    }

    /**
     * Whether the model supports max effort level.
     *
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape $max
     */
    public function withMax(BetaCapabilitySupport|array $max): self
    {
        $self = clone $this;
        $self['max'] = $max;

        return $self;
    }

    /**
     * Whether the model supports medium effort level.
     *
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape $medium
     */
    public function withMedium(BetaCapabilitySupport|array $medium): self
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
