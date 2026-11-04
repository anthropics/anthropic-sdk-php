<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * `settings.environment_id` names no Environment within the organization's reach, and the request had set the channel up by then. The channel stays set up with every setting unset.
 *
 * @phpstan-type SlackChannelSetUpEnvironmentNotFoundErrorDetailsShape = array{
 *   errorCode: 'slack_channel_set_up_environment_not_found',
 *   slackChannelID: string,
 * }
 */
final class SlackChannelSetUpEnvironmentNotFoundErrorDetails implements BaseModel
{
    /** @use SdkModel<SlackChannelSetUpEnvironmentNotFoundErrorDetailsShape> */
    use SdkModel;

    /** @var 'slack_channel_set_up_environment_not_found' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('slack_channel_set_up_environment_not_found'),
    )]
    public string $errorCode = 'slack_channel_set_up_environment_not_found';

    /**
     * The identifier of the channel the request set up, starting with `slch_`.
     */
    #[Required('slack_channel_id')]
    public string $slackChannelID;

    /**
     * `new SlackChannelSetUpEnvironmentNotFoundErrorDetails()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SlackChannelSetUpEnvironmentNotFoundErrorDetails::with(slackChannelID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SlackChannelSetUpEnvironmentNotFoundErrorDetails())
     *   ->withSlackChannelID(...)
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
     * @param 'slack_channel_set_up_environment_not_found' $errorCode
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
