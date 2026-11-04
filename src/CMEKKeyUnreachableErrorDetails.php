<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The workspace's customer-managed encryption key could not be reached. Retry the request; if this continues, check that the key is available in your key management service, or contact Anthropic support.
 *
 * @phpstan-type CMEKKeyUnreachableErrorDetailsShape = array{
 *   errorCode: 'cmek_key_unreachable'
 * }
 */
final class CMEKKeyUnreachableErrorDetails implements BaseModel
{
    /** @use SdkModel<CMEKKeyUnreachableErrorDetailsShape> */
    use SdkModel;

    /** @var 'cmek_key_unreachable' $errorCode */
    #[Required('error_code', type: new ConstantOf('cmek_key_unreachable'))]
    public string $errorCode = 'cmek_key_unreachable';

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
     * @param 'cmek_key_unreachable' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
