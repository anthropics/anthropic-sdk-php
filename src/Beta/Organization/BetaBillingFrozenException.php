<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\PermissionDeniedException;
use Anthropic\Core\Util;

/**
 * Anthropic has temporarily disabled billing changes for the user account the credential belongs to. Contact support.
 */
final class BetaBillingFrozenException extends PermissionDeniedException
{
    /** @var string */
    protected const DESC = 'Anthropic Beta Billing Frozen Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'billing_frozen'
     */
    public function getErrorCode(): string
    {
        return 'billing_frozen';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): BetaBillingFrozenErrorDetails
    {
        $details = Conversion::coerce(
            BetaBillingFrozenErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof BetaBillingFrozenErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
