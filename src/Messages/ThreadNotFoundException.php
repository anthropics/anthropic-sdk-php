<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\NotFoundException;
use Anthropic\Core\Util;

/**
 * No usable Thread state was found for `previous_message_id`. Replay the full conversation with `thread: {"type": "create"}` to start a new Thread.
 */
final class ThreadNotFoundException extends NotFoundException
{
    /** @var string */
    protected const DESC = 'Anthropic Thread Not Found Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'thread_not_found'
     */
    public function getErrorCode(): string
    {
        return 'thread_not_found';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): ThreadNotFoundErrorDetails
    {
        $details = Conversion::coerce(
            ThreadNotFoundErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof ThreadNotFoundErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
