<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\PermissionDeniedException;
use Anthropic\Core\Util;

/**
 * Anthropic has turned off updating environments for this organization. Existing environments still work as they are.
 */
final class BetaEnvironmentUpdateDisabledException extends PermissionDeniedException
{
    /** @var string */
    protected const DESC = 'Anthropic Beta Environment Update Disabled Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'environment_update_disabled'
     */
    public function getErrorCode(): string
    {
        return 'environment_update_disabled';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): BetaEnvironmentUpdateDisabledErrorDetails
    {
        $details = Conversion::coerce(
            BetaEnvironmentUpdateDisabledErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof BetaEnvironmentUpdateDisabledErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
