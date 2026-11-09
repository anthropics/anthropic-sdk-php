<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Users;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The member is the user the API key or token belongs to.
 */
final class CannotSignOutSelfException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Cannot Sign Out Self Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'cannot_sign_out_self'
     */
    public function getErrorCode(): string
    {
        return 'cannot_sign_out_self';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): CannotSignOutSelfErrorDetails
    {
        $details = Conversion::coerce(
            CannotSignOutSelfErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof CannotSignOutSelfErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
