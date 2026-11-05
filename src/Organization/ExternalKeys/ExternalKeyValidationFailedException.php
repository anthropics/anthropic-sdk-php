<?php

declare(strict_types=1);

namespace Anthropic\Organization\ExternalKeys;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The External Key failed Anthropic's validation, so the request was refused. The message gives the reason, if there is one.
 */
final class ExternalKeyValidationFailedException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic External Key Validation Failed Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'external_key_validation_failed'
     */
    public function getErrorCode(): string
    {
        return 'external_key_validation_failed';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): ExternalKeyValidationFailedErrorDetails
    {
        $details = Conversion::coerce(
            ExternalKeyValidationFailedErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof ExternalKeyValidationFailedErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
