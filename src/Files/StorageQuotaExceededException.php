<?php

declare(strict_types=1);

namespace Anthropic\Files;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The organization's file storage quota is exhausted. Delete files to free up space, then retry the upload.
 */
final class StorageQuotaExceededException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Storage Quota Exceeded Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'storage_quota_exceeded'
     */
    public function getErrorCode(): string
    {
        return 'storage_quota_exceeded';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): StorageQuotaExceededErrorDetails
    {
        $details = Conversion::coerce(
            StorageQuotaExceededErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof StorageQuotaExceededErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
