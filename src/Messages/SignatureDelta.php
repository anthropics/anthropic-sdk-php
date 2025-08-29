<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type signature_delta = array{signature: string, type: string}
 */
final class SignatureDelta implements BaseModel
{
    /** @use SdkModel<signature_delta> */
    use SdkModel;

    #[Api]
    public string $type = 'signature_delta';

    #[Api]
    public string $signature;

    /**
     * `new SignatureDelta()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SignatureDelta::with(signature: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SignatureDelta)->withSignature(...)
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
