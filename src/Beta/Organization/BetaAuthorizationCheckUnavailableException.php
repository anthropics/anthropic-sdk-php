<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\ServiceUnavailableException;
use Anthropic\Core\Util;

/**
 * One of the organization's approvals from Anthropic could not be read right now, so nothing was done. Retry after the `Retry-After` delay.
 */
final class BetaAuthorizationCheckUnavailableException extends ServiceUnavailableException
{
    /** @var string */
    protected const DESC = 'Anthropic Beta Authorization Check Unavailable Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'authorization_check_unavailable'
     */
    public function getErrorCode(): string
    {
        return 'authorization_check_unavailable';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): BetaAuthorizationCheckUnavailableErrorDetails
    {
        $details = Conversion::coerce(
            BetaAuthorizationCheckUnavailableErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof BetaAuthorizationCheckUnavailableErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
