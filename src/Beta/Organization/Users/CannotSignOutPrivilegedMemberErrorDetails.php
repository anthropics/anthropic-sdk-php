<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Users;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * This OAuth token cannot sign out a membership admin or a member whose roles grant owner, user management, or identity and access management.
 *
 * @phpstan-type CannotSignOutPrivilegedMemberErrorDetailsShape = array{
 *   errorCode: 'cannot_sign_out_privileged_member'
 * }
 */
final class CannotSignOutPrivilegedMemberErrorDetails implements BaseModel
{
    /** @use SdkModel<CannotSignOutPrivilegedMemberErrorDetailsShape> */
    use SdkModel;

    /** @var 'cannot_sign_out_privileged_member' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('cannot_sign_out_privileged_member')
    )]
    public string $errorCode = 'cannot_sign_out_privileged_member';

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
     * @param 'cannot_sign_out_privileged_member' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
