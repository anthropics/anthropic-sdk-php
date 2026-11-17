<?php

declare(strict_types=1);

namespace Anthropic\UserProfiles;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The request sets `billing_policy.bill_to` to `"user_profile"` but names no user profile. Name the profile to bill in the `anthropic-user-profile-id` header.
 */
final class UserProfileRequiredException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic User Profile Required Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'user_profile_required'
     */
    public function getErrorCode(): string
    {
        return 'user_profile_required';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): UserProfileRequiredErrorDetails
    {
        $details = Conversion::coerce(
            UserProfileRequiredErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof UserProfileRequiredErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
