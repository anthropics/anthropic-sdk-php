<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * External Storage isn't available for this Workspace, so only `internal` storage is accepted. The error's `message` says why.
 */
final class ExternalStorageNotAvailableException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic External Storage Not Available Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'external_storage_not_available'
     */
    public function getErrorCode(): string
    {
        return 'external_storage_not_available';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): ExternalStorageNotAvailableErrorDetails
    {
        $details = Conversion::coerce(
            ExternalStorageNotAvailableErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof ExternalStorageNotAvailableErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
