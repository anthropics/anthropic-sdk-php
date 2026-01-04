<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaSignatureDeltaShape = array{
 *   signature: string, type: 'signature_delta'
 * }
 */
final class BetaSignatureDelta implements BaseModel
{
    /** @use SdkModel<BetaSignatureDeltaShape> */
    use SdkModel;

    /** @var 'signature_delta' $type */
    #[Required]
    public string $type = 'signature_delta';

    #[Required]
    public string $signature;

    /**
     * `new BetaSignatureDelta()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaSignatureDelta::with(signature: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaSignatureDelta)->withSignature(...)
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
    public static function with(string $signature): self
    {
        $self = new self;

        $self['signature'] = $signature;

        return $self;
    }

    public function withSignature(string $signature): self
    {
        $self = clone $this;
        $self['signature'] = $signature;

        return $self;
    }
}
