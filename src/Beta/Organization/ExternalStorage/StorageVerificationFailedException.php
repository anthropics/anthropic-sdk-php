<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The External Storage failed verification, so the request changed nothing. `failed_checks` lists what to fix.
 */
final class StorageVerificationFailedException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Storage Verification Failed Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'storage_verification_failed'
     */
    public function getErrorCode(): string
    {
        return 'storage_verification_failed';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): StorageVerificationFailedErrorDetails
    {
        $details = Conversion::coerce(
            StorageVerificationFailedErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof StorageVerificationFailedErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
