<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The compressed request body exceeds the request size limit once decoded.
 *
 * @phpstan-type RequestBodyTooLargeAfterDecodingErrorDetailsShape = array{
 *   errorCode: 'request_body_too_large_after_decoding'
 * }
 */
final class RequestBodyTooLargeAfterDecodingErrorDetails implements BaseModel
{
    /** @use SdkModel<RequestBodyTooLargeAfterDecodingErrorDetailsShape> */
    use SdkModel;

    /** @var 'request_body_too_large_after_decoding' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('request_body_too_large_after_decoding')
    )]
    public string $errorCode = 'request_body_too_large_after_decoding';

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
     * @param 'request_body_too_large_after_decoding' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
