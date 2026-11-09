<?php

declare(strict_types=1);

namespace Anthropic\Organization\ExternalKeys;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * Anthropic's validation of the External Key did not finish in time, so the request was refused. Wait a moment, then send the request again.
 */
final class ExternalKeyValidationTimedOutException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic External Key Validation Timed Out Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'external_key_validation_timed_out'
     */
    public function getErrorCode(): string
    {
        return 'external_key_validation_timed_out';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): ExternalKeyValidationTimedOutErrorDetails
    {
        $details = Conversion::coerce(
            ExternalKeyValidationTimedOutErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof ExternalKeyValidationTimedOutErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
