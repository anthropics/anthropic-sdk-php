<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins\Versions;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Download one version's `.zip` archive, exactly as stored. Each download of a
 * Plugin from a member's personal plugin marketplace is recorded on the Compliance API
 * activity feed.
 *
 * The response body is the archive (`Content-Type: application/zip`), sent as an
 * attachment whose filename is derived from the Plugin's name; name saved files from
 * the IDs in the request path, since that filename is not unique.
 *
 * **Accepted credentials:** an Admin API key with the `read:plugins` or `read:org_audit` scope, or a Compliance Access Key with the `read:compliance_org_data` scope.
 *
 * Every read scope above (`read:plugins`, `read:org_audit`, and
 * `read:compliance_org_data`) can download the files of plugins in members' personal
 * marketplaces, including files that claude.ai's admin settings do not show, and a
 * `read:org_audit` or `read:compliance_org_data` key created for all of your parent
 * organization's linked organizations can do this in any organization under it that has
 * access to this API, by passing `organization_id`. Each such download records a
 * `claude_plugin_archive_accessed` event on the Compliance API activity feed,
 * identifying the key, the plugin, the version, and the member. Downloads of
 * organization-owned plugins are not recorded.
 *
 * Every request must include the beta header `anthropic-beta: ce-plugins-2026-09-01`. A request without it returns `404`, exactly as if the endpoint did not exist. The Plugins API is in beta and is available to Claude Enterprise organizations only. It is not available to Claude Platform (Claude Console) organizations, or to organizations with HIPAA readiness enabled.
 *
 * @see Anthropic\Services\Beta\Organization\Plugins\VersionsService::download()
 *
 * @phpstan-type VersionDownloadParamsShape = array{
 *   pluginID: string,
 *   organizationID?: string|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class VersionDownloadParams implements BaseModel
{
    /** @use SdkModel<VersionDownloadParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * ID of the Plugin (prefixed `plugin_`).
     */
    #[Required]
    public string $pluginID;

    /**
     * For a `read:org_audit` or `read:compliance_org_data` key created for all of a parent organization's linked organizations: a child organization of that parent to read instead of the organization the key was created in, given as the organization's UUID or its `org_`-prefixed ID. A value that is neither returns a 400; an organization that is not a child of the key's parent, or where the Plugins API is not available, returns a 404. Any other key may pass only its own organization's ID here; another organization returns a 404.
     */
    #[Optional(nullable: true)]
    public ?string $organizationID;

    /**
     * This endpoint is in beta: requests must send `ce-plugins-2026-09-01` in this header.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new VersionDownloadParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * VersionDownloadParams::with(pluginID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new VersionDownloadParams)->withPluginID(...)
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
    public static function with(
        string $pluginID,
        ?string $organizationID = null,
        ?array $betas = null
    ): self {
        $self = new self;

        $self['pluginID'] = $pluginID;

        null !== $organizationID && $self['organizationID'] = $organizationID;
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
     * For a `read:org_audit` or `read:compliance_org_data` key created for all of a parent organization's linked organizations: a child organization of that parent to read instead of the organization the key was created in, given as the organization's UUID or its `org_`-prefixed ID. A value that is neither returns a 400; an organization that is not a child of the key's parent, or where the Plugins API is not available, returns a 404. Any other key may pass only its own organization's ID here; another organization returns a 404.
     */
    public function withOrganizationID(?string $organizationID): self
    {
        $self = clone $this;
        $self['organizationID'] = $organizationID;

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
