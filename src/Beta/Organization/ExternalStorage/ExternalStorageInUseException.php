<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The External Storage is `active` or `draining`, so this delete didn't erase it. The message says what to do next. On `draining` storage this delete may have started a removal that can't be undone: get the storage and read `status.removal_started`.
 */
final class ExternalStorageInUseException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic External Storage In Use Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'external_storage_in_use'
     */
    public function getErrorCode(): string
    {
        return 'external_storage_in_use';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): ExternalStorageInUseErrorDetails
    {
        $details = Conversion::coerce(
            ExternalStorageInUseErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof ExternalStorageInUseErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
