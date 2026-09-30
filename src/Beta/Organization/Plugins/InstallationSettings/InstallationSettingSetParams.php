<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins\InstallationSettings;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\Plugins\InstallationSettings\InstallationSettingSetParams\InstallationPreference;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Set or change an organization-owned Plugin's installation setting for the whole
 * organization or for one RBAC Group.
 *
 * Writing the value a target already holds of its own changes nothing.
 *
 * A member-owned Plugin has shares instead of installation settings, so this path
 * returns 404 for one.
 *
 * Send a Plugin's installation-setting writes one at a time. If several writes for the
 * same Plugin arrive at the same time, the server handles them one after another and
 * can answer some of them with `503` instead of applying them. That `503` carries
 * `x-should-retry: true`, and the write is safe to repeat: wait a second or two, then
 * send it again.
 *
 * **Accepted credentials:** an Admin API key with the `write:plugins` scope.
 *
 * Every request must include the beta header `anthropic-beta: ce-plugins-2026-09-01`. A request without it returns `404`, exactly as if the endpoint did not exist. The Plugins API is in beta and is available to Claude Enterprise organizations only. It is not available to Claude Platform (Claude Console) organizations, or to organizations with HIPAA readiness enabled.
 *
 * @see Anthropic\Services\Beta\Organization\Plugins\InstallationSettingsService::set()
 *
 * @phpstan-type InstallationSettingSetParamsShape = array{
 *   pluginID: string,
 *   installationPreference: InstallationPreference|value-of<InstallationPreference>,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class InstallationSettingSetParams implements BaseModel
{
    /** @use SdkModel<InstallationSettingSetParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * ID of the Plugin (prefixed `plugin_`).
     */
    #[Required]
    public string $pluginID;

    /**
     * The installation setting the target is to hold for this Plugin: one of `required`, `auto_install`, `available`, `not_available`.
     *
     * @var value-of<InstallationPreference> $installationPreference
     */
    #[Required('installation_preference', enum: InstallationPreference::class)]
    public string $installationPreference;

    /**
     * This endpoint is in beta: requests must send `ce-plugins-2026-09-01` in this header.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new InstallationSettingSetParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * InstallationSettingSetParams::with(pluginID: ..., installationPreference: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new InstallationSettingSetParams)
     *   ->withPluginID(...)
     *   ->withInstallationPreference(...)
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
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        string $pluginID,
        InstallationPreference|string $installationPreference,
        ?array $betas = null,
    ): self {
        $self = new self;

        $self['pluginID'] = $pluginID;
        $self['installationPreference'] = $installationPreference;

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
     * The installation setting the target is to hold for this Plugin: one of `required`, `auto_install`, `available`, `not_available`.
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
