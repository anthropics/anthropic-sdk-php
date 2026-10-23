<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Attach the Bundle to a Slack channel.
 *
 * @phpstan-type BetaClaudeTagSlackChannelBundleTargetCreateShape = array{
 *   slackChannelID: string, type: 'slack_channel'
 * }
 */
final class BetaClaudeTagSlackChannelBundleTargetCreate implements BaseModel
{
    /** @use SdkModel<BetaClaudeTagSlackChannelBundleTargetCreateShape> */
    use SdkModel;

    /** @var 'slack_channel' $type */
    #[Required(type: new ConstantOf('slack_channel'))]
    public string $type = 'slack_channel';

    /**
     * The identifier of the Slack channel to attach the Bundle to, starting with `slch_`. It is the channel object's `id`, not Slack's `channel_id`.
     */
    #[Required('slack_channel_id')]
    public string $slackChannelID;

    /**
     * `new BetaClaudeTagSlackChannelBundleTargetCreate()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaClaudeTagSlackChannelBundleTargetCreate::with(slackChannelID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaClaudeTagSlackChannelBundleTargetCreate())->withSlackChannelID(...)
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
     * The identifier of the Slack channel to attach the Bundle to, starting with `slch_`. It is the channel object's `id`, not Slack's `channel_id`.
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
