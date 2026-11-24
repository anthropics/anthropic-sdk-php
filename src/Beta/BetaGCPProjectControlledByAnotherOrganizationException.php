<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\ConflictException;
use Anthropic\Core\Util;

/**
 * Another organization has data controls turned on for this Google Cloud project, or turned them off recently. The message says how long to wait.
 */
final class BetaGCPProjectControlledByAnotherOrganizationException extends ConflictException
{
    /** @var string */
    protected const DESC = 'Anthropic Beta GCP Project Controlled By Another Organization Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'gcp_project_controlled_by_another_organization'
     */
    public function getErrorCode(): string
    {
        return 'gcp_project_controlled_by_another_organization';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): BetaGCPProjectControlledByAnotherOrganizationErrorDetails
    {
        $details = Conversion::coerce(
            BetaGCPProjectControlledByAnotherOrganizationErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof BetaGCPProjectControlledByAnotherOrganizationErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
