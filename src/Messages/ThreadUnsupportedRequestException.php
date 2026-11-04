<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The request combines `thread` with a request field or an organization setting that Threads do not support; `unsupported`, when present, names it. Send the full conversation without `thread`, or change that field.
 */
final class ThreadUnsupportedRequestException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Thread Unsupported Request Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'thread_unsupported_request'
     */
    public function getErrorCode(): string
    {
        return 'thread_unsupported_request';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): ThreadUnsupportedRequestErrorDetails
    {
        $details = Conversion::coerce(
            ThreadUnsupportedRequestErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof ThreadUnsupportedRequestErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
