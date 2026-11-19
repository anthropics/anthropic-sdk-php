<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeCode\ManagedSettings;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\NotFoundException;
use Anthropic\Core\Util;

/**
 * This RBAC Group has no Claude Code managed settings.
 */
final class BetaRBACGroupManagedSettingsNotFoundException extends NotFoundException
{
    /** @var string */
    protected const DESC = 'Anthropic Beta RBAC Group Managed Settings Not Found Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'rbac_group_managed_settings_not_found'
     */
    public function getErrorCode(): string
    {
        return 'rbac_group_managed_settings_not_found';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): BetaRBACGroupManagedSettingsNotFoundErrorDetails
    {
        $details = Conversion::coerce(
            BetaRBACGroupManagedSettingsNotFoundErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof BetaRBACGroupManagedSettingsNotFoundErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
