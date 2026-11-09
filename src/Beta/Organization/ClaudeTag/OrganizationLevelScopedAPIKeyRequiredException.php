<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\PermissionDeniedException;
use Anthropic\Core\Util;

/**
 * The credential is not a scoped API key that is bound at the organization level.
 */
final class OrganizationLevelScopedAPIKeyRequiredException extends PermissionDeniedException
{
    /** @var string */
    protected const DESC = 'Anthropic Organization Level Scoped API Key Required Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'organization_level_scoped_api_key_required'
     */
    public function getErrorCode(): string
    {
        return 'organization_level_scoped_api_key_required';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): OrganizationLevelScopedAPIKeyRequiredErrorDetails
    {
        $details = Conversion::coerce(
            OrganizationLevelScopedAPIKeyRequiredErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof OrganizationLevelScopedAPIKeyRequiredErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
