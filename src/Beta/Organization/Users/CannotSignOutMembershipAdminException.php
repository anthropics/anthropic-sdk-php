<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Users;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\PermissionDeniedException;
use Anthropic\Core\Util;

/**
 * The member is a membership admin, and the person the API key or token belongs to is not allowed to sign out membership admins.
 */
final class CannotSignOutMembershipAdminException extends PermissionDeniedException
{
    /** @var string */
    protected const DESC = 'Anthropic Cannot Sign Out Membership Admin Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'cannot_sign_out_membership_admin'
     */
    public function getErrorCode(): string
    {
        return 'cannot_sign_out_membership_admin';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): CannotSignOutMembershipAdminErrorDetails
    {
        $details = Conversion::coerce(
            CannotSignOutMembershipAdminErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof CannotSignOutMembershipAdminErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
