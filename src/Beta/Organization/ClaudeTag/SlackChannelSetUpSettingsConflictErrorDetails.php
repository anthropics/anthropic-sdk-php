<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The request set the channel up, and something else then changed the channel or removed it. Nothing of `settings` was stored.
 *
 * @phpstan-type SlackChannelSetUpSettingsConflictErrorDetailsShape = array{
 *   errorCode: 'slack_channel_set_up_settings_conflict', slackChannelID: string
 * }
 */
final class SlackChannelSetUpSettingsConflictErrorDetails implements BaseModel
{
    /** @use SdkModel<SlackChannelSetUpSettingsConflictErrorDetailsShape> */
    use SdkModel;

    /**
     * A stable code that names the cause.
     *
     * @var 'slack_channel_set_up_settings_conflict' $errorCode
     */
    #[Required(
        'error_code',
        type: new ConstantOf('slack_channel_set_up_settings_conflict')
    )]
    public string $errorCode = 'slack_channel_set_up_settings_conflict';

    /**
     * The identifier of the channel the request set up, starting with `slch_`.
     */
    #[Required('slack_channel_id')]
    public string $slackChannelID;

    /**
     * `new SlackChannelSetUpSettingsConflictErrorDetails()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SlackChannelSetUpSettingsConflictErrorDetails::with(slackChannelID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SlackChannelSetUpSettingsConflictErrorDetails())->withSlackChannelID(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(string $slackChannelID): self
    {
        $self = new self;

        $self['slackChannelID'] = $slackChannelID;

        return $self;
    }

    /**
     * A stable code that names the cause.
     *
     * @param 'slack_channel_set_up_settings_conflict' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }

    /**
     * The identifier of the channel the request set up, starting with `slch_`.
     */
    public function withSlackChannelID(string $slackChannelID): self
    {
        $self = clone $this;
        $self['slackChannelID'] = $slackChannelID;

        return $self;
    }
}
