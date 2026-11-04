<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\NotFoundException;
use Anthropic\Core\Util;

/**
 * `settings.environment_id` names no Environment within the organization's reach, and the request had set the channel up by then. The channel stays set up with every setting unset.
 */
final class SlackChannelSetUpEnvironmentNotFoundException extends NotFoundException
{
    /** @var string */
    protected const DESC = 'Anthropic Slack Channel Set Up Environment Not Found Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'slack_channel_set_up_environment_not_found'
     */
    public function getErrorCode(): string
    {
        return 'slack_channel_set_up_environment_not_found';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): SlackChannelSetUpEnvironmentNotFoundErrorDetails
    {
        $details = Conversion::coerce(
            SlackChannelSetUpEnvironmentNotFoundErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof SlackChannelSetUpEnvironmentNotFoundErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
