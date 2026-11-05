<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Users;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\PermissionDeniedException;
use Anthropic\Core\Util;

/**
 * The member is an owner or has owner permissions, and this API key or token cannot sign them out. In a Claude Enterprise organization, an API key with the `write:members` scope can.
 */
final class CannotSignOutOwnerException extends PermissionDeniedException
{
    /** @var string */
    protected const DESC = 'Anthropic Cannot Sign Out Owner Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'cannot_sign_out_owner'
     */
    public function getErrorCode(): string
    {
        return 'cannot_sign_out_owner';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): CannotSignOutOwnerErrorDetails
    {
        $details = Conversion::coerce(
            CannotSignOutOwnerErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof CannotSignOutOwnerErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
