<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The response that `previous_message_id` names has already been continued, and each response can be continued only once. Continue from the Thread's most recent response `id`.
 */
final class ThreadAlreadyContinuedException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Thread Already Continued Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'thread_already_continued'
     */
    public function getErrorCode(): string
    {
        return 'thread_already_continued';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): ThreadAlreadyContinuedErrorDetails
    {
        $details = Conversion::coerce(
            ThreadAlreadyContinuedErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof ThreadAlreadyContinuedErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
