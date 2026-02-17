<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type CitationsConfigShape = array{enabled: bool}
 */
final class CitationsConfig implements BaseModel
{
    /** @use SdkModel<CitationsConfigShape> */
    use SdkModel;

    #[Required]
    public bool $enabled;

    /**
     * `new CitationsConfig()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CitationsConfig::with(enabled: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CitationsConfig)->withEnabled(...)
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
