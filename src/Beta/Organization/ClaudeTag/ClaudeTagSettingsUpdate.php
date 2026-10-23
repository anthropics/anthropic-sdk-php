<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The settings to change. A setting left out is unchanged. A setting sent as null is cleared, so it is inherited.
 *
 * @phpstan-import-type ClaudeTagGuestPolicyShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagGuestPolicy
 * @phpstan-import-type ClaudeTagGuestPolicyVariants from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagGuestPolicy
 *
 * @phpstan-type ClaudeTagSettingsUpdateShape = array{
 *   enabled?: bool|null,
 *   environmentID?: string|null,
 *   guestPolicy?: ClaudeTagGuestPolicyShape|null,
 *   instructions?: string|null,
 *   model?: string|null,
 * }
 */
final class ClaudeTagSettingsUpdate implements BaseModel
{
    /** @use SdkModel<ClaudeTagSettingsUpdateShape> */
    use SdkModel;

    /**
     * Whether Claude is on. `true` on a channel turns Claude on in it even when its workspace stores `false`. Null clears it.
     */
    #[Optional(nullable: true)]
    public ?bool $enabled;

    /**
     * The environment Claude's sessions run in: the identifier of an active environment of the organization, starting with `env_`. Null clears it.
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
     */
    public static function with(
        ?bool $enabled = null,
        ?string $environmentID = null,
        ClaudeTagGuestPolicyAllow|array|ClaudeTagGuestPolicyRestrict|ClaudeTagGuestPolicyChannelOnly|null $guestPolicy = null,
        ?string $instructions = null,
        ?string $model = null,
    ): self {
        $self = new self;

        null !== $enabled && $self['enabled'] = $enabled;
        null !== $environmentID && $self['environmentID'] = $environmentID;
        null !== $guestPolicy && $self['guestPolicy'] = $guestPolicy;
        null !== $instructions && $self['instructions'] = $instructions;
        null !== $model && $self['model'] = $model;

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
     * The environment Claude's sessions run in: the identifier of an active environment of the organization, starting with `env_`. Null clears it.
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
}
