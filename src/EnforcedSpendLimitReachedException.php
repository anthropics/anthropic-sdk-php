<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\RateLimitException;
use Anthropic\Core\Util;

/**
 * The organization has crossed the monthly API usage threshold of its API tier.
 */
final class EnforcedSpendLimitReachedException extends RateLimitException
{
    /** @var string */
    protected const DESC = 'Anthropic Enforced Spend Limit Reached Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'enforced_spend_limit_reached'
     */
    public function getErrorCode(): string
    {
        return 'enforced_spend_limit_reached';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): EnforcedSpendLimitReachedErrorDetails
    {
        $details = Conversion::coerce(
            EnforcedSpendLimitReachedErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof EnforcedSpendLimitReachedErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
