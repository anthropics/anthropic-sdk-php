<?php

declare(strict_types=1);

namespace Anthropic\Files;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\NotFoundException;
use Anthropic\Core\Util;

/**
 * The file's `expires_at` has passed, so its content is no longer available.
 */
final class FileExpiredException extends NotFoundException
{
    /** @var string */
    protected const DESC = 'Anthropic File Expired Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'file_expired'
     */
    public function getErrorCode(): string
    {
        return 'file_expired';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): FileExpiredErrorDetails
    {
        $details = Conversion::coerce(
            FileExpiredErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof FileExpiredErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
