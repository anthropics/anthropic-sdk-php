<?php

declare(strict_types=1);

namespace Anthropic\Organization\Invites;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The email address's domain is not one of the verified domains of the organization's parent organization.
 */
final class CannotInviteEmailsWithUnverifiedDomainsException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Cannot Invite Emails With Unverified Domains Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'cannot_invite_emails_with_unverified_domains'
     */
    public function getErrorCode(): string
    {
        return 'cannot_invite_emails_with_unverified_domains';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): CannotInviteEmailsWithUnverifiedDomainsErrorDetails
    {
        $details = Conversion::coerce(
            CannotInviteEmailsWithUnverifiedDomainsErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof CannotInviteEmailsWithUnverifiedDomainsErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
