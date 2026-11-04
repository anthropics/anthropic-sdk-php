<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\NotFoundException;
use Anthropic\Core\Util;

/**
 * `settings.environment_id` names no Environment within the organization's reach.
 */
final class BetaEnvironmentNotFoundException extends NotFoundException
{
    /** @var string */
    protected const DESC = 'Anthropic Beta Environment Not Found Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'environment_not_found'
     */
    public function getErrorCode(): string
    {
        return 'environment_not_found';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): BetaEnvironmentNotFoundErrorDetails
    {
        $details = Conversion::coerce(
            BetaEnvironmentNotFoundErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof BetaEnvironmentNotFoundErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
