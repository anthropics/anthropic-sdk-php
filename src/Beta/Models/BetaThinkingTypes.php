<?php

declare(strict_types=1);

namespace Anthropic\Beta\Models;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Supported thinking type configurations.
 *
 * @phpstan-import-type BetaCapabilitySupportShape from \Anthropic\Beta\Models\BetaCapabilitySupport
 *
 * @phpstan-type BetaThinkingTypesShape = array{
 *   adaptive: BetaCapabilitySupport|BetaCapabilitySupportShape,
 *   enabled: BetaCapabilitySupport|BetaCapabilitySupportShape,
 * }
 */
final class BetaThinkingTypes implements BaseModel
{
    /** @use SdkModel<BetaThinkingTypesShape> */
    use SdkModel;

    /**
     * Whether the model supports thinking with type 'adaptive' (auto).
     */
    #[Required]
    public BetaCapabilitySupport $adaptive;

    /**
     * Whether the model supports thinking with type 'enabled'.
     */
    #[Required]
    public BetaCapabilitySupport $enabled;

    /**
     * `new BetaThinkingTypes()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaThinkingTypes::with(adaptive: ..., enabled: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaThinkingTypes)->withAdaptive(...)->withEnabled(...)
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
     * @param BetaCapabilitySupport|BetaCapabilitySupportShape $enabled
     */
    public static function with(
        BetaCapabilitySupport|array $adaptive,
        BetaCapabilitySupport|array $enabled
    ): self {
        $self = new self;

        $self['adaptive'] = $adaptive;
        $self['enabled'] = $enabled;

        return $self;
    }

    /**
     * Whether the model supports thinking with type 'adaptive' (auto).
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
     * Whether the model supports thinking with type 'enabled'.
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
