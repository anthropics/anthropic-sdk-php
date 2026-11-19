<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\Configuration;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Change the organization's Claude Code managed settings mode, the RBAC Group order, or both, in one atomic write.
 *
 * To change the order, send `rbac_group_order` with the `rbac_group_order_version` from the read the change is based on. If the order has changed since that read, the request returns `409`: read it again and retry. To switch modes only if the order has not changed, send the current `rbac_group_order` and `rbac_group_order_version` with the new `mode`.
 *
 * A switch to `rbac_groups` mode with no RBAC Group settings and no default settings copies the organization settings into a new default, in the same write, so members keep the settings they had. The copy does not follow later changes to the organization settings. If the organization settings cannot be copied, the request returns `400` and changes nothing. If they cannot be read, are over 1 MiB or are not valid, setting the default settings first avoids the copy.
 *
 * After a switch to `rbac_groups` mode, a member in no listed RBAC Group receives the default settings, or no settings if no default is set, not the organization settings.
 *
 * **Accepted credentials:** an organization-level Admin API key with the `write:claude_code_managed_settings` scope.
 *
 * Every request must include the beta header `anthropic-beta: ce-claude-code-managed-settings-2026-10-06`. A request without it, or from an organization not enabled for this beta, returns `404`. The Claude Code Managed Settings API is in beta and is available to Claude Enterprise organizations only.
 *
 * A write that returns `503` may have applied. Retrying it is safe.
 *
 * @see Anthropic\Services\Beta\Organization\ClaudeCode\ManagedSettings\ConfigurationService::update()
 *
 * @phpstan-import-type BetaClaudeCodeManagedSettingsModeParamShape from \Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\Configuration\BetaClaudeCodeManagedSettingsModeParam
 * @phpstan-import-type BetaClaudeCodeManagedSettingsModeParamVariants from \Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\Configuration\BetaClaudeCodeManagedSettingsModeParam
 *
 * @phpstan-type ConfigurationUpdateParamsShape = array{
 *   mode?: BetaClaudeCodeManagedSettingsModeParamShape|null,
 *   rbacGroupOrder?: list<string>|null,
 *   rbacGroupOrderVersion?: string|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class ConfigurationUpdateParams implements BaseModel
{
    /** @use SdkModel<ConfigurationUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * The new mode, as an object such as `{"type": "rbac_groups"}`.
     *
     * @var BetaClaudeCodeManagedSettingsModeParamVariants|null $mode
     */
    #[Optional(union: BetaClaudeCodeManagedSettingsModeParam::class)]
    public BetaClaudeCodeManagedSettingsOrganizationModeParam|BetaClaudeCodeManagedSettingsRBACGroupsModeParam|null $mode;

    /**
     * Every RBAC Group that has settings, each listed once, in the new order, highest precedence first. Requires `rbac_group_order_version`.
     *
     * @var list<string>|null $rbacGroupOrder
     */
    #[Optional('rbac_group_order', list: 'string')]
    public ?array $rbacGroupOrder;

    /**
     * The `rbac_group_order_version` from the read this change is based on. Requires `rbac_group_order`.
     */
    #[Optional('rbac_group_order_version')]
    public ?string $rbacGroupOrderVersion;

    /**
     * This endpoint is in beta: requests must send `ce-claude-code-managed-settings-2026-10-06` in this header.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param BetaClaudeCodeManagedSettingsModeParamShape|null $mode
     * @param list<string>|null $rbacGroupOrder
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        BetaClaudeCodeManagedSettingsOrganizationModeParam|array|BetaClaudeCodeManagedSettingsRBACGroupsModeParam|null $mode = null,
        ?array $rbacGroupOrder = null,
        ?string $rbacGroupOrderVersion = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        null !== $mode && $self['mode'] = $mode;
        null !== $rbacGroupOrder && $self['rbacGroupOrder'] = $rbacGroupOrder;
        null !== $rbacGroupOrderVersion && $self['rbacGroupOrderVersion'] = $rbacGroupOrderVersion;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * The new mode, as an object such as `{"type": "rbac_groups"}`.
     *
     * @param BetaClaudeCodeManagedSettingsModeParamShape $mode
     */
    public function withMode(
        BetaClaudeCodeManagedSettingsOrganizationModeParam|array|BetaClaudeCodeManagedSettingsRBACGroupsModeParam $mode,
    ): self {
        $self = clone $this;
        $self['mode'] = $mode;

        return $self;
    }

    /**
     * Every RBAC Group that has settings, each listed once, in the new order, highest precedence first. Requires `rbac_group_order_version`.
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
     * The `rbac_group_order_version` from the read this change is based on. Requires `rbac_group_order`.
     */
    public function withRBACGroupOrderVersion(
        string $rbacGroupOrderVersion
    ): self {
        $self = clone $this;
        $self['rbacGroupOrderVersion'] = $rbacGroupOrderVersion;

        return $self;
    }

    /**
     * This endpoint is in beta: requests must send `ce-claude-code-managed-settings-2026-10-06` in this header.
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
