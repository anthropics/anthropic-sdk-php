<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The value comes from the channel that a code channel was started from. A parent channel contributes `instructions` and `environment_id` only.
 *
 * @phpstan-type ClaudeTagSlackParentChannelSettingSourceShape = array{
 *   slackChannelID: string, type: 'slack_parent_channel'
 * }
 */
final class ClaudeTagSlackParentChannelSettingSource implements BaseModel
{
    /** @use SdkModel<ClaudeTagSlackParentChannelSettingSourceShape> */
    use SdkModel;

    /** @var 'slack_parent_channel' $type */
    #[Required(type: new ConstantOf('slack_parent_channel'))]
    public string $type = 'slack_parent_channel';

    /**
     * The parent channel's identifier, starting with `slch_`.
     */
    #[Required('slack_channel_id')]
    public string $slackChannelID;

    /**
     * `new ClaudeTagSlackParentChannelSettingSource()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ClaudeTagSlackParentChannelSettingSource::with(slackChannelID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ClaudeTagSlackParentChannelSettingSource())->withSlackChannelID(...)
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
     * The parent channel's identifier, starting with `slch_`.
     */
    public function withSlackChannelID(string $slackChannelID): self
    {
        $self = clone $this;
        $self['slackChannelID'] = $slackChannelID;

        return $self;
    }

    /**
     * @param 'slack_parent_channel' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
