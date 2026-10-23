<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * For each setting, the settings level its value in `settings` comes from. Without `include_inherited`, a setting the channel or workspace stores has a source that names the channel or workspace itself, and one it does not store has null, or an empty list for `instructions`. With `include_inherited=true` no member is null: a value that no settings level sets has the source `default`.
 *
 * @phpstan-import-type ClaudeTagSettingSourceShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSettingSource
 * @phpstan-import-type ClaudeTagSettingSourceVariants from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSettingSource
 *
 * @phpstan-type ClaudeTagSettingSourcesShape = array{
 *   enabled: ClaudeTagSettingSourceShape|null,
 *   environmentID: ClaudeTagSettingSourceShape|null,
 *   guestPolicy: ClaudeTagSettingSourceShape|null,
 *   instructions: list<ClaudeTagSettingSourceShape>,
 *   model: ClaudeTagSettingSourceShape|null,
 * }
 */
final class ClaudeTagSettingSources implements BaseModel
{
    /** @use SdkModel<ClaudeTagSettingSourcesShape> */
    use SdkModel;

    /**
     * The settings level `enabled` comes from.
     *
     * @var ClaudeTagSettingSourceVariants|null $enabled
     */
    #[Required(union: ClaudeTagSettingSource::class)]
    public ClaudeTagSlackChannelSettingSource|ClaudeTagSlackWorkspaceSettingSource|ClaudeTagSlackParentChannelSettingSource|ClaudeTagSlackDefaultSettingSource|ClaudeTagDefaultSettingSource|ClaudeTagSlackGridChannelSettingSource|null $enabled;

    /**
     * The settings level `environment_id` comes from.
     *
     * @var ClaudeTagSettingSourceVariants|null $environmentID
     */
    #[Required('environment_id', union: ClaudeTagSettingSource::class)]
    public ClaudeTagSlackChannelSettingSource|ClaudeTagSlackWorkspaceSettingSource|ClaudeTagSlackParentChannelSettingSource|ClaudeTagSlackDefaultSettingSource|ClaudeTagDefaultSettingSource|ClaudeTagSlackGridChannelSettingSource|null $environmentID;

    /**
     * The settings level `guest_policy` comes from.
     *
     * @var ClaudeTagSettingSourceVariants|null $guestPolicy
     */
    #[Required('guest_policy', union: ClaudeTagSettingSource::class)]
    public ClaudeTagSlackChannelSettingSource|ClaudeTagSlackWorkspaceSettingSource|ClaudeTagSlackParentChannelSettingSource|ClaudeTagSlackDefaultSettingSource|ClaudeTagDefaultSettingSource|ClaudeTagSlackGridChannelSettingSource|null $guestPolicy;

    /**
     * Every settings level that contributes text to `instructions`, broadest first, in the order their text is joined. Empty when none does.
     *
     * @var list<ClaudeTagSettingSourceVariants> $instructions
     */
    #[Required(list: ClaudeTagSettingSource::class)]
    public array $instructions;

    /**
     * The settings level `model` comes from.
     *
     * @var ClaudeTagSettingSourceVariants|null $model
     */
    #[Required(union: ClaudeTagSettingSource::class)]
    public ClaudeTagSlackChannelSettingSource|ClaudeTagSlackWorkspaceSettingSource|ClaudeTagSlackParentChannelSettingSource|ClaudeTagSlackDefaultSettingSource|ClaudeTagDefaultSettingSource|ClaudeTagSlackGridChannelSettingSource|null $model;

