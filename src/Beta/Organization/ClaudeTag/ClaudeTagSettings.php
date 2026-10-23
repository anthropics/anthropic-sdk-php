<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Claude Tag settings. Without `include_inherited`, a setting that is null is not set on the settings level and is inherited. With it, `enabled` and `guest_policy` are never null, and `instructions`, `model` and `environment_id` are null when no settings level sets them.
 *
 * @phpstan-import-type ClaudeTagGuestPolicyShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagGuestPolicy
 * @phpstan-import-type ClaudeTagGuestPolicyVariants from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagGuestPolicy
 *
 * @phpstan-type ClaudeTagSettingsShape = array{
 *   enabled: bool|null,
 *   environmentID: string|null,
 *   guestPolicy: ClaudeTagGuestPolicyShape|null,
 *   instructions: string|null,
 *   model: string|null,
 * }
 */
final class ClaudeTagSettings implements BaseModel
{
    /** @use SdkModel<ClaudeTagSettingsShape> */
    use SdkModel;

    /**
     * Whether Claude is on. The nearest settings level that sets it decides.
     */
    #[Required]
    public ?bool $enabled;

    /**
     * The environment Claude's sessions run in, starting with `env_`, or the identifier of a self-hosted runner pool, starting with `ccpool_`. The nearest settings level that sets it decides.
     */
    #[Required('environment_id')]
    public ?string $environmentID;

    /**
     * What Claude does in a channel while a Slack guest is in it. The nearest settings level that sets it decides.
     *
     * @var ClaudeTagGuestPolicyVariants|null $guestPolicy
     */
    #[Required('guest_policy', union: ClaudeTagGuestPolicy::class)]
    public ClaudeTagGuestPolicyAllow|ClaudeTagGuestPolicyRestrict|ClaudeTagGuestPolicyChannelOnly|null $guestPolicy;

    /**
     * Instructions for Claude. Instructions add up: the text of every settings level that sets it is joined, broadest first.
     */
    #[Required]
    public ?string $instructions;

    /**
     * The model Claude uses: a model identifier or the name of a model line. The nearest settings level that sets it decides. When none does, Claude uses the product's default model.
     */
    #[Required]
    public ?string $model;

    /**
     * `new ClaudeTagSettings()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ClaudeTagSettings::with(
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
     * (new ClaudeTagSettings())
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
     * @param ClaudeTagGuestPolicyShape|null $guestPolicy
     */
    public static function with(
        ?bool $enabled,
        ?string $environmentID,
        ClaudeTagGuestPolicyAllow|array|ClaudeTagGuestPolicyRestrict|ClaudeTagGuestPolicyChannelOnly|null $guestPolicy,
        ?string $instructions,
        ?string $model,
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
     * Whether Claude is on. The nearest settings level that sets it decides.
     */
    public function withEnabled(?bool $enabled): self
    {
        $self = clone $this;
        $self['enabled'] = $enabled;

        return $self;
    }

    /**
     * The environment Claude's sessions run in, starting with `env_`, or the identifier of a self-hosted runner pool, starting with `ccpool_`. The nearest settings level that sets it decides.
     */
    public function withEnvironmentID(?string $environmentID): self
    {
        $self = clone $this;
        $self['environmentID'] = $environmentID;

        return $self;
    }

    /**
     * What Claude does in a channel while a Slack guest is in it. The nearest settings level that sets it decides.
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
     * Instructions for Claude. Instructions add up: the text of every settings level that sets it is joined, broadest first.
     */
    public function withInstructions(?string $instructions): self
    {
        $self = clone $this;
        $self['instructions'] = $instructions;

        return $self;
    }

    /**
     * The model Claude uses: a model identifier or the name of a model line. The nearest settings level that sets it decides. When none does, Claude uses the product's default model.
     */
    public function withModel(?string $model): self
    {
        $self = clone $this;
        $self['model'] = $model;

        return $self;
    }
}
