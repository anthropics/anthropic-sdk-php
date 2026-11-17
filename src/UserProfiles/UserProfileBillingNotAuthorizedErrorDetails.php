<?php

declare(strict_types=1);

namespace Anthropic\UserProfiles;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The customer that the named user profile represents has not authorized the caller to bill them, or the authorization that the request's credential uses has ended. The response does not say which applies.
 *
 * @phpstan-type UserProfileBillingNotAuthorizedErrorDetailsShape = array{
 *   errorCode: 'user_profile_billing_not_authorized'
 * }
 */
final class UserProfileBillingNotAuthorizedErrorDetails implements BaseModel
{
    /** @use SdkModel<UserProfileBillingNotAuthorizedErrorDetailsShape> */
    use SdkModel;

    /** @var 'user_profile_billing_not_authorized' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('user_profile_billing_not_authorized')
    )]
    public string $errorCode = 'user_profile_billing_not_authorized';

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
     * @param 'user_profile_billing_not_authorized' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
