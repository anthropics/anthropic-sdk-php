<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The request's `Content-Type` header names a charset other than UTF-8, ISO-8859-1 or US-ASCII. Send the request with no charset, or with one of these.
 */
final class BetaUnsupportedCharsetException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Beta Unsupported Charset Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'unsupported_charset'
     */
    public function getErrorCode(): string
    {
        return 'unsupported_charset';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): BetaUnsupportedCharsetErrorDetails
    {
        $details = Conversion::coerce(
            BetaUnsupportedCharsetErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof BetaUnsupportedCharsetErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
