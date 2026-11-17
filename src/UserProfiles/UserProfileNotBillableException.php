<?php

declare(strict_types=1);

namespace Anthropic\UserProfiles;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\PermissionDeniedException;
use Anthropic\Core\Util;

/**
 * The caller is not allowed to bill the user profile that the request names. The response gives no more specific error code and does not say what the reason is.
 */
final class UserProfileNotBillableException extends PermissionDeniedException
{
    /** @var string */
    protected const DESC = 'Anthropic User Profile Not Billable Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'user_profile_not_billable'
     */
    public function getErrorCode(): string
    {
        return 'user_profile_not_billable';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): UserProfileNotBillableErrorDetails
    {
        $details = Conversion::coerce(
            UserProfileNotBillableErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof UserProfileNotBillableErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
