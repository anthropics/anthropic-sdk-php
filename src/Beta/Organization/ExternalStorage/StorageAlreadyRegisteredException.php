<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\ConflictException;
use Anthropic\Core\Util;

/**
 * The organization already has External Storage for this bucket that it has not deleted. List the organization's External Storage to find it.
 */
final class StorageAlreadyRegisteredException extends ConflictException
{
    /** @var string */
    protected const DESC = 'Anthropic Storage Already Registered Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'storage_already_registered'
     */
    public function getErrorCode(): string
    {
        return 'storage_already_registered';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): StorageAlreadyRegisteredErrorDetails
    {
        $details = Conversion::coerce(
            StorageAlreadyRegisteredErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof StorageAlreadyRegisteredErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
