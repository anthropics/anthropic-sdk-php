<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The request body is not valid for its `Content-Encoding`.
 *
 * @phpstan-type RequestBodyEncodingInvalidErrorDetailsShape = array{
 *   errorCode: 'request_body_encoding_invalid'
 * }
 */
final class RequestBodyEncodingInvalidErrorDetails implements BaseModel
{
    /** @use SdkModel<RequestBodyEncodingInvalidErrorDetailsShape> */
    use SdkModel;

    /** @var 'request_body_encoding_invalid' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('request_body_encoding_invalid')
    )]
    public string $errorCode = 'request_body_encoding_invalid';

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
     * @param 'request_body_encoding_invalid' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
