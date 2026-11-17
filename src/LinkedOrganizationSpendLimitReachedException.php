<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\PaymentRequiredException;
use Anthropic\Core\Util;

/**
 * The organization linked to the request's user profile has reached a spend limit that it set, or lacks credit for the request. The response does not say which applies.
 */
final class LinkedOrganizationSpendLimitReachedException extends PaymentRequiredException
{
    /** @var string */
    protected const DESC = 'Anthropic Linked Organization Spend Limit Reached Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'linked_organization_spend_limit_reached'
     */
    public function getErrorCode(): string
    {
        return 'linked_organization_spend_limit_reached';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): LinkedOrganizationSpendLimitReachedErrorDetails
    {
        $details = Conversion::coerce(
            LinkedOrganizationSpendLimitReachedErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof LinkedOrganizationSpendLimitReachedErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
