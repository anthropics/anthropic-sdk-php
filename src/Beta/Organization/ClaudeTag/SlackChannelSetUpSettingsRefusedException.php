<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The request set the channel up, and `settings` was then refused. The channel stays set up with every setting unset.
 */
final class SlackChannelSetUpSettingsRefusedException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Slack Channel Set Up Settings Refused Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'slack_channel_set_up_settings_refused'
     */
    public function getErrorCode(): string
    {
        return 'slack_channel_set_up_settings_refused';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): SlackChannelSetUpSettingsRefusedErrorDetails
    {
        $details = Conversion::coerce(
            SlackChannelSetUpSettingsRefusedErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof SlackChannelSetUpSettingsRefusedErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
