<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The version in `plugin_version_id` did not pass its content scan, so it cannot be served.
 */
final class ScanFailedException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Scan Failed Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'scan_failed'
     */
    public function getErrorCode(): string
    {
        return 'scan_failed';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): ScanFailedErrorDetails
    {
        $details = Conversion::coerce(
            ScanFailedErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof ScanFailedErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
