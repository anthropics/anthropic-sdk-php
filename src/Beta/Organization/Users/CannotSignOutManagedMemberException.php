<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Users;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\PermissionDeniedException;
use Anthropic\Core\Util;

/**
 * The member has the `managed` role, and this API key or token cannot sign them out. The error message says which keys and tokens can.
 */
final class CannotSignOutManagedMemberException extends PermissionDeniedException
{
    /** @var string */
    protected const DESC = 'Anthropic Cannot Sign Out Managed Member Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'cannot_sign_out_managed_member'
     */
    public function getErrorCode(): string
    {
        return 'cannot_sign_out_managed_member';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): CannotSignOutManagedMemberErrorDetails
    {
        $details = Conversion::coerce(
            CannotSignOutManagedMemberErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof CannotSignOutManagedMemberErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
