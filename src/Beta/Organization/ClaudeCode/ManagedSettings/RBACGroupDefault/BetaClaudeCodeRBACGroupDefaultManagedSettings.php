<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroupDefault;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type BetaClaudeCodeRBACGroupDefaultManagedSettingsShape = array{
 *   settings: array<string,mixed>|null,
 *   type: 'claude_code_rbac_group_default_managed_settings',
 *   updatedAt: \DateTimeInterface|null,
 * }
 */
final class BetaClaudeCodeRBACGroupDefaultManagedSettings implements BaseModel
{
    /** @use SdkModel<BetaClaudeCodeRBACGroupDefaultManagedSettingsShape> */
    use SdkModel;

    /**
     * Always `claude_code_rbac_group_default_managed_settings`.
     *
     * @var 'claude_code_rbac_group_default_managed_settings' $type
     */
    #[Required(
        type: new ConstantOf('claude_code_rbac_group_default_managed_settings')
    )]
    public string $type = 'claude_code_rbac_group_default_managed_settings';

    /**
     * The default settings document, or `null` if none are set or the stored document is damaged and can no longer be read. To tell these apart, `updated_at` is `null` only when none are set. Replacing a damaged document fixes this.
     *
     * @var array<string,mixed>|null $settings
     */
    #[Required(map: 'mixed')]
    public ?array $settings;

    /**
     * When the default settings last changed, in RFC 3339 format, or `null` if none are set.
     */
    #[Required('updated_at')]
    public ?\DateTimeInterface $updatedAt;

    /**
     * `new BetaClaudeCodeRBACGroupDefaultManagedSettings()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaClaudeCodeRBACGroupDefaultManagedSettings::with(
     *   settings: ..., updatedAt: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaClaudeCodeRBACGroupDefaultManagedSettings())
     *   ->withSettings(...)
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
     * @param array<string,mixed>|null $settings
     */
    public static function with(
        ?array $settings,
        ?\DateTimeInterface $updatedAt
    ): self {
        $self = new self;

        $self['settings'] = $settings;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * The default settings document, or `null` if none are set or the stored document is damaged and can no longer be read. To tell these apart, `updated_at` is `null` only when none are set. Replacing a damaged document fixes this.
     *
     * @param array<string,mixed>|null $settings
     */
    public function withSettings(?array $settings): self
    {
        $self = clone $this;
        $self['settings'] = $settings;

        return $self;
    }

    /**
     * Always `claude_code_rbac_group_default_managed_settings`.
     *
     * @param 'claude_code_rbac_group_default_managed_settings' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * When the default settings last changed, in RFC 3339 format, or `null` if none are set.
     */
    public function withUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
