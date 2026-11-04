<?php

declare(strict_types=1);

namespace Anthropic\Organization\Users;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The user is the organization's only member. Add another member before removing this one.
 */
final class CannotRemoveLastMemberException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Cannot Remove Last Member Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'cannot_remove_last_member'
     */
    public function getErrorCode(): string
    {
        return 'cannot_remove_last_member';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): CannotRemoveLastMemberErrorDetails
    {
        $details = Conversion::coerce(
            CannotRemoveLastMemberErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof CannotRemoveLastMemberErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
