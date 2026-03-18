<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Thinking capability details.
 *
 * @phpstan-import-type ThinkingTypesShape from \Anthropic\Models\ThinkingTypes
 *
 * @phpstan-type ThinkingCapabilityShape = array{
 *   supported: bool, types: ThinkingTypes|ThinkingTypesShape
 * }
 */
final class ThinkingCapability implements BaseModel
{
    /** @use SdkModel<ThinkingCapabilityShape> */
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
    public ThinkingTypes $types;

    /**
     * `new ThinkingCapability()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ThinkingCapability::with(supported: ..., types: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ThinkingCapability)->withSupported(...)->withTypes(...)
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
     * @param ThinkingTypes|ThinkingTypesShape $types
     */
    public static function with(
        bool $supported,
        ThinkingTypes|array $types
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
     * @param ThinkingTypes|ThinkingTypesShape $types
     */
    public function withTypes(ThinkingTypes|array $types): self
    {
        $self = clone $this;
        $self['types'] = $types;

        return $self;
    }
}
