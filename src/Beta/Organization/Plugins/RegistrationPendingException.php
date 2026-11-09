<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\ServiceUnavailableException;
use Anthropic\Core\Util;

/**
 * The Plugin version was stored but is not yet usable in claude.ai. `plugin_id` and `plugin_version_id` identify what was stored.
 */
final class RegistrationPendingException extends ServiceUnavailableException
{
    /** @var string */
    protected const DESC = 'Anthropic Registration Pending Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'registration_pending'
     */
    public function getErrorCode(): string
    {
        return 'registration_pending';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): RegistrationPendingErrorDetails
    {
        $details = Conversion::coerce(
            RegistrationPendingErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof RegistrationPendingErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
