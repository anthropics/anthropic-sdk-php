<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\PermissionDeniedException;
use Anthropic\Core\Util;

/**
 * Anthropic has turned off creating environments for this organization. Existing environments still work.
 */
final class BetaEnvironmentCreateDisabledException extends PermissionDeniedException
{
    /** @var string */
    protected const DESC = 'Anthropic Beta Environment Create Disabled Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'environment_create_disabled'
     */
    public function getErrorCode(): string
    {
        return 'environment_create_disabled';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): BetaEnvironmentCreateDisabledErrorDetails
    {
        $details = Conversion::coerce(
            BetaEnvironmentCreateDisabledErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof BetaEnvironmentCreateDisabledErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
