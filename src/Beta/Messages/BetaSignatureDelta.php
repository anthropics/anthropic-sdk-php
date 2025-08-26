<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_signature_delta = array{signature: string, type: string}
 */
final class BetaSignatureDelta implements BaseModel
{
    /** @use SdkModel<beta_signature_delta> */
    use SdkModel;

    #[Api]
    public string $type = 'signature_delta';

    #[Api]
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
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(string $signature): self
    {
        $obj = new self;

        $obj->signature = $signature;

        return $obj;
    }

    public function withSignature(string $signature): self
    {
        $obj = clone $this;
        $obj->signature = $signature;

        return $obj;
    }
}
