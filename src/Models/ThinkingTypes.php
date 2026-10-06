<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Which `thinking.type` values the model accepts on requests. Read each key on its own: for example, `enabled` can be false while `disabled` is true.
 *
 * @phpstan-import-type CapabilitySupportShape from \Anthropic\Models\CapabilitySupport
 *
 * @phpstan-type ThinkingTypesShape = array{
 *   adaptive: CapabilitySupport|CapabilitySupportShape,
 *   disabled: CapabilitySupport|CapabilitySupportShape,
 *   enabled: CapabilitySupport|CapabilitySupportShape,
 * }
 */
final class ThinkingTypes implements BaseModel
{
    /** @use SdkModel<ThinkingTypesShape> */
    use SdkModel;

    /**
     * Whether the model accepts thinking with type 'adaptive' (the model decides whether and how much to think).
     */
    #[Required]
    public CapabilitySupport $adaptive;

    /**
     * Whether the model accepts thinking with type 'disabled' (thinking turned off). False exactly when a request that sends it gets a 400 from this model. True on a model that does not support thinking.
     */
    #[Required]
    public CapabilitySupport $disabled;

    /**
     * Whether the model accepts thinking with type 'enabled' (extended thinking with a caller-set `budget_tokens`).
     */
    #[Required]
    public CapabilitySupport $enabled;

    /**
     * `new ThinkingTypes()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ThinkingTypes::with(adaptive: ..., disabled: ..., enabled: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ThinkingTypes())->withAdaptive(...)->withDisabled(...)->withEnabled(...)
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
     * @param CapabilitySupport|CapabilitySupportShape $disabled
     * @param CapabilitySupport|CapabilitySupportShape $enabled
     */
    public static function with(
        CapabilitySupport|array $adaptive,
        CapabilitySupport|array $disabled,
        CapabilitySupport|array $enabled,
    ): self {
        $self = new self;

        $self['adaptive'] = $adaptive;
        $self['disabled'] = $disabled;
        $self['enabled'] = $enabled;

        return $self;
    }

    /**
     * Whether the model accepts thinking with type 'adaptive' (the model decides whether and how much to think).
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
     * Whether the model accepts thinking with type 'disabled' (thinking turned off). False exactly when a request that sends it gets a 400 from this model. True on a model that does not support thinking.
     *
     * @param CapabilitySupport|CapabilitySupportShape $disabled
     */
    public function withDisabled(CapabilitySupport|array $disabled): self
    {
        $self = clone $this;
        $self['disabled'] = $disabled;

        return $self;
    }

    /**
     * Whether the model accepts thinking with type 'enabled' (extended thinking with a caller-set `budget_tokens`).
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
