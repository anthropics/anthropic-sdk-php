<?php

declare(strict_types=1);

namespace Anthropic\Beta\Models;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Thinking capability details.
 *
 * @phpstan-import-type BetaThinkingTypesShape from \Anthropic\Beta\Models\BetaThinkingTypes
 *
 * @phpstan-type BetaThinkingCapabilityShape = array{
 *   supported: bool, types: BetaThinkingTypes|BetaThinkingTypesShape
 * }
 */
final class BetaThinkingCapability implements BaseModel
{
    /** @use SdkModel<BetaThinkingCapabilityShape> */
    use SdkModel;

    /**
     * Whether this capability is supported by the model.
     */
    #[Required]
    public bool $supported;

    /**
     * Supported thinking type configurations.
     */
    #[Required]
    public BetaThinkingTypes $types;

    /**
     * `new BetaThinkingCapability()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaThinkingCapability::with(supported: ..., types: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaThinkingCapability)->withSupported(...)->withTypes(...)
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
     * @param BetaThinkingTypes|BetaThinkingTypesShape $types
     */
    public static function with(
        bool $supported,
        BetaThinkingTypes|array $types
    ): self {
        $self = new self;

        $self['supported'] = $supported;
        $self['types'] = $types;

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

    /**
     * Supported thinking type configurations.
     *
     * @param BetaThinkingTypes|BetaThinkingTypesShape $types
     */
    public function withTypes(BetaThinkingTypes|array $types): self
    {
        $self = clone $this;
        $self['types'] = $types;

        return $self;
    }
}
