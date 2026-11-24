<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\ConflictException;
use Anthropic\Core\Util;

/**
 * The bucket is already in use, or was in use recently. Name a different bucket.
 */
final class BetaStorageInUseException extends ConflictException
{
    /** @var string */
    protected const DESC = 'Anthropic Beta Storage In Use Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'storage_in_use'
     */
    public function getErrorCode(): string
    {
        return 'storage_in_use';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): BetaStorageInUseErrorDetails
    {
        $details = Conversion::coerce(
            BetaStorageInUseErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof BetaStorageInUseErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
