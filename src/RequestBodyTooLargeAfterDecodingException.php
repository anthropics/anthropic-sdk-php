<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\ContentTooLargeException;
use Anthropic\Core\Util;

/**
 * The compressed request body exceeds the request size limit once decoded.
 */
final class RequestBodyTooLargeAfterDecodingException extends ContentTooLargeException
{
    /** @var string */
    protected const DESC = 'Anthropic Request Body Too Large After Decoding Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'request_body_too_large_after_decoding'
     */
    public function getErrorCode(): string
    {
        return 'request_body_too_large_after_decoding';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): RequestBodyTooLargeAfterDecodingErrorDetails
    {
        $details = Conversion::coerce(
            RequestBodyTooLargeAfterDecodingErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof RequestBodyTooLargeAfterDecodingErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
