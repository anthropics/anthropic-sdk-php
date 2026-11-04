<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The request body is not valid for its `Content-Encoding`.
 */
final class RequestBodyEncodingInvalidException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Request Body Encoding Invalid Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'request_body_encoding_invalid'
     */
    public function getErrorCode(): string
    {
        return 'request_body_encoding_invalid';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): RequestBodyEncodingInvalidErrorDetails
    {
        $details = Conversion::coerce(
            RequestBodyEncodingInvalidErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof RequestBodyEncodingInvalidErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
