<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Supported thinking type configurations.
 *
 * @phpstan-import-type CapabilitySupportShape from \Anthropic\Models\CapabilitySupport
 *
 * @phpstan-type ThinkingTypesShape = array{
 *   adaptive: CapabilitySupport|CapabilitySupportShape,
 *   enabled: CapabilitySupport|CapabilitySupportShape,
 * }
 */
final class ThinkingTypes implements BaseModel
{
    /** @use SdkModel<ThinkingTypesShape> */
    use SdkModel;

    /**
     * Whether the model supports thinking with type 'adaptive' (auto).
     */
    #[Required]
    public CapabilitySupport $adaptive;

    /**
     * Whether the model supports thinking with type 'enabled'.
     */
    #[Required]
    public CapabilitySupport $enabled;

    /**
     * `new ThinkingTypes()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ThinkingTypes::with(adaptive: ..., enabled: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ThinkingTypes)->withAdaptive(...)->withEnabled(...)
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
     * @param CapabilitySupport|CapabilitySupportShape $adaptive
     * @param CapabilitySupport|CapabilitySupportShape $enabled
     */
    public static function with(
        CapabilitySupport|array $adaptive,
        CapabilitySupport|array $enabled
    ): self {
        $self = new self;

        $self['adaptive'] = $adaptive;
        $self['enabled'] = $enabled;

        return $self;
    }

    /**
     * Whether the model supports thinking with type 'adaptive' (auto).
     *
     * @param CapabilitySupport|CapabilitySupportShape $adaptive
     */
    public function withAdaptive(CapabilitySupport|array $adaptive): self
    {
        $self = clone $this;
        $self['adaptive'] = $adaptive;

        return $self;
    }

    /**
     * Whether the model supports thinking with type 'enabled'.
     *
     * @param CapabilitySupport|CapabilitySupportShape $enabled
     */
    public function withEnabled(CapabilitySupport|array $enabled): self
    {
        $self = clone $this;
        $self['enabled'] = $enabled;

        return $self;
    }
}
