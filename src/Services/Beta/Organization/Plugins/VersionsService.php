<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\Plugins;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\Plugins\Versions\BetaPluginVersion;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\FileParam;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\Plugins\VersionsContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class VersionsService implements VersionsContract
{
    /**
     * @api
     */
    public VersionsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new VersionsRawService($client);
    }

    /**
     * @api
     *
     * Add a version to an organization-owned Plugin by uploading the new version's
     * files; it becomes the version served to members unless the Plugin's served version
     * has been pinned.
     *
     * The upload is the same `multipart/form-data` as creating a Plugin: the version's
     * files (`files`, each part sent as `files[]`) and optional `release_notes`. The uploaded manifest's `name`
     * must equal the Plugin's `name`. Returns the stored version; read the Plugin back to
     * see which version it serves.
     *
     * Only a Plugin in a `manual` marketplace takes uploads; a Plugin synchronized from
     * a repository gets its versions from the repository. When the Plugin is in the
     * organization's library marketplace, a version that adds a skill with the name of an
     * organization skill (a skill an administrator uploaded for the whole organization in
     * claude.ai) is refused with a 409: `error_code` `skill_name_taken`, with that name in
     * `details.skill_name`. A 503 with `error_code`
     * `registration_pending` means the version was stored but is not yet usable; a later
     * version create on the Plugin completes it.
     *
     * For a worked example, see [Create a version](/docs/en/manage-claude/plugins-api#create-a-version)
     * in the Plugins API guide.
     *
     * **Accepted credentials:** an Admin API key with the `write:plugins` scope.
     *
     * Every request must include the beta header `anthropic-beta: ce-plugins-2026-09-01`. A request without it returns `404`, exactly as if the endpoint did not exist. The Plugins API is in beta and is available to Claude Enterprise organizations only. It is not available to Claude Platform (Claude Console) organizations, or to organizations with HIPAA readiness enabled.
     *
     * @param string $pluginID path param: ID of the Plugin (prefixed `plugin_`)
     * @param list<string|FileParam> $files Body param: The version's files: one part per file, the part's filename being the file's path within the Plugin (for example `skills/review-pr/SKILL.md`), or a single `.zip` or `.plugin` archive holding them all. On the wire each part is named `files[]`, and a part named plain `files` is not read; with cURL, `-F 'files[]=@SKILL.md;filename=skills/review-pr/SKILL.md'`. The files must include the manifest, `.claude-plugin/plugin.json`.
     * @param string $releaseNotes Body param: Release notes stored with the version and shown in its version history in claude.ai; up to 5,000 characters.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `ce-plugins-2026-09-01` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $pluginID,
        array $files,
        ?string $releaseNotes = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaPluginVersion {
        $params = Util::removeNulls(
            ['files' => $files, 'releaseNotes' => $releaseNotes, 'betas' => $betas]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create($pluginID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Retrieve one version of a Plugin by its ID, or the Plugin's newest version.
     *
     * **Accepted credentials:** an Admin API key with the `read:plugins` or `read:org_audit` scope, or a Compliance Access Key with the `read:compliance_org_data` scope.
     *
     * Every request must include the beta header `anthropic-beta: ce-plugins-2026-09-01`. A request without it returns `404`, exactly as if the endpoint did not exist. The Plugins API is in beta and is available to Claude Enterprise organizations only. It is not available to Claude Platform (Claude Console) organizations, or to organizations with HIPAA readiness enabled.
     *
     * @param string $version path param: ID of the Plugin Version (prefixed `pluginver_`), or `latest` for the newest one
     * @param string $pluginID path param: ID of the Plugin (prefixed `plugin_`)
     * @param string|null $organizationID Query param: For a `read:org_audit` or `read:compliance_org_data` key created for all of a parent organization's linked organizations: a child organization of that parent to read instead of the organization the key was created in, given as the organization's UUID or its `org_`-prefixed ID. A value that is neither returns a 400; an organization that is not a child of the key's parent, or where the Plugins API is not available, returns a 404. Any other key may pass only its own organization's ID here; another organization returns a 404.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `ce-plugins-2026-09-01` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $version,
        string $pluginID,
        ?string $organizationID = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaPluginVersion {
        $params = Util::removeNulls(
            [
                'pluginID' => $pluginID,
                'organizationID' => $organizationID,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($version, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List a Plugin's versions, newest first.
     *
     * The first item of the first page is the version the Plugin's `latest_version_id`
     * refers to.
     *
     * **Accepted credentials:** an Admin API key with the `read:plugins` or `read:org_audit` scope, or a Compliance Access Key with the `read:compliance_org_data` scope.
     *
     * Every request must include the beta header `anthropic-beta: ce-plugins-2026-09-01`. A request without it returns `404`, exactly as if the endpoint did not exist. The Plugins API is in beta and is available to Claude Enterprise organizations only. It is not available to Claude Platform (Claude Console) organizations, or to organizations with HIPAA readiness enabled.
     *
     * @param string $pluginID path param: ID of the Plugin (prefixed `plugin_`)
     * @param int $limit Query param: Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     * @param string|null $organizationID Query param: For a `read:org_audit` or `read:compliance_org_data` key created for all of a parent organization's linked organizations: a child organization of that parent to read instead of the organization the key was created in, given as the organization's UUID or its `org_`-prefixed ID. A value that is neither returns a 400; an organization that is not a child of the key's parent, or where the Plugins API is not available, returns a 404. Any other key may pass only its own organization's ID here; another organization returns a 404.
     * @param string|null $page query param: Optionally set to the `next_page` token from the previous response
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `ce-plugins-2026-09-01` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<BetaPluginVersion>
     *
     * @throws APIException
     */
    public function list(
        string $pluginID,
        ?int $limit = null,
        ?string $organizationID = null,
        ?string $page = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor {
        $params = Util::removeNulls(
            [
                'limit' => $limit,
                'organizationID' => $organizationID,
                'page' => $page,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list($pluginID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
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
     * @param string $version Path param: ID of the Plugin Version (prefixed `pluginver_`). `latest` is not accepted here.
     * @param string $pluginID path param: ID of the Plugin (prefixed `plugin_`)
     * @param string|null $organizationID Query param: For a `read:org_audit` or `read:compliance_org_data` key created for all of a parent organization's linked organizations: a child organization of that parent to read instead of the organization the key was created in, given as the organization's UUID or its `org_`-prefixed ID. A value that is neither returns a 400; an organization that is not a child of the key's parent, or where the Plugins API is not available, returns a 404. Any other key may pass only its own organization's ID here; another organization returns a 404.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `ce-plugins-2026-09-01` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function download(
        string $version,
        string $pluginID,
        ?string $organizationID = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): string {
        $params = Util::removeNulls(
            [
                'pluginID' => $pluginID,
                'organizationID' => $organizationID,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->download($version, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
