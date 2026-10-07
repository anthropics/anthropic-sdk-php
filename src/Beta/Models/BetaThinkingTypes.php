<?php

declare(strict_types=1);

namespace Anthropic\Beta\Models;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Which `thinking.type` values the model accepts on requests. Read each key on its own: for example, `enabled` can be false while `disabled` is true.
 *
 * @phpstan-import-type BetaCapabilitySupportShape from \Anthropic\Beta\Models\BetaCapabilitySupport
 *
 * @phpstan-type BetaThinkingTypesShape = array{
 *   adaptive: BetaCapabilitySupport|BetaCapabilitySupportShape,
 *   disabled: BetaCapabilitySupport|BetaCapabilitySupportShape,
 *   enabled: BetaCapabilitySupport|BetaCapabilitySupportShape,
 * }
 */
final class BetaThinkingTypes implements BaseModel
{
    /** @use SdkModel<BetaThinkingTypesShape> */
    use SdkModel;

    /**
     * Whether the model accepts thinking with type 'adaptive' (the model decides whether and how much to think).
     */
    #[Required]
    public BetaCapabilitySupport $adaptive;

    /**
     * Whether the model accepts thinking with type 'disabled' (thinking turned off). False exactly when a request that sends it gets a 400 from this model. True on a model that does not support thinking.
     */
    #[Required]
    public BetaCapabilitySupport $disabled;

    /**
     * Whether the model accepts thinking with type 'enabled' (extended thinking with a caller-set `budget_tokens`).
     */
    #[Required]
    public BetaCapabilitySupport $enabled;

    /**
     * `new BetaThinkingTypes()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaThinkingTypes::with(adaptive: ..., disabled: ..., enabled: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaThinkingTypes())
     *   ->withAdaptive(...)
     *   ->withDisabled(...)
     *   ->withEnabled(...)
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
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape $adaptive
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape $disabled
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape $enabled
     */
    public static function with(
        BetaCapabilitySupport|array $adaptive,
        BetaCapabilitySupport|array $disabled,
        BetaCapabilitySupport|array $enabled,
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
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape $adaptive
     */
    public function withAdaptive(BetaCapabilitySupport|array $adaptive): self
    {
        $self = clone $this;
        $self['adaptive'] = $adaptive;

        return $self;
    }

    /**
     * Whether the model accepts thinking with type 'disabled' (thinking turned off). False exactly when a request that sends it gets a 400 from this model. True on a model that does not support thinking.
     *
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape $disabled
     */
    public function withDisabled(BetaCapabilitySupport|array $disabled): self
    {
        $self = clone $this;
        $self['disabled'] = $disabled;

        return $self;
    }

    /**
     * Whether the model accepts thinking with type 'enabled' (extended thinking with a caller-set `budget_tokens`).
     *
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape $enabled
     */
    public function withEnabled(BetaCapabilitySupport|array $enabled): self
    {
        $self = clone $this;
        $self['enabled'] = $enabled;

        return $self;
    }
}
