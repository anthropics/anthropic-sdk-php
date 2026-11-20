<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The feature isn't offered to this organization. The error's `message` names the kind of organization or, when it names none, says to contact your Anthropic account team.
 */
final class BetaOrganizationNotEligibleException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Beta Organization Not Eligible Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'organization_not_eligible'
     */
    public function getErrorCode(): string
    {
        return 'organization_not_eligible';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): BetaOrganizationNotEligibleErrorDetails
    {
        $details = Conversion::coerce(
            BetaOrganizationNotEligibleErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof BetaOrganizationNotEligibleErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
