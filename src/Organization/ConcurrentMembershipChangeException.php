<?php

declare(strict_types=1);

namespace Anthropic\Organization;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\ConflictException;
use Anthropic\Core\Util;

/**
 * Another change to the organization's members is in progress. Retry the request once it completes.
 */
final class ConcurrentMembershipChangeException extends ConflictException
{
    /** @var string */
    protected const DESC = 'Anthropic Concurrent Membership Change Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'concurrent_membership_change'
     */
    public function getErrorCode(): string
    {
        return 'concurrent_membership_change';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): ConcurrentMembershipChangeErrorDetails
    {
        $details = Conversion::coerce(
            ConcurrentMembershipChangeErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof ConcurrentMembershipChangeErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
