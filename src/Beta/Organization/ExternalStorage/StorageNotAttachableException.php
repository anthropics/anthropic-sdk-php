<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * This External Storage can't be attached to the setting named in `field`. The error's `message` says why.
 */
final class StorageNotAttachableException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Storage Not Attachable Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'storage_not_attachable'
     */
    public function getErrorCode(): string
    {
        return 'storage_not_attachable';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): StorageNotAttachableErrorDetails
    {
        $details = Conversion::coerce(
            StorageNotAttachableErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof StorageNotAttachableErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
