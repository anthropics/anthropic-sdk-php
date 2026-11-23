<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\ConflictException;
use Anthropic\Core\Util;

/**
 * Another request changed this storage setting while this one was running, so this request left it as it is. Read the Workspace and send the request again if you still want the change.
 */
final class StorageChangedConcurrentlyException extends ConflictException
{
    /** @var string */
    protected const DESC = 'Anthropic Storage Changed Concurrently Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'storage_changed_concurrently'
     */
    public function getErrorCode(): string
    {
        return 'storage_changed_concurrently';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): StorageChangedConcurrentlyErrorDetails
    {
        $details = Conversion::coerce(
            StorageChangedConcurrentlyErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof StorageChangedConcurrentlyErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
