<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The workspace's customer-managed encryption key is disabled or revoked. Re-enable the key, then retry.
 */
final class CMEKKeyDisabledException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic CMEK Key Disabled Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'cmek_key_disabled'
     */
    public function getErrorCode(): string
    {
        return 'cmek_key_disabled';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): CMEKKeyDisabledErrorDetails
    {
        $details = Conversion::coerce(
            CMEKKeyDisabledErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof CMEKKeyDisabledErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
