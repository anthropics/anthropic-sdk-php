<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag\SlackChannels;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSettingsCreate;
use Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSlackChannelIdentifiers;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Set a Slack channel up for Claude Tag and return it with its identifier. If the channel is already set up, whether in claude.ai, by Claude's first use in it or by an earlier request, the existing channel is returned, so the request can be repeated. `settings`, when sent, is applied as an update applies it. Before a channel is set up, Claude's Slack app confirms with Slack that the channel is in the workspace, is not archived and is visible to the app; a channel that fails the confirmation returns 404. Setting the channel up and applying `settings` are two steps: when the second is refused, the response is the refusal, the channel stays set up with every setting unset, and the error's `details.slack_channel_id` holds the channel's identifier.
 *
 * @see Anthropic\Services\Beta\Organization\ClaudeTag\SlackChannelsService::create()
 *
 * @phpstan-import-type ClaudeTagSlackChannelIdentifiersShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSlackChannelIdentifiers
 * @phpstan-import-type ClaudeTagSettingsCreateShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSettingsCreate
 *
 * @phpstan-type SlackChannelCreateParamsShape = array{
 *   slack: ClaudeTagSlackChannelIdentifiers|ClaudeTagSlackChannelIdentifiersShape,
 *   settings?: null|ClaudeTagSettingsCreate|ClaudeTagSettingsCreateShape,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class SlackChannelCreateParams implements BaseModel
{
    /** @use SdkModel<SlackChannelCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Slack's own identifiers for the channel to set up. The organization must own the workspace.
     */
    #[Required]
    public ClaudeTagSlackChannelIdentifiers $slack;

    /**
     * Settings to store on the channel, applied as Update Slack Channel applies them.
     */
    #[Optional]
    public ?ClaudeTagSettingsCreate $settings;

    /**
     * This endpoint is in beta: requests must send `experimental-claude-tag-2026-10-21` in this header.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new SlackChannelCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SlackChannelCreateParams::with(slack: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SlackChannelCreateParams())->withSlack(...)
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
     * @param ClaudeTagSlackChannelIdentifiers|ClaudeTagSlackChannelIdentifiersShape $slack
     * @param ClaudeTagSettingsCreate|ClaudeTagSettingsCreateShape|null $settings
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        ClaudeTagSlackChannelIdentifiers|array $slack,
        ClaudeTagSettingsCreate|array|null $settings = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        $self['slack'] = $slack;

        null !== $settings && $self['settings'] = $settings;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Slack's own identifiers for the channel to set up. The organization must own the workspace.
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
     * Settings to store on the channel, applied as Update Slack Channel applies them.
     *
     * @param ClaudeTagSettingsCreate|ClaudeTagSettingsCreateShape $settings
     */
    public function withSettings(ClaudeTagSettingsCreate|array $settings): self
    {
        $self = clone $this;
        $self['settings'] = $settings;

        return $self;
    }

    /**
     * This endpoint is in beta: requests must send `experimental-claude-tag-2026-10-21` in this header.
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas
     */
    public function withBetas(array $betas): self
    {
        $self = clone $this;
        $self['betas'] = $betas;

        return $self;
    }
}
