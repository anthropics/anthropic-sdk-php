<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag\SlackChannels;

use Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSettings;
use Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSettingSources;
use Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSlackChannelIdentifiers;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A Slack channel set up for Claude Tag, with the settings it stores or, with `include_inherited`, the settings that apply in it.
 *
 * @phpstan-import-type ClaudeTagSettingsShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSettings
 * @phpstan-import-type ClaudeTagSlackChannelIdentifiersShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSlackChannelIdentifiers
 * @phpstan-import-type ClaudeTagSettingSourcesShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSettingSources
 *
 * @phpstan-type BetaClaudeTagSlackChannelShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   settings: ClaudeTagSettings|ClaudeTagSettingsShape,
 *   slack: ClaudeTagSlackChannelIdentifiers|ClaudeTagSlackChannelIdentifiersShape,
 *   sources: ClaudeTagSettingSources|ClaudeTagSettingSourcesShape,
 *   type: 'slack_channel',
 *   updatedAt: \DateTimeInterface,
 * }
 */
final class BetaClaudeTagSlackChannel implements BaseModel
{
    /** @use SdkModel<BetaClaudeTagSlackChannelShape> */
    use SdkModel;

    /** @var 'slack_channel' $type */
    #[Required(type: new ConstantOf('slack_channel'))]
    public string $type = 'slack_channel';

    /**
     * The channel's identifier. Starts with `slch_`. It does not change for as long as the channel is set up, with one exception: a channel that is not configured gets a new one when claude.ai replaces its record, which happens only while the organization's read-only mode is off. A channel that is removed and set up again also has a new one. The old one keeps returning 404; look the channel up by its Slack identifiers for the new one.
     */
    #[Required]
    public string $id;

    /**
     * Time the channel was set up, by whichever route. It does not change for as long as `id` does not.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * What the channel itself stores or, with `include_inherited`, what applies in it. `sources` says which.
     */
    #[Required]
    public ClaudeTagSettings $settings;

    /**
     * Slack's own identifiers for the channel.
     */
    #[Required]
    public ClaudeTagSlackChannelIdentifiers $slack;

    /**
     * For each setting, the settings level its value in `settings` comes from.
     */
    #[Required]
    public ClaudeTagSettingSources $sources;

    /**
     * Time Claude Tag's record of the channel last changed. It moves on every change to a setting, and can also move when something no response holds changes, so a later value says to read the channel again, not that a setting changed. Attaching or detaching a Bundle does not by itself move it.
     */
    #[Required('updated_at')]
    public \DateTimeInterface $updatedAt;

    /**
     * `new BetaClaudeTagSlackChannel()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaClaudeTagSlackChannel::with(
     *   id: ...,
     *   createdAt: ...,
     *   settings: ...,
     *   slack: ...,
     *   sources: ...,
     *   updatedAt: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaClaudeTagSlackChannel())
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withSettings(...)
     *   ->withSlack(...)
     *   ->withSources(...)
     *   ->withUpdatedAt(...)
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
     *
     * @param ClaudeTagSettings|ClaudeTagSettingsShape $settings
     * @param ClaudeTagSlackChannelIdentifiers|ClaudeTagSlackChannelIdentifiersShape $slack
     * @param ClaudeTagSettingSources|ClaudeTagSettingSourcesShape $sources
     */
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        ClaudeTagSettings|array $settings,
        ClaudeTagSlackChannelIdentifiers|array $slack,
        ClaudeTagSettingSources|array $sources,
        \DateTimeInterface $updatedAt,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['settings'] = $settings;
        $self['slack'] = $slack;
        $self['sources'] = $sources;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * The channel's identifier. Starts with `slch_`. It does not change for as long as the channel is set up, with one exception: a channel that is not configured gets a new one when claude.ai replaces its record, which happens only while the organization's read-only mode is off. A channel that is removed and set up again also has a new one. The old one keeps returning 404; look the channel up by its Slack identifiers for the new one.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Time the channel was set up, by whichever route. It does not change for as long as `id` does not.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * What the channel itself stores or, with `include_inherited`, what applies in it. `sources` says which.
     *
     * @param ClaudeTagSettings|ClaudeTagSettingsShape $settings
     */
    public function withSettings(ClaudeTagSettings|array $settings): self
    {
        $self = clone $this;
        $self['settings'] = $settings;

        return $self;
    }

    /**
     * Slack's own identifiers for the channel.
     *
     * @param ClaudeTagSlackChannelIdentifiers|ClaudeTagSlackChannelIdentifiersShape $slack
     */
    public function withSlack(
        ClaudeTagSlackChannelIdentifiers|array $slack
    ): self {
        $self = clone $this;
        $self['slack'] = $slack;

        return $self;
    }

    /**
     * For each setting, the settings level its value in `settings` comes from.
     *
     * @param ClaudeTagSettingSources|ClaudeTagSettingSourcesShape $sources
     */
    public function withSources(ClaudeTagSettingSources|array $sources): self
    {
        $self = clone $this;
        $self['sources'] = $sources;

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

    /**
     * Time Claude Tag's record of the channel last changed. It moves on every change to a setting, and can also move when something no response holds changes, so a later value says to read the channel again, not that a setting changed. Attaching or detaching a Bundle does not by itself move it.
     */
    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
