<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * A field that must stay the same across a Thread's turns differs from the value stored with the Thread; the message names each such field. Send the stored values, or replay the full conversation with `thread: {"type": "create"}` to change them.
 */
final class ThreadFingerprintMismatchException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Thread Fingerprint Mismatch Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'thread_fingerprint_mismatch'
     */
    public function getErrorCode(): string
    {
        return 'thread_fingerprint_mismatch';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): ThreadFingerprintMismatchErrorDetails
    {
        $details = Conversion::coerce(
            ThreadFingerprintMismatchErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof ThreadFingerprintMismatchErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
