<?php

declare(strict_types=1);

namespace Anthropic\Organization\ExternalKeys;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Anthropic's validation of the External Key did not finish in time, so the request was refused. Wait a moment, then send the request again.
 *
 * @phpstan-type ExternalKeyValidationTimedOutErrorDetailsShape = array{
 *   errorCode: 'external_key_validation_timed_out'
 * }
 */
final class ExternalKeyValidationTimedOutErrorDetails implements BaseModel
{
    /** @use SdkModel<ExternalKeyValidationTimedOutErrorDetailsShape> */
    use SdkModel;

    /** @var 'external_key_validation_timed_out' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('external_key_validation_timed_out')
    )]
    public string $errorCode = 'external_key_validation_timed_out';

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
     * @param 'external_key_validation_timed_out' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
