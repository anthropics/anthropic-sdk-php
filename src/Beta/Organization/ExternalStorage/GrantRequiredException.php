<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * Anthropic has not approved External Storage for the organization, for the Workspace or, for storage bound to a user profile, for that user profile. Contact your Anthropic account team.
 */
final class GrantRequiredException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Grant Required Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'grant_required'
     */
    public function getErrorCode(): string
    {
        return 'grant_required';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): GrantRequiredErrorDetails
    {
        $details = Conversion::coerce(
            GrantRequiredErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof GrantRequiredErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
