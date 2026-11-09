<?php

declare(strict_types=1);

namespace Anthropic\Organization\Workspaces;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The External Key is bound to a user profile, and the Workspace does not have that user profile. A Workspace can use only a key bound to its own user profile or a key that isn't bound to one.
 */
final class KeyProfileMismatchException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Key Profile Mismatch Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'key_profile_mismatch'
     */
    public function getErrorCode(): string
    {
        return 'key_profile_mismatch';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): KeyProfileMismatchErrorDetails
    {
        $details = Conversion::coerce(
            KeyProfileMismatchErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof KeyProfileMismatchErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
