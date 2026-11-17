<?php

declare(strict_types=1);

namespace Anthropic\UserProfiles;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The request sets `billing_policy.bill_to` to `"user_profile"` but names no user profile. Name the profile to bill in the `anthropic-user-profile-id` header.
 *
 * @phpstan-type UserProfileRequiredErrorDetailsShape = array{
 *   errorCode: 'user_profile_required'
 * }
 */
final class UserProfileRequiredErrorDetails implements BaseModel
{
    /** @use SdkModel<UserProfileRequiredErrorDetailsShape> */
    use SdkModel;

    /** @var 'user_profile_required' $errorCode */
    #[Required('error_code', type: new ConstantOf('user_profile_required'))]
    public string $errorCode = 'user_profile_required';

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
     * @param 'user_profile_required' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
