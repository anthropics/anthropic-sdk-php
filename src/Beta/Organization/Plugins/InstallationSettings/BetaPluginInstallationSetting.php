<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins\InstallationSettings;

use Anthropic\Beta\Organization\Plugins\InstallationSettings\BetaPluginInstallationSetting\InstallationPreference;
use Anthropic\Beta\Organization\Plugins\InstallationSettings\BetaPluginInstallationSetting\Target;
use Anthropic\Beta\Organization\Plugins\PluginTargetOrganization;
use Anthropic\Beta\Organization\Plugins\PluginTargetOrganizationMember;
use Anthropic\Beta\Organization\Plugins\PluginTargetRBACGroup;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The installation setting an organization-owned Plugin holds for one
 * target. It has no ID of its own: it is addressed by the Plugin's ID and the
 * target.
 *
 * @phpstan-import-type TargetVariants from \Anthropic\Beta\Organization\Plugins\InstallationSettings\BetaPluginInstallationSetting\Target
 * @phpstan-import-type TargetShape from \Anthropic\Beta\Organization\Plugins\InstallationSettings\BetaPluginInstallationSetting\Target
 *
 * @phpstan-type BetaPluginInstallationSettingShape = array{
 *   createdAt: \DateTimeInterface,
 *   installationPreference: InstallationPreference|value-of<InstallationPreference>,
 *   pluginID: string,
 *   target: TargetShape,
 *   type: 'plugin_installation_setting',
 *   updatedAt: \DateTimeInterface,
 * }
 */
final class BetaPluginInstallationSetting implements BaseModel
{
    /** @use SdkModel<BetaPluginInstallationSettingShape> */
    use SdkModel;

    /**
     * Always `plugin_installation_setting`.
     *
     * @var 'plugin_installation_setting' $type
     */
    #[Required(type: new ConstantOf('plugin_installation_setting'))]
    public string $type = 'plugin_installation_setting';

    /**
     * When the target was first given a setting for this Plugin.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * The setting the target holds for this Plugin. One of `required`, `auto_install`, `available`, `not_available`; a value this API does not yet name is returned as stored.
     *
     * @var value-of<InstallationPreference> $installationPreference
     */
    #[Required('installation_preference', enum: InstallationPreference::class)]
    public string $installationPreference;

    /**
     * The Plugin's ID.
     */
    #[Required('plugin_id')]
    public string $pluginID;

    /**
     * Whose setting this is: `organization` (the Plugin's own organization-wide setting) or `rbac_group` (one RBAC Group's own setting); `organization_member` does not occur here.
     *
     * @var TargetVariants $target
     */
    #[Required(union: Target::class)]
    public PluginTargetOrganization|PluginTargetRBACGroup|PluginTargetOrganizationMember $target;

    /**
     * When its setting last changed.
     */
    #[Required('updated_at')]
    public \DateTimeInterface $updatedAt;

    /**
     * `new BetaPluginInstallationSetting()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaPluginInstallationSetting::with(
     *   createdAt: ...,
     *   installationPreference: ...,
     *   pluginID: ...,
     *   target: ...,
     *   updatedAt: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaPluginInstallationSetting)
     *   ->withCreatedAt(...)
     *   ->withInstallationPreference(...)
     *   ->withPluginID(...)
     *   ->withTarget(...)
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
     * @param InstallationPreference|value-of<InstallationPreference> $installationPreference
     * @param TargetShape $target
     */
    public static function with(
        \DateTimeInterface $createdAt,
        InstallationPreference|string $installationPreference,
        string $pluginID,
        PluginTargetOrganization|array|PluginTargetRBACGroup|PluginTargetOrganizationMember $target,
        \DateTimeInterface $updatedAt,
    ): self {
        $self = new self;

        $self['createdAt'] = $createdAt;
        $self['installationPreference'] = $installationPreference;
        $self['pluginID'] = $pluginID;
        $self['target'] = $target;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * When the target was first given a setting for this Plugin.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * The setting the target holds for this Plugin. One of `required`, `auto_install`, `available`, `not_available`; a value this API does not yet name is returned as stored.
     *
     * @param InstallationPreference|value-of<InstallationPreference> $installationPreference
     */
    public function withInstallationPreference(
        InstallationPreference|string $installationPreference
    ): self {
        $self = clone $this;
        $self['installationPreference'] = $installationPreference;

        return $self;
    }

    /**
     * The Plugin's ID.
     */
    public function withPluginID(string $pluginID): self
    {
        $self = clone $this;
        $self['pluginID'] = $pluginID;

        return $self;
    }

    /**
     * Whose setting this is: `organization` (the Plugin's own organization-wide setting) or `rbac_group` (one RBAC Group's own setting); `organization_member` does not occur here.
     *
     * @param TargetShape $target
     */
    public function withTarget(
        PluginTargetOrganization|array|PluginTargetRBACGroup|PluginTargetOrganizationMember $target,
    ): self {
        $self = clone $this;
        $self['target'] = $target;

        return $self;
    }

    /**
     * Always `plugin_installation_setting`.
     *
     * @param 'plugin_installation_setting' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * When its setting last changed.
     */
    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
