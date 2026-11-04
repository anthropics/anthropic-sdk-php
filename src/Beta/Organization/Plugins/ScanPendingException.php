<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\ConflictException;
use Anthropic\Core\Util;

/**
 * The content scan of the version in `plugin_version_id` is still running. Retry once the scan finishes.
 */
final class ScanPendingException extends ConflictException
{
    /** @var string */
    protected const DESC = 'Anthropic Scan Pending Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'scan_pending'
     */
    public function getErrorCode(): string
    {
        return 'scan_pending';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): ScanPendingErrorDetails
    {
        $details = Conversion::coerce(
            ScanPendingErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof ScanPendingErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
