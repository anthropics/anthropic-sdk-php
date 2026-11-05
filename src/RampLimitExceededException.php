<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\RateLimitException;
use Anthropic\Core\Util;

/**
 * The request would exceed a ramp limit, which caps how fast usage can grow. Retry after the time in the `retry-after` header.
 */
final class RampLimitExceededException extends RateLimitException
{
    /** @var string */
    protected const DESC = 'Anthropic Ramp Limit Exceeded Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'ramp_limit_exceeded'
     */
    public function getErrorCode(): string
    {
        return 'ramp_limit_exceeded';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): RampLimitExceededErrorDetails
    {
        $details = Conversion::coerce(
            RampLimitExceededErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof RampLimitExceededErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
