<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * Another request is still continuing from the same `previous_message_id`. Wait for it to complete and continue from its response `id`, or replay the full conversation with `thread: {"type": "create"}`.
 */
final class ThreadContinueInFlightException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Thread Continue In Flight Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'thread_continue_in_flight'
     */
    public function getErrorCode(): string
    {
        return 'thread_continue_in_flight';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): ThreadContinueInFlightErrorDetails
    {
        $details = Conversion::coerce(
            ThreadContinueInFlightErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof ThreadContinueInFlightErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
