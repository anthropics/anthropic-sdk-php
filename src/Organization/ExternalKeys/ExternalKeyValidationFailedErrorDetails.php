<?php

declare(strict_types=1);

namespace Anthropic\Organization\ExternalKeys;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The External Key failed Anthropic's validation, so the request was refused. The message gives the reason, if there is one.
 *
 * @phpstan-type ExternalKeyValidationFailedErrorDetailsShape = array{
 *   errorCode: 'external_key_validation_failed'
 * }
 */
final class ExternalKeyValidationFailedErrorDetails implements BaseModel
{
    /** @use SdkModel<ExternalKeyValidationFailedErrorDetailsShape> */
    use SdkModel;

    /** @var 'external_key_validation_failed' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('external_key_validation_failed')
    )]
    public string $errorCode = 'external_key_validation_failed';

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
     * @param 'external_key_validation_failed' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
