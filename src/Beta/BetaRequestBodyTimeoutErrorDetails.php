<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The request body did not finish arriving in time, so nothing was done. Send a smaller body, or send it over a faster connection.
 *
 * @phpstan-type BetaRequestBodyTimeoutErrorDetailsShape = array{
 *   errorCode: 'request_body_timeout'
 * }
 */
final class BetaRequestBodyTimeoutErrorDetails implements BaseModel
{
    /** @use SdkModel<BetaRequestBodyTimeoutErrorDetailsShape> */
    use SdkModel;

    /** @var 'request_body_timeout' $errorCode */
    #[Required('error_code', type: new ConstantOf('request_body_timeout'))]
    public string $errorCode = 'request_body_timeout';

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
     * @param 'request_body_timeout' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
