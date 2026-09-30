<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins\InstallationSettings;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Remove an organization-owned Plugin's own installation setting for the whole
 * organization or for one RBAC Group.
 *
 * Removing the `organization` target returns the Plugin to its marketplace's default
 * installation setting and leaves the groups' settings in place. Removing a group's
 * setting makes the group's members fall back to the Plugin's organization-wide setting
 * or to the settings of their other groups.
 *
 * A target that holds no setting of its own returns 404 (a Plugin that already inherits
 * its marketplace's default holds no `organization` setting), and so does a member-owned
 * Plugin.
 *
 * A removal counts as one of the Plugin's installation-setting writes: send all of those
 * writes one at a time. If several arrive for the same Plugin at the same time, the server
 * handles them one after another and can answer some of them with `503` and
 * `x-should-retry: true` instead of applying them; wait a second or two and send the
 * removal again. A `404` on the repeat means the setting is already gone.
 *
 * **Accepted credentials:** an Admin API key with the `write:plugins` scope.
 *
 * Every request must include the beta header `anthropic-beta: ce-plugins-2026-09-01`. A request without it returns `404`, exactly as if the endpoint did not exist. The Plugins API is in beta and is available to Claude Enterprise organizations only. It is not available to Claude Platform (Claude Console) organizations, or to organizations with HIPAA readiness enabled.
 *
 * @see Anthropic\Services\Beta\Organization\Plugins\InstallationSettingsService::remove()
 *
 * @phpstan-type InstallationSettingRemoveParamsShape = array{
 *   pluginID: string,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class InstallationSettingRemoveParams implements BaseModel
{
    /** @use SdkModel<InstallationSettingRemoveParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * ID of the Plugin (prefixed `plugin_`).
     */
    #[Required]
    public string $pluginID;

    /**
     * This endpoint is in beta: requests must send `ce-plugins-2026-09-01` in this header.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new InstallationSettingRemoveParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * InstallationSettingRemoveParams::with(pluginID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new InstallationSettingRemoveParams)->withPluginID(...)
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
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(string $pluginID, ?array $betas = null): self
    {
        $self = new self;

        $self['pluginID'] = $pluginID;

        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * ID of the Plugin (prefixed `plugin_`).
     */
    public function withPluginID(string $pluginID): self
    {
        $self = clone $this;
        $self['pluginID'] = $pluginID;

        return $self;
    }

    /**
     * This endpoint is in beta: requests must send `ce-plugins-2026-09-01` in this header.
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
