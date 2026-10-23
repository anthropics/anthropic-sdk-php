<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag\SlackChannels;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List the set-up Slack channels of one Slack workspace, newest first by `created_at`. A channel that is not set up is not listed: Slack holds the full list of a workspace's channels. Pass `slack_channel_id` as well to look one channel up by its Slack identifiers: `data` then holds that channel, or is empty when it is not set up, and `limit` and `page` are ignored. A workspace that the organization owns only through a Slack Enterprise Grid returns 404 until it is set up. With `include_inherited=true` each channel's `settings` holds what applies in it, and the request fails with 503 rather than resolve against a settings level that could not be read. A `page` cursor resumes only a request with the same `include_inherited`.
 *
 * @see Anthropic\Services\Beta\Organization\ClaudeTag\SlackChannelsService::list()
 *
 * @phpstan-type SlackChannelListParamsShape = array{
 *   slackWorkspaceID: string,
 *   includeInherited?: bool|null,
 *   limit?: int|null,
 *   page?: string|null,
 *   slackChannelID?: string|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class SlackChannelListParams implements BaseModel
{
    /** @use SdkModel<SlackChannelListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * The Slack workspace whose channels to list: Slack's identifier for it, as in the channel object's `slack.workspace_id`, not the workspace object's `id`.
     */
    #[Required]
    public string $slackWorkspaceID;

    /**
     * When `true`, `settings` holds what applies in each channel once the settings levels above it are taken into account, and every member of `sources` names the level a value comes from. When `false` or left out, `settings` holds what each channel itself stores.
     */
    #[Optional]
    public ?bool $includeInherited;

    /**
     * Number of items to return per page, between 1 and 100. Defaults to 20.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Opaque cursor from a previous response's `next_page`.
     */
    #[Optional]
    public ?string $page;

    /**
     * Slack's identifier for one channel of that workspace, as in the channel object's `slack.channel_id`. It is not the channel object's `id`. With it `data` holds that channel alone, or nothing when the channel is not set up.
     */
    #[Optional]
    public ?string $slackChannelID;

    /**
     * This endpoint is in beta: requests must send `experimental-claude-tag-2026-10-21` in this header.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new SlackChannelListParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SlackChannelListParams::with(slackWorkspaceID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SlackChannelListParams())->withSlackWorkspaceID(...)
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
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        string $slackWorkspaceID,
        ?bool $includeInherited = null,
        ?int $limit = null,
        ?string $page = null,
        ?string $slackChannelID = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        $self['slackWorkspaceID'] = $slackWorkspaceID;

        null !== $includeInherited && $self['includeInherited'] = $includeInherited;
        null !== $limit && $self['limit'] = $limit;
        null !== $page && $self['page'] = $page;
        null !== $slackChannelID && $self['slackChannelID'] = $slackChannelID;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * The Slack workspace whose channels to list: Slack's identifier for it, as in the channel object's `slack.workspace_id`, not the workspace object's `id`.
     */
    public function withSlackWorkspaceID(string $slackWorkspaceID): self
    {
        $self = clone $this;
        $self['slackWorkspaceID'] = $slackWorkspaceID;

        return $self;
    }

    /**
     * When `true`, `settings` holds what applies in each channel once the settings levels above it are taken into account, and every member of `sources` names the level a value comes from. When `false` or left out, `settings` holds what each channel itself stores.
     */
    public function withIncludeInherited(bool $includeInherited): self
    {
        $self = clone $this;
        $self['includeInherited'] = $includeInherited;

        return $self;
    }

    /**
     * Number of items to return per page, between 1 and 100. Defaults to 20.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Opaque cursor from a previous response's `next_page`.
     */
    public function withPage(string $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }

    /**
     * Slack's identifier for one channel of that workspace, as in the channel object's `slack.channel_id`. It is not the channel object's `id`. With it `data` holds that channel alone, or nothing when the channel is not set up.
     */
    public function withSlackChannelID(string $slackChannelID): self
    {
        $self = clone $this;
        $self['slackChannelID'] = $slackChannelID;

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
