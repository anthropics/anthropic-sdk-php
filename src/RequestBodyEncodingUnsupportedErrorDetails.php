<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The request's `Content-Encoding` is not supported.
 *
 * @phpstan-type RequestBodyEncodingUnsupportedErrorDetailsShape = array{
 *   errorCode: 'request_body_encoding_unsupported'
 * }
 */
final class RequestBodyEncodingUnsupportedErrorDetails implements BaseModel
{
    /** @use SdkModel<RequestBodyEncodingUnsupportedErrorDetailsShape> */
    use SdkModel;

    /** @var 'request_body_encoding_unsupported' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('request_body_encoding_unsupported')
    )]
    public string $errorCode = 'request_body_encoding_unsupported';

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
     * @param 'request_body_encoding_unsupported' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
