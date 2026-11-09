<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\ConflictException;
use Anthropic\Core\Util;

/**
 * The request set the channel up, and something else then changed the channel or removed it. Nothing of `settings` was stored.
 */
final class SlackChannelSetUpSettingsConflictException extends ConflictException
{
    /** @var string */
    protected const DESC = 'Anthropic Slack Channel Set Up Settings Conflict Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'slack_channel_set_up_settings_conflict'
     */
    public function getErrorCode(): string
    {
        return 'slack_channel_set_up_settings_conflict';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): SlackChannelSetUpSettingsConflictErrorDetails
    {
        $details = Conversion::coerce(
            SlackChannelSetUpSettingsConflictErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof SlackChannelSetUpSettingsConflictErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
