<?php

declare(strict_types=1);

namespace Anthropic\Organization\Invites;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The email address already belongs to a user in the organization. The message names the user.
 */
final class AlreadyMemberException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Already Member Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'already_member'
     */
    public function getErrorCode(): string
    {
        return 'already_member';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): AlreadyMemberErrorDetails
    {
        $details = Conversion::coerce(
            AlreadyMemberErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof AlreadyMemberErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
