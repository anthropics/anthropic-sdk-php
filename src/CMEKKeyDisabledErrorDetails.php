<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The workspace's customer-managed encryption key is disabled or revoked. Re-enable the key, then retry.
 *
 * @phpstan-type CMEKKeyDisabledErrorDetailsShape = array{
 *   errorCode: 'cmek_key_disabled'
 * }
 */
final class CMEKKeyDisabledErrorDetails implements BaseModel
{
    /** @use SdkModel<CMEKKeyDisabledErrorDetailsShape> */
    use SdkModel;

    /** @var 'cmek_key_disabled' $errorCode */
    #[Required('error_code', type: new ConstantOf('cmek_key_disabled'))]
    public string $errorCode = 'cmek_key_disabled';

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(): self
    {
        return new self;
    }

    /**
     * @param 'cmek_key_disabled' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
