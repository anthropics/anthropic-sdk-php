<?php

declare(strict_types=1);

namespace Anthropic\Beta\Models;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Indicates whether a capability is supported.
 *
 * @phpstan-type BetaCapabilitySupportShape = array{supported: bool}
 */
final class BetaCapabilitySupport implements BaseModel
{
    /** @use SdkModel<BetaCapabilitySupportShape> */
    use SdkModel;

    /**
     * Whether this capability is supported by the model.
     */
    #[Required]
    public bool $supported;

    /**
     * `new BetaCapabilitySupport()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaCapabilitySupport::with(supported: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaCapabilitySupport)->withSupported(...)
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
     */
    public static function with(bool $supported): self
    {
        $self = new self;

        $self['supported'] = $supported;

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
