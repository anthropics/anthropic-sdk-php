<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Change which stored version of an organization-owned Plugin is served to members,
 * for example to roll back to an earlier one. This pins the served version: later
 * uploads are stored but no longer change what is served, and pinning cannot currently
 * be undone, here or in claude.ai.
 *
 * Pass the version as `served_version_id`: an earlier one to roll back, a later one to
 * start serving a version that was stored without being served, or the one already
 * served to pin it without changing what is served. No new version is created.
 *
 * When the organization has content scanning enabled, a version whose scan is still
 * running is refused with a 409 (`error_code` `scan_pending`; retry once the scan
 * finishes) and one whose scan failed, errored or reached no verdict with a 400
 * (`scan_failed`; a `warn` is accepted). When the Plugin is in the organization's
 * library marketplace, a version other than the one served is also refused with a 409
 * when one of its skills has a name that an organization skill (one an administrator
 * uploaded for the whole organization in claude.ai) has since taken: `error_code`
 * `skill_name_taken`, with that name in `details.skill_name`. A member-owned Plugin
 * cannot be updated here (403).
 *
 * This endpoint does not write installation settings; they are written at
 * `/v1/organizations/plugins/{plugin_id}/installation_settings/{target}`.
 *
 * **Accepted credentials:** an Admin API key with the `write:plugins` scope.
 *
 * Every request must include the beta header `anthropic-beta: ce-plugins-2026-09-01`. A request without it returns `404`, exactly as if the endpoint did not exist. The Plugins API is in beta and is available to Claude Enterprise organizations only. It is not available to Claude Platform (Claude Console) organizations, or to organizations with HIPAA readiness enabled.
 *
 * @see Anthropic\Services\Beta\Organization\PluginsService::update()
 *
 * @phpstan-type PluginUpdateParamsShape = array{
 *   servedVersionID: string,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class PluginUpdateParams implements BaseModel
{
    /** @use SdkModel<PluginUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Serve this version of the Plugin (prefixed `pluginver_`) and pin the served version to it; `latest` is not accepted.
     */
    #[Required('served_version_id')]
    public string $servedVersionID;

    /**
     * This endpoint is in beta: requests must send `ce-plugins-2026-09-01` in this header.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new PluginUpdateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PluginUpdateParams::with(servedVersionID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PluginUpdateParams())->withServedVersionID(...)
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
        string $servedVersionID,
        ?array $betas = null
    ): self {
        $self = new self;

        $self['servedVersionID'] = $servedVersionID;

        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Serve this version of the Plugin (prefixed `pluginver_`) and pin the served version to it; `latest` is not accepted.
     */
    public function withServedVersionID(string $servedVersionID): self
    {
        $self = clone $this;
        $self['servedVersionID'] = $servedVersionID;

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
