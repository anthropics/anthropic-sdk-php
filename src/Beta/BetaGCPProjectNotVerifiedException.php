<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The organization has not proved that it owns the Google Cloud project that holds the key or bucket. The message names the field.
 */
final class BetaGCPProjectNotVerifiedException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Beta GCP Project Not Verified Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'gcp_project_not_verified'
     */
    public function getErrorCode(): string
    {
        return 'gcp_project_not_verified';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): BetaGCPProjectNotVerifiedErrorDetails
    {
        $details = Conversion::coerce(
            BetaGCPProjectNotVerifiedErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof BetaGCPProjectNotVerifiedErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
