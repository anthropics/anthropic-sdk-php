<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The identifiers Slack shows for a channel. They are Slack's own, not identifiers of this API.
 *
 * @phpstan-type ClaudeTagSlackChannelIdentifiersShape = array{
 *   channelID: string, workspaceID: string
 * }
 */
final class ClaudeTagSlackChannelIdentifiers implements BaseModel
{
    /** @use SdkModel<ClaudeTagSlackChannelIdentifiersShape> */
    use SdkModel;

    /**
     * Slack's identifier for the channel, starting with `C` or `G`, such as `C0456EFGH`.
     */
    #[Required('channel_id')]
    public string $channelID;

    /**
     * Slack's identifier for the workspace the channel is in, starting with `T`, such as `T0123ABCD`.
     */
    #[Required('workspace_id')]
    public string $workspaceID;

    /**
     * `new ClaudeTagSlackChannelIdentifiers()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ClaudeTagSlackChannelIdentifiers::with(channelID: ..., workspaceID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ClaudeTagSlackChannelIdentifiers())
     *   ->withChannelID(...)
     *   ->withWorkspaceID(...)
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
    public static function with(string $channelID, string $workspaceID): self
    {
        $self = new self;

        $self['channelID'] = $channelID;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * Slack's identifier for the channel, starting with `C` or `G`, such as `C0456EFGH`.
     */
    public function withChannelID(string $channelID): self
    {
        $self = clone $this;
        $self['channelID'] = $channelID;

        return $self;
    }

    /**
     * Slack's identifier for the workspace the channel is in, starting with `T`, such as `T0123ABCD`.
     */
    public function withWorkspaceID(string $workspaceID): self
    {
        $self = clone $this;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }
}
