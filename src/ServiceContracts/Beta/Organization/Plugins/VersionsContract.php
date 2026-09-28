<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\Plugins;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\Plugins\Versions\BetaPluginVersion;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\FileParam;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface VersionsContract
{
    /**
     * @api
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
    ): BetaPluginVersion;

    /**
     * @api
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
    ): BetaPluginVersion;

    /**
     * @api
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
    ): PageCursor;

    /**
     * @api
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
    ): string;
}
