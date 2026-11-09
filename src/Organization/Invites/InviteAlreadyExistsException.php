<?php

declare(strict_types=1);

namespace Anthropic\Organization\Invites;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * A pending invite already exists for the email address. The message names the invite.
 */
final class InviteAlreadyExistsException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Invite Already Exists Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'invite_already_exists'
     */
    public function getErrorCode(): string
    {
        return 'invite_already_exists';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): InviteAlreadyExistsErrorDetails
    {
        $details = Conversion::coerce(
            InviteAlreadyExistsErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof InviteAlreadyExistsErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
