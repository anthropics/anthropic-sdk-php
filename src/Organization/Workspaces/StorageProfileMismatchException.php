<?php

declare(strict_types=1);

namespace Anthropic\Organization\Workspaces;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The Workspace's storage and its user profile don't match: the Workspace and its storage must have the same user profile, or both have none.
 */
final class StorageProfileMismatchException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Storage Profile Mismatch Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'storage_profile_mismatch'
     */
    public function getErrorCode(): string
    {
        return 'storage_profile_mismatch';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): StorageProfileMismatchErrorDetails
    {
        $details = Conversion::coerce(
            StorageProfileMismatchErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof StorageProfileMismatchErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
