<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The request's `Content-Encoding` is not supported.
 */
final class RequestBodyEncodingUnsupportedException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Request Body Encoding Unsupported Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'request_body_encoding_unsupported'
     */
    public function getErrorCode(): string
    {
        return 'request_body_encoding_unsupported';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): RequestBodyEncodingUnsupportedErrorDetails
    {
        $details = Conversion::coerce(
            RequestBodyEncodingUnsupportedErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof RequestBodyEncodingUnsupportedErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
