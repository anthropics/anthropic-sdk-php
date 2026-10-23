<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The value comes from the addressed Slack channel itself.
 *
 * @phpstan-type ClaudeTagSlackChannelSettingSourceShape = array{
 *   slackChannelID: string, type: 'slack_channel'
 * }
 */
final class ClaudeTagSlackChannelSettingSource implements BaseModel
{
    /** @use SdkModel<ClaudeTagSlackChannelSettingSourceShape> */
    use SdkModel;

    /** @var 'slack_channel' $type */
    #[Required(type: new ConstantOf('slack_channel'))]
    public string $type = 'slack_channel';

    /**
     * The channel's identifier, starting with `slch_`.
     */
    #[Required('slack_channel_id')]
    public string $slackChannelID;

    /**
     * `new ClaudeTagSlackChannelSettingSource()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ClaudeTagSlackChannelSettingSource::with(slackChannelID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ClaudeTagSlackChannelSettingSource())->withSlackChannelID(...)
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
     * The channel's identifier, starting with `slch_`.
     */
    public function withSlackChannelID(string $slackChannelID): self
    {
        $self = clone $this;
        $self['slackChannelID'] = $slackChannelID;

        return $self;
    }

    /**
     * @param 'slack_channel' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
