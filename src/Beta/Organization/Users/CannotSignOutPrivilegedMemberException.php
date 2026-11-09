<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Users;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\PermissionDeniedException;
use Anthropic\Core\Util;

/**
 * This OAuth token cannot sign out a membership admin or a member whose roles grant owner, user management, or identity and access management.
 */
final class CannotSignOutPrivilegedMemberException extends PermissionDeniedException
{
    /** @var string */
    protected const DESC = 'Anthropic Cannot Sign Out Privileged Member Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'cannot_sign_out_privileged_member'
     */
    public function getErrorCode(): string
    {
        return 'cannot_sign_out_privileged_member';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): CannotSignOutPrivilegedMemberErrorDetails
    {
        $details = Conversion::coerce(
            CannotSignOutPrivilegedMemberErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof CannotSignOutPrivilegedMemberErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
