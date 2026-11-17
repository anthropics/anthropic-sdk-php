<?php

declare(strict_types=1);

namespace Anthropic\UserProfiles;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The caller is not allowed to bill the user profile that the request names. The response gives no more specific error code and does not say what the reason is.
 *
 * @phpstan-type UserProfileNotBillableErrorDetailsShape = array{
 *   errorCode: 'user_profile_not_billable'
 * }
 */
final class UserProfileNotBillableErrorDetails implements BaseModel
{
    /** @use SdkModel<UserProfileNotBillableErrorDetailsShape> */
    use SdkModel;

    /** @var 'user_profile_not_billable' $errorCode */
    #[Required('error_code', type: new ConstantOf('user_profile_not_billable'))]
    public string $errorCode = 'user_profile_not_billable';

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
     * @param 'user_profile_not_billable' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
