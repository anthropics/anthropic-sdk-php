<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The request body did not finish arriving in time, so nothing was done. Send a smaller body, or send it over a faster connection.
 */
final class BetaRequestBodyTimeoutException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Beta Request Body Timeout Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'request_body_timeout'
     */
    public function getErrorCode(): string
    {
        return 'request_body_timeout';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): BetaRequestBodyTimeoutErrorDetails
    {
        $details = Conversion::coerce(
            BetaRequestBodyTimeoutErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof BetaRequestBodyTimeoutErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
