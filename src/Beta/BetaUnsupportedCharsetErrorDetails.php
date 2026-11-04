<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The request's `Content-Type` header names a charset other than UTF-8, ISO-8859-1 or US-ASCII. Send the request with no charset, or with one of these.
 *
 * @phpstan-type BetaUnsupportedCharsetErrorDetailsShape = array{
 *   errorCode: 'unsupported_charset'
 * }
 */
final class BetaUnsupportedCharsetErrorDetails implements BaseModel
{
    /** @use SdkModel<BetaUnsupportedCharsetErrorDetailsShape> */
    use SdkModel;

    /** @var 'unsupported_charset' $errorCode */
    #[Required('error_code', type: new ConstantOf('unsupported_charset'))]
    public string $errorCode = 'unsupported_charset';

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
     * @param 'unsupported_charset' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
