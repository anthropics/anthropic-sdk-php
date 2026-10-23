<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * One Bundle attached to one Slack channel. The Bundle can be used in that channel only.
 *
 * @phpstan-type BetaClaudeTagSlackChannelBundleTargetShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   slackChannelID: string,
 *   type: 'slack_channel',
 * }
 */
final class BetaClaudeTagSlackChannelBundleTarget implements BaseModel
{
    /** @use SdkModel<BetaClaudeTagSlackChannelBundleTargetShape> */
    use SdkModel;

    /** @var 'slack_channel' $type */
    #[Required(type: new ConstantOf('slack_channel'))]
    public string $type = 'slack_channel';

    /**
     * The Bundle Target's identifier. Starts with `btgt_`. No two Bundle Targets have the same one, and the same Bundle and target always give the same one, also after a detach and a new attach. It is opaque.
     */
    #[Required]
    public string $id;

    /**
     * Time the Bundle was attached.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * The identifier of the Slack channel the Bundle is attached to, starting with `slch_`. It is the channel object's `id`, not Slack's `channel_id`.
     */
    #[Required('slack_channel_id')]
    public string $slackChannelID;

    /**
     * `new BetaClaudeTagSlackChannelBundleTarget()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaClaudeTagSlackChannelBundleTarget::with(
     *   id: ..., createdAt: ..., slackChannelID: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaClaudeTagSlackChannelBundleTarget())
     *   ->withID(...)
     *   ->withCreatedAt(...)
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
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        string $slackChannelID
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['slackChannelID'] = $slackChannelID;

        return $self;
    }

    /**
     * The Bundle Target's identifier. Starts with `btgt_`. No two Bundle Targets have the same one, and the same Bundle and target always give the same one, also after a detach and a new attach. It is opaque.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Time the Bundle was attached.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * The identifier of the Slack channel the Bundle is attached to, starting with `slch_`. It is the channel object's `id`, not Slack's `channel_id`.
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
