<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\Configuration;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-import-type BetaClaudeCodeManagedSettingsModeShape from \Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\Configuration\BetaClaudeCodeManagedSettingsMode
 * @phpstan-import-type BetaClaudeCodeManagedSettingsModeVariants from \Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\Configuration\BetaClaudeCodeManagedSettingsMode
 *
 * @phpstan-type BetaClaudeCodeManagedSettingsConfigurationShape = array{
 *   mode: BetaClaudeCodeManagedSettingsModeShape,
 *   modeUpdatedAt: \DateTimeInterface|null,
 *   rbacGroupOrder: list<string>,
 *   rbacGroupOrderVersion: string,
 *   type: 'claude_code_managed_settings_configuration',
 * }
 */
final class BetaClaudeCodeManagedSettingsConfiguration implements BaseModel
{
    /** @use SdkModel<BetaClaudeCodeManagedSettingsConfigurationShape> */
    use SdkModel;

    /**
     * Always `claude_code_managed_settings_configuration`.
     *
     * @var 'claude_code_managed_settings_configuration' $type
     */
    #[Required(
        type: new ConstantOf('claude_code_managed_settings_configuration')
    )]
    public string $type = 'claude_code_managed_settings_configuration';

    /**
     * How the organization serves managed settings. In `organization` mode every member receives the organization settings, which are set in claude.ai. In `rbac_groups` mode each member receives the settings of the first RBAC Group in `rbac_group_order` that they belong to. A member in none of them receives the default settings, or no settings if no default is set.
     *
     * @var BetaClaudeCodeManagedSettingsModeVariants $mode
     */
    #[Required(union: BetaClaudeCodeManagedSettingsMode::class)]
    public BetaClaudeCodeManagedSettingsOrganizationMode|BetaClaudeCodeManagedSettingsRBACGroupsMode $mode;

    /**
     * When the mode last changed, in RFC 3339 format, or `null` if it never has.
     */
    #[Required('mode_updated_at')]
    public ?\DateTimeInterface $modeUpdatedAt;

    /**
     * The ID of every RBAC Group with settings, deleted groups included, highest precedence first.
     *
     * @var list<string> $rbacGroupOrder
     */
    #[Required('rbac_group_order', list: 'string')]
    public array $rbacGroupOrder;

    /**
     * An opaque version of `rbac_group_order`, which changes whenever the order does. Send it back with a new order.
     */
    #[Required('rbac_group_order_version')]
    public string $rbacGroupOrderVersion;

    /**
     * `new BetaClaudeCodeManagedSettingsConfiguration()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaClaudeCodeManagedSettingsConfiguration::with(
     *   mode: ..., modeUpdatedAt: ..., rbacGroupOrder: ..., rbacGroupOrderVersion: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaClaudeCodeManagedSettingsConfiguration())
     *   ->withMode(...)
     *   ->withModeUpdatedAt(...)
     *   ->withRBACGroupOrder(...)
     *   ->withRBACGroupOrderVersion(...)
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
     * @param BetaClaudeCodeManagedSettingsModeShape $mode
     * @param list<string> $rbacGroupOrder
     */
    public static function with(
        BetaClaudeCodeManagedSettingsOrganizationMode|array|BetaClaudeCodeManagedSettingsRBACGroupsMode $mode,
        ?\DateTimeInterface $modeUpdatedAt,
        array $rbacGroupOrder,
        string $rbacGroupOrderVersion,
    ): self {
        $self = new self;

        $self['mode'] = $mode;
        $self['modeUpdatedAt'] = $modeUpdatedAt;
        $self['rbacGroupOrder'] = $rbacGroupOrder;
        $self['rbacGroupOrderVersion'] = $rbacGroupOrderVersion;

        return $self;
    }

    /**
     * How the organization serves managed settings. In `organization` mode every member receives the organization settings, which are set in claude.ai. In `rbac_groups` mode each member receives the settings of the first RBAC Group in `rbac_group_order` that they belong to. A member in none of them receives the default settings, or no settings if no default is set.
     *
     * @param BetaClaudeCodeManagedSettingsModeShape $mode
     */
    public function withMode(
        BetaClaudeCodeManagedSettingsOrganizationMode|array|BetaClaudeCodeManagedSettingsRBACGroupsMode $mode,
    ): self {
        $self = clone $this;
        $self['mode'] = $mode;

        return $self;
    }

    /**
     * When the mode last changed, in RFC 3339 format, or `null` if it never has.
     */
    public function withModeUpdatedAt(?\DateTimeInterface $modeUpdatedAt): self
    {
        $self = clone $this;
        $self['modeUpdatedAt'] = $modeUpdatedAt;

        return $self;
    }

    /**
     * The ID of every RBAC Group with settings, deleted groups included, highest precedence first.
     *
     * @param list<string> $rbacGroupOrder
     */
    public function withRBACGroupOrder(array $rbacGroupOrder): self
    {
        $self = clone $this;
        $self['rbacGroupOrder'] = $rbacGroupOrder;

        return $self;
    }

    /**
     * An opaque version of `rbac_group_order`, which changes whenever the order does. Send it back with a new order.
     */
    public function withRBACGroupOrderVersion(
        string $rbacGroupOrderVersion
    ): self {
        $self = clone $this;
        $self['rbacGroupOrderVersion'] = $rbacGroupOrderVersion;

        return $self;
    }

    /**
     * Always `claude_code_managed_settings_configuration`.
     *
     * @param 'claude_code_managed_settings_configuration' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
