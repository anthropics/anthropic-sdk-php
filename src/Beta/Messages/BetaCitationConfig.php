<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaCitationConfigShape = array{enabled: bool}
 */
final class BetaCitationConfig implements BaseModel
{
    /** @use SdkModel<BetaCitationConfigShape> */
    use SdkModel;

    #[Required]
    public bool $enabled;

    /**
     * `new BetaCitationConfig()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaCitationConfig::with(enabled: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaCitationConfig)->withEnabled(...)
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
    public static function with(bool $enabled = false): self
    {
        $self = new self;

        $self['enabled'] = $enabled;

        return $self;
    }

    public function withEnabled(bool $enabled): self
    {
        $self = clone $this;
        $self['enabled'] = $enabled;

        return $self;
    }
}
