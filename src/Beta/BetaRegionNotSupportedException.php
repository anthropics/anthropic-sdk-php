<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The request names a region code that the control does not take from this organization. The message names the field.
 */
final class BetaRegionNotSupportedException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Beta Region Not Supported Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'region_not_supported'
     */
    public function getErrorCode(): string
    {
        return 'region_not_supported';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): BetaRegionNotSupportedErrorDetails
    {
        $details = Conversion::coerce(
            BetaRegionNotSupportedErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof BetaRegionNotSupportedErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
