<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Users;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The member has the `managed` role, and this API key or token cannot sign them out. The error message says which keys and tokens can.
 *
 * @phpstan-type CannotSignOutManagedMemberErrorDetailsShape = array{
 *   errorCode: 'cannot_sign_out_managed_member'
 * }
 */
final class CannotSignOutManagedMemberErrorDetails implements BaseModel
{
    /** @use SdkModel<CannotSignOutManagedMemberErrorDetailsShape> */
    use SdkModel;

    /** @var 'cannot_sign_out_managed_member' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('cannot_sign_out_managed_member')
    )]
    public string $errorCode = 'cannot_sign_out_managed_member';

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
     * @param 'cannot_sign_out_managed_member' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