    /**
     * `new ClaudeTagSettingSources()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ClaudeTagSettingSources::with(
     *   enabled: ...,
     *   environmentID: ...,
     *   guestPolicy: ...,
     *   instructions: ...,
     *   model: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ClaudeTagSettingSources())
     *   ->withEnabled(...)
     *   ->withEnvironmentID(...)
     *   ->withGuestPolicy(...)
     *   ->withInstructions(...)
     *   ->withModel(...)
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
     * @param ClaudeTagSettingSourceShape|null $enabled
     * @param ClaudeTagSettingSourceShape|null $environmentID
     * @param ClaudeTagSettingSourceShape|null $guestPolicy
     * @param list<ClaudeTagSettingSourceShape> $instructions
     * @param ClaudeTagSettingSourceShape|null $model
     */
    public static function with(
        ClaudeTagSlackChannelSettingSource|array|ClaudeTagSlackWorkspaceSettingSource|ClaudeTagSlackParentChannelSettingSource|ClaudeTagSlackDefaultSettingSource|ClaudeTagDefaultSettingSource|ClaudeTagSlackGridChannelSettingSource|null $enabled,
        ClaudeTagSlackChannelSettingSource|array|ClaudeTagSlackWorkspaceSettingSource|ClaudeTagSlackParentChannelSettingSource|ClaudeTagSlackDefaultSettingSource|ClaudeTagDefaultSettingSource|ClaudeTagSlackGridChannelSettingSource|null $environmentID,
        ClaudeTagSlackChannelSettingSource|array|ClaudeTagSlackWorkspaceSettingSource|ClaudeTagSlackParentChannelSettingSource|ClaudeTagSlackDefaultSettingSource|ClaudeTagDefaultSettingSource|ClaudeTagSlackGridChannelSettingSource|null $guestPolicy,
        array $instructions,
        ClaudeTagSlackChannelSettingSource|array|ClaudeTagSlackWorkspaceSettingSource|ClaudeTagSlackParentChannelSettingSource|ClaudeTagSlackDefaultSettingSource|ClaudeTagDefaultSettingSource|ClaudeTagSlackGridChannelSettingSource|null $model,
    ): self {
        $self = new self;

        $self['enabled'] = $enabled;
        $self['environmentID'] = $environmentID;
        $self['guestPolicy'] = $guestPolicy;
        $self['instructions'] = $instructions;
        $self['model'] = $model;

        return $self;
    }

    /**
     * The settings level `enabled` comes from.
     *
     * @param ClaudeTagSettingSourceShape|null $enabled
     */
    public function withEnabled(
        ClaudeTagSlackChannelSettingSource|array|ClaudeTagSlackWorkspaceSettingSource|ClaudeTagSlackParentChannelSettingSource|ClaudeTagSlackDefaultSettingSource|ClaudeTagDefaultSettingSource|ClaudeTagSlackGridChannelSettingSource|null $enabled,
    ): self {
        $self = clone $this;
        $self['enabled'] = $enabled;

        return $self;
    }

    /**
     * The settings level `environment_id` comes from.
     *
     * @param ClaudeTagSettingSourceShape|null $environmentID
     */
    public function withEnvironmentID(
        ClaudeTagSlackChannelSettingSource|array|ClaudeTagSlackWorkspaceSettingSource|ClaudeTagSlackParentChannelSettingSource|ClaudeTagSlackDefaultSettingSource|ClaudeTagDefaultSettingSource|ClaudeTagSlackGridChannelSettingSource|null $environmentID,
    ): self {
        $self = clone $this;
        $self['environmentID'] = $environmentID;

        return $self;
    }

    /**
     * The settings level `guest_policy` comes from.
     *
     * @param ClaudeTagSettingSourceShape|null $guestPolicy
     */
    public function withGuestPolicy(
        ClaudeTagSlackChannelSettingSource|array|ClaudeTagSlackWorkspaceSettingSource|ClaudeTagSlackParentChannelSettingSource|ClaudeTagSlackDefaultSettingSource|ClaudeTagDefaultSettingSource|ClaudeTagSlackGridChannelSettingSource|null $guestPolicy,
    ): self {
        $self = clone $this;
        $self['guestPolicy'] = $guestPolicy;

        return $self;
    }

    /**
     * Every settings level that contributes text to `instructions`, broadest first, in the order their text is joined. Empty when none does.
     *
     * @param list<ClaudeTagSettingSourceShape> $instructions
     */
    public function withInstructions(array $instructions): self
    {
        $self = clone $this;
        $self['instructions'] = $instructions;

        return $self;
    }

    /**
     * The settings level `model` comes from.
     *
     * @param ClaudeTagSettingSourceShape|null $model
     */
    public function withModel(
        ClaudeTagSlackChannelSettingSource|array|ClaudeTagSlackWorkspaceSettingSource|ClaudeTagSlackParentChannelSettingSource|ClaudeTagSlackDefaultSettingSource|ClaudeTagDefaultSettingSource|ClaudeTagSlackGridChannelSettingSource|null $model,
    ): self {
        $self = clone $this;
        $self['model'] = $model;

        return $self;
    }
}
