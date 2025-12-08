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
        $obj = new self;

        $obj['enabled'] = $enabled;

        return $obj;
    }

    public function withEnabled(bool $enabled): self
    {
        $obj = clone $this;
        $obj['enabled'] = $enabled;

        return $obj;
    }
}
