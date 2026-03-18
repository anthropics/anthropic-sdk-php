<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Indicates whether a capability is supported.
 *
 * @phpstan-type CapabilitySupportShape = array{supported: bool}
 */
final class CapabilitySupport implements BaseModel
{
    /** @use SdkModel<CapabilitySupportShape> */
    use SdkModel;

    /**
     * Whether this capability is supported by the model.
     */
    #[Required]
    public bool $supported;

    /**
     * `new CapabilitySupport()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CapabilitySupport::with(supported: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CapabilitySupport)->withSupported(...)
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
