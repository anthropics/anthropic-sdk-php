<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeCode\ManagedSettings;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The organization has reached its settings history limit, a cap on stored versions of its settings documents. Nothing in the API or claude.ai lowers the count, so contact support. Creating or deleting group settings, creating or clearing the default settings, and reordering are refused. Changing the mode still works, unless it would copy the organization settings into a new default.
 */
final class BetaSettingsHistoryLimitExceededException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Beta Settings History Limit Exceeded Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'settings_history_limit_exceeded'
     */
    public function getErrorCode(): string
    {
        return 'settings_history_limit_exceeded';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): BetaSettingsHistoryLimitExceededErrorDetails
    {
        $details = Conversion::coerce(
            BetaSettingsHistoryLimitExceededErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof BetaSettingsHistoryLimitExceededErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
