<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\PaymentRequiredException;
use Anthropic\Core\Util;

/**
 * Anthropic cannot currently bill the organization linked to the request's user profile, for a reason that lies with that organization's own account. The response does not say what the reason is.
 */
final class LinkedOrganizationBillingUnavailableException extends PaymentRequiredException
{
    /** @var string */
    protected const DESC = 'Anthropic Linked Organization Billing Unavailable Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'linked_organization_billing_unavailable'
     */
    public function getErrorCode(): string
    {
        return 'linked_organization_billing_unavailable';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): LinkedOrganizationBillingUnavailableErrorDetails
    {
        $details = Conversion::coerce(
            LinkedOrganizationBillingUnavailableErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof LinkedOrganizationBillingUnavailableErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
