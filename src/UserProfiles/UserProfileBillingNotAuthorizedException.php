<?php

declare(strict_types=1);

namespace Anthropic\UserProfiles;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\PermissionDeniedException;
use Anthropic\Core\Util;

/**
 * The customer that the named user profile represents has not authorized the caller to bill them, or the authorization that the request's credential uses has ended. The response does not say which applies.
 */
final class UserProfileBillingNotAuthorizedException extends PermissionDeniedException
{
    /** @var string */
    protected const DESC = 'Anthropic User Profile Billing Not Authorized Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'user_profile_billing_not_authorized'
     */
    public function getErrorCode(): string
    {
        return 'user_profile_billing_not_authorized';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): UserProfileBillingNotAuthorizedErrorDetails
    {
        $details = Conversion::coerce(
            UserProfileBillingNotAuthorizedErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof UserProfileBillingNotAuthorizedErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
