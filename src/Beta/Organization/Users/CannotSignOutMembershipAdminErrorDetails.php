<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Users;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The member is a membership admin, and the person the API key or token belongs to is not allowed to sign out membership admins.
 *
 * @phpstan-type CannotSignOutMembershipAdminErrorDetailsShape = array{
 *   errorCode: 'cannot_sign_out_membership_admin'
 * }
 */
final class CannotSignOutMembershipAdminErrorDetails implements BaseModel
{
    /** @use SdkModel<CannotSignOutMembershipAdminErrorDetailsShape> */
    use SdkModel;

    /** @var 'cannot_sign_out_membership_admin' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('cannot_sign_out_membership_admin')
    )]
    public string $errorCode = 'cannot_sign_out_membership_admin';

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
     * @param 'cannot_sign_out_membership_admin' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
