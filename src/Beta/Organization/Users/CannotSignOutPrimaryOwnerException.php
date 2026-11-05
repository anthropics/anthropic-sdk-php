<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Users;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The member is the organization's primary owner, whom no API key or token can sign out.
 */
final class CannotSignOutPrimaryOwnerException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Cannot Sign Out Primary Owner Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'cannot_sign_out_primary_owner'
     */
    public function getErrorCode(): string
    {
        return 'cannot_sign_out_primary_owner';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): CannotSignOutPrimaryOwnerErrorDetails
    {
        $details = Conversion::coerce(
            CannotSignOutPrimaryOwnerErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof CannotSignOutPrimaryOwnerErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
