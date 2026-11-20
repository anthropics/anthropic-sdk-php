<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * `provider_config.region` is not a region where External Storage is available.
 */
final class UnsupportedRegionException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Unsupported Region Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'unsupported_region'
     */
    public function getErrorCode(): string
    {
        return 'unsupported_region';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): UnsupportedRegionErrorDetails
    {
        $details = Conversion::coerce(
            UnsupportedRegionErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof UnsupportedRegionErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
