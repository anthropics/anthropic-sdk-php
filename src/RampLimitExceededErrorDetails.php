<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The request would exceed a ramp limit, which caps how fast usage can grow. Retry after the time in the `retry-after` header.
 *
 * @phpstan-type RampLimitExceededErrorDetailsShape = array{
 *   errorCode: 'ramp_limit_exceeded'
 * }
 */
final class RampLimitExceededErrorDetails implements BaseModel
{
    /** @use SdkModel<RampLimitExceededErrorDetailsShape> */
    use SdkModel;

    /** @var 'ramp_limit_exceeded' $errorCode */
    #[Required('error_code', type: new ConstantOf('ramp_limit_exceeded'))]
    public string $errorCode = 'ramp_limit_exceeded';

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
     * @param 'ramp_limit_exceeded' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
