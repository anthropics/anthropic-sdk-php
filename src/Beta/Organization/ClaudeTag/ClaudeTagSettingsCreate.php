<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The settings in a request that sets a Slack channel up. A setting left out is not set. A setting sent as null is cleared.
 *
 * @phpstan-import-type ClaudeTagGuestPolicyShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagGuestPolicy
 * @phpstan-import-type ClaudeTagReplyModeShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagReplyMode
 * @phpstan-import-type ClaudeTagGuestPolicyVariants from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagGuestPolicy
 * @phpstan-import-type ClaudeTagReplyModeVariants from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagReplyMode
 *
 * @phpstan-type ClaudeTagSettingsCreateShape = array{
 *   enabled?: bool|null,
 *   environmentID?: string|null,
 *   guestPolicy?: ClaudeTagGuestPolicyShape|null,
 *   instructions?: string|null,
 *   model?: string|null,
 *   replyMode?: ClaudeTagReplyModeShape|null,
 * }
 */
final class ClaudeTagSettingsCreate implements BaseModel
{
    /** @use SdkModel<ClaudeTagSettingsCreateShape> */
    use SdkModel;

    /**
     * Whether Claude is on. `true` on a channel turns Claude on in it even when its workspace stores `false`. Null clears it.
     */
    #[Optional(nullable: true)]
    public ?bool $enabled;

    /**
     * The environment Claude's sessions run in: the identifier of an active environment of the organization, starting with `env_`, or of a self-hosted runner pool of the organization that every member may use, starting with `ccpool_`. Null clears it.
     */
    #[Optional('environment_id', nullable: true)]
    public ?string $environmentID;

    /**
     * What Claude does in a channel while a Slack guest is in it. Null clears it.
     *
     * @var ClaudeTagGuestPolicyVariants|null $guestPolicy
     */
    #[Optional(
        'guest_policy',
        union: ClaudeTagGuestPolicy::class,
        nullable: true
    )]
    public ClaudeTagGuestPolicyAllow|ClaudeTagGuestPolicyRestrict|ClaudeTagGuestPolicyChannelOnly|null $guestPolicy;

    /**
     * Instructions for Claude, up to 8,192 characters after leading and trailing white space is trimmed. Null or blank text clears them.
     */
    #[Optional(nullable: true)]
    public ?string $instructions;

    /**
     * The model Claude uses: the identifier of a model, or the name of a model line, that the organization is entitled to for Claude Tag. Null clears it.
     */
    #[Optional(nullable: true)]
    public ?string $model;

    /**
     * How Claude takes part in the channel: `automatic`, `mention_only`, `always_awake` or `thread`. Only a channel takes one: an update of a workspace that sends a value is refused, and one that sends null changes nothing. Null never clears it: sent to a channel that stores none it changes nothing, and sent to a channel that stores one it is refused, because a stored reply mode can be changed but never cleared; a caller that wants Claude's default behavior sends `automatic`.
     *
     * @var ClaudeTagReplyModeVariants|null $replyMode
     */
    #[Optional('reply_mode', union: ClaudeTagReplyMode::class, nullable: true)]
    public ClaudeTagReplyModeAutomatic|ClaudeTagReplyModeMentionOnly|ClaudeTagReplyModeAlwaysAwake|ClaudeTagReplyModeThread|null $replyMode;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param ClaudeTagGuestPolicyShape|null $guestPolicy
     * @param ClaudeTagReplyModeShape|null $replyMode
     */
    public static function with(
        ?bool $enabled = null,
        ?string $environmentID = null,
        ClaudeTagGuestPolicyAllow|array|ClaudeTagGuestPolicyRestrict|ClaudeTagGuestPolicyChannelOnly|null $guestPolicy = null,
        ?string $instructions = null,
        ?string $model = null,
        ClaudeTagReplyModeAutomatic|array|ClaudeTagReplyModeMentionOnly|ClaudeTagReplyModeAlwaysAwake|ClaudeTagReplyModeThread|null $replyMode = null,
    ): self {
        $self = new self;

        null !== $enabled && $self['enabled'] = $enabled;
        null !== $environmentID && $self['environmentID'] = $environmentID;
        null !== $guestPolicy && $self['guestPolicy'] = $guestPolicy;
        null !== $instructions && $self['instructions'] = $instructions;
        null !== $model && $self['model'] = $model;
        null !== $replyMode && $self['replyMode'] = $replyMode;

        return $self;
    }

    /**
     * Whether Claude is on. `true` on a channel turns Claude on in it even when its workspace stores `false`. Null clears it.
     */
    public function withEnabled(?bool $enabled): self
    {
        $self = clone $this;
        $self['enabled'] = $enabled;

        return $self;
    }

    /**
     * The environment Claude's sessions run in: the identifier of an active environment of the organization, starting with `env_`, or of a self-hosted runner pool of the organization that every member may use, starting with `ccpool_`. Null clears it.
     */
    public function withEnvironmentID(?string $environmentID): self
    {
        $self = clone $this;
        $self['environmentID'] = $environmentID;

        return $self;
    }

    /**
     * What Claude does in a channel while a Slack guest is in it. Null clears it.
     *
     * @param ClaudeTagGuestPolicyShape|null $guestPolicy
     */
    public function withGuestPolicy(
        ClaudeTagGuestPolicyAllow|array|ClaudeTagGuestPolicyRestrict|ClaudeTagGuestPolicyChannelOnly|null $guestPolicy,
    ): self {
        $self = clone $this;
        $self['guestPolicy'] = $guestPolicy;

        return $self;
    }

    /**
     * Instructions for Claude, up to 8,192 characters after leading and trailing white space is trimmed. Null or blank text clears them.
     */
    public function withInstructions(?string $instructions): self
    {
        $self = clone $this;
        $self['instructions'] = $instructions;

        return $self;
    }

    /**
     * The model Claude uses: the identifier of a model, or the name of a model line, that the organization is entitled to for Claude Tag. Null clears it.
     */
    public function withModel(?string $model): self
    {
        $self = clone $this;
        $self['model'] = $model;

        return $self;
    }

    /**
     * How Claude takes part in the channel: `automatic`, `mention_only`, `always_awake` or `thread`. Only a channel takes one: an update of a workspace that sends a value is refused, and one that sends null changes nothing. Null never clears it: sent to a channel that stores none it changes nothing, and sent to a channel that stores one it is refused, because a stored reply mode can be changed but never cleared; a caller that wants Claude's default behavior sends `automatic`.
     *
     * @param ClaudeTagReplyModeShape|null $replyMode
     */
    public function withReplyMode(
        ClaudeTagReplyModeAutomatic|array|ClaudeTagReplyModeMentionOnly|ClaudeTagReplyModeAlwaysAwake|ClaudeTagReplyModeThread|null $replyMode,
    ): self {
        $self = clone $this;
        $self['replyMode'] = $replyMode;

        return $self;
    }
}
