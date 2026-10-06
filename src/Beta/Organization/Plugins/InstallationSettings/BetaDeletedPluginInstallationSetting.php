<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins\InstallationSettings;

use Anthropic\Beta\Organization\Plugins\InstallationSettings\BetaDeletedPluginInstallationSetting\Target;
use Anthropic\Beta\Organization\Plugins\PluginTargetOrganization;
use Anthropic\Beta\Organization\Plugins\PluginTargetOrganizationMember;
use Anthropic\Beta\Organization\Plugins\PluginTargetRBACGroup;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Confirmation that one target's installation setting was removed, naming
 * the Plugin and the target in place of an ID.
 *
 * @phpstan-import-type TargetShape from \Anthropic\Beta\Organization\Plugins\InstallationSettings\BetaDeletedPluginInstallationSetting\Target
 * @phpstan-import-type TargetVariants from \Anthropic\Beta\Organization\Plugins\InstallationSettings\BetaDeletedPluginInstallationSetting\Target
 *
 * @phpstan-type BetaDeletedPluginInstallationSettingShape = array{
 *   pluginID: string,
 *   target: TargetShape,
 *   type: 'plugin_installation_setting_deleted',
 * }
 */
final class BetaDeletedPluginInstallationSetting implements BaseModel
{
    /** @use SdkModel<BetaDeletedPluginInstallationSettingShape> */
    use SdkModel;

    /**
     * Always `plugin_installation_setting_deleted`.
     *
     * @var 'plugin_installation_setting_deleted' $type
     */
    #[Required(type: new ConstantOf('plugin_installation_setting_deleted'))]
    public string $type = 'plugin_installation_setting_deleted';

    /**
     * The Plugin's ID.
     */
    #[Required('plugin_id')]
    public string $pluginID;

    /**
     * Whose setting was removed.
     *
     * @var TargetVariants $target
     */
    #[Required(union: Target::class)]
    public PluginTargetOrganization|PluginTargetRBACGroup|PluginTargetOrganizationMember $target;

    /**
     * `new BetaDeletedPluginInstallationSetting()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaDeletedPluginInstallationSetting::with(pluginID: ..., target: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaDeletedPluginInstallationSetting())->withPluginID(...)->withTarget(...)
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
     * @param TargetShape $target
     */
    public static function with(
        string $pluginID,
        PluginTargetOrganization|array|PluginTargetRBACGroup|PluginTargetOrganizationMember $target,
    ): self {
        $self = new self;

        $self['pluginID'] = $pluginID;
        $self['target'] = $target;

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
     * Whose setting was removed.
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
     * Always `plugin_installation_setting_deleted`.
     *
     * @param 'plugin_installation_setting_deleted' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
