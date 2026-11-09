<?php

declare(strict_types=1);

namespace Anthropic\UserProfiles;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The request depends on a user profile that does not exist in the organization or is no longer active. The request either names this user profile by ID, or names a resource, such as an External Key, that is bound to it.
 */
final class UserProfileNotFoundException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic User Profile Not Found Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'user_profile_not_found'
     */
    public function getErrorCode(): string
    {
        return 'user_profile_not_found';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): UserProfileNotFoundErrorDetails
    {
        $details = Conversion::coerce(
            UserProfileNotFoundErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof UserProfileNotFoundErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
