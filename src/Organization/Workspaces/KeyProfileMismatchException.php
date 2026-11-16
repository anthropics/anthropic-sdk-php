<?php

declare(strict_types=1);

namespace Anthropic\Organization\Workspaces;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * After this request, the External Key and the Workspace would not have the same user profile. A key and its Workspace must have the same user profile, or both have none.
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
