<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The Workspace has reached its limit of 100 different External Storage resources attached over its lifetime. Detached storage counts toward the limit until it is deleted.
 */
final class StorageAttachLimitReachedException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Storage Attach Limit Reached Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'storage_attach_limit_reached'
     */
    public function getErrorCode(): string
    {
        return 'storage_attach_limit_reached';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): StorageAttachLimitReachedErrorDetails
    {
        $details = Conversion::coerce(
            StorageAttachLimitReachedErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof StorageAttachLimitReachedErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
