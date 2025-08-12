<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_signature_delta_alias = array{
 *   signature: string, type: string
 * }
 */
final class BetaSignatureDelta implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'signature_delta';

    #[Api]
    public string $signature;

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
    public static function from(string $signature): self
    {
        $obj = new self;

        $obj->signature = $signature;

        return $obj;
    }

    public function setSignature(string $signature): self
    {
        $this->signature = $signature;

        return $this;
    }
}
