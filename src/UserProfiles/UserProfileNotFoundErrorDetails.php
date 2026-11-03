<?php

declare(strict_types=1);

namespace Anthropic\UserProfiles;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The request depends on a user profile that does not exist in the organization or is no longer active. The request either names this user profile by ID, or names a resource, such as an External Key, that is bound to it.
 *
 * @phpstan-type UserProfileNotFoundErrorDetailsShape = array{
 *   errorCode: 'user_profile_not_found'
 * }
 */
final class UserProfileNotFoundErrorDetails implements BaseModel
{
    /** @use SdkModel<UserProfileNotFoundErrorDetailsShape> */
    use SdkModel;

    /** @var 'user_profile_not_found' $errorCode */
    #[Required('error_code', type: new ConstantOf('user_profile_not_found'))]
    public string $errorCode = 'user_profile_not_found';

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
     * @param 'user_profile_not_found' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
