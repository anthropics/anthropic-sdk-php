<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The beta that the endpoint requires is not enabled for the organization. The message names the beta value.
 */
final class BetaOrganizationNotEnrolledInBetaException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Beta Organization Not Enrolled In Beta Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'organization_not_enrolled_in_beta'
     */
    public function getErrorCode(): string
    {
        return 'organization_not_enrolled_in_beta';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): BetaOrganizationNotEnrolledInBetaErrorDetails
    {
        $details = Conversion::coerce(
            BetaOrganizationNotEnrolledInBetaErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof BetaOrganizationNotEnrolledInBetaErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
