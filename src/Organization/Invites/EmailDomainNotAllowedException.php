<?php

declare(strict_types=1);

namespace Anthropic\Organization\Invites;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The organization restricts invites to an allowed list of email domains, and the list is empty or does not include the email address's domain.
 */
final class EmailDomainNotAllowedException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Email Domain Not Allowed Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'email_domain_not_allowed'
     */
    public function getErrorCode(): string
    {
        return 'email_domain_not_allowed';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): EmailDomainNotAllowedErrorDetails
    {
        $details = Conversion::coerce(
            EmailDomainNotAllowedErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof EmailDomainNotAllowedErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
