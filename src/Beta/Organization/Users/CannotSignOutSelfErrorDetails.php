<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Users;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The member is the user the API key or token belongs to.
 *
 * @phpstan-type CannotSignOutSelfErrorDetailsShape = array{
 *   errorCode: 'cannot_sign_out_self'
 * }
 */
final class CannotSignOutSelfErrorDetails implements BaseModel
{
    /** @use SdkModel<CannotSignOutSelfErrorDetailsShape> */
    use SdkModel;

    /** @var 'cannot_sign_out_self' $errorCode */
    #[Required('error_code', type: new ConstantOf('cannot_sign_out_self'))]
    public string $errorCode = 'cannot_sign_out_self';

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
     * @param 'cannot_sign_out_self' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
