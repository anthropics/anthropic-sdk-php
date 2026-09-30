<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\Plugins\DeletedPlugin;
use Anthropic\Beta\Organization\Plugins\Plugin;
use Anthropic\Beta\Organization\Plugins\PluginListParams\OwnerType;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\FileParam;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface PluginsContract
{
    /**
     * @api
     *
     * @param list<string|FileParam> $files Body param: The version's files: one part per file, the part's filename being the file's path within the Plugin (for example `skills/review-pr/SKILL.md`), or a single `.zip` or `.plugin` archive holding them all. On the wire each part is named `files[]`, and a part named plain `files` is not read; with cURL, `-F 'files[]=@SKILL.md;filename=skills/review-pr/SKILL.md'`. The files must include the manifest, `.claude-plugin/plugin.json`.
     * @param string $marketplaceID Body param: ID of the organization-owned plugin marketplace to create the Plugin in (prefixed `marketplace_`). It must be a `manual` marketplace, one whose Plugins are uploaded rather than synchronized from a repository. When omitted, the Plugin is created in the organization's library marketplace, an organization-owned `manual` marketplace created on first use.
     * @param string $releaseNotes Body param: Release notes stored with the version and shown in its version history in claude.ai; up to 5,000 characters.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `ce-plugins-2026-09-01` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        array $files,
        ?string $marketplaceID = null,
        ?string $releaseNotes = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): Plugin;

    /**
     * @api
     *
     * @param string $pluginID path param: ID of the Plugin (prefixed `plugin_`)
     * @param string|null $organizationID Query param: For a `read:org_audit` or `read:compliance_org_data` key created for all of a parent organization's linked organizations: a child organization of that parent to read instead of the organization the key was created in, given as the organization's UUID or its `org_`-prefixed ID. A value that is neither returns a 400; an organization that is not a child of the key's parent, or where the Plugins API is not available, returns a 404. Any other key may pass only its own organization's ID here; another organization returns a 404.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `ce-plugins-2026-09-01` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $pluginID,
        ?string $organizationID = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): Plugin;

    /**
     * @api
     *
     * @param string $pluginID path param: ID of the Plugin (prefixed `plugin_`)
     * @param string $servedVersionID body param: Serve this version of the Plugin (prefixed `pluginver_`) and pin the served version to it; `latest` is not accepted
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `ce-plugins-2026-09-01` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $pluginID,
        string $servedVersionID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): Plugin;

    /**
     * @api
     *
     * @param \DateTimeInterface|null $createdAtGt query param: RFC 3339 timestamp bound; combine [gte], [gt], [lte], [lt]
     * @param \DateTimeInterface|null $createdAtGte query param: RFC 3339 timestamp bound; combine [gte], [gt], [lte], [lt]
     * @param \DateTimeInterface|null $createdAtLt query param: RFC 3339 timestamp bound; combine [gte], [gt], [lte], [lt]
     * @param \DateTimeInterface|null $createdAtLte query param: RFC 3339 timestamp bound; combine [gte], [gt], [lte], [lt]
     * @param int $limit Query param: Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `100`.
     * @param string|null $marketplaceID query param: Only Plugins in this plugin marketplace (prefixed `marketplace_`)
     * @param string|null $organizationID Query param: For a `read:org_audit` or `read:compliance_org_data` key created for all of a parent organization's linked organizations: a child organization of that parent to read instead of the organization the key was created in, given as the organization's UUID or its `org_`-prefixed ID. A value that is neither returns a 400; an organization that is not a child of the key's parent, or where the Plugins API is not available, returns a 404. Any other key may pass only its own organization's ID here; another organization returns a 404.
     * @param OwnerType|value-of<OwnerType>|null $ownerType query param: `organization` for Plugins in the organization's plugin marketplaces, `user` for Plugins in members' personal plugin marketplaces
     * @param string|null $ownerUserID query param: Only Plugins in this member's personal plugin marketplaces (prefixed `user_`); a removed member's ID is accepted
     * @param string|null $page query param: Optionally set to the `next_page` token from the previous response
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `ce-plugins-2026-09-01` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<Plugin>
     *
     * @throws APIException
     */
    public function list(
        ?\DateTimeInterface $createdAtGt = null,
        ?\DateTimeInterface $createdAtGte = null,
        ?\DateTimeInterface $createdAtLt = null,
        ?\DateTimeInterface $createdAtLte = null,
        ?int $limit = null,
        ?string $marketplaceID = null,
        ?string $organizationID = null,
        OwnerType|string|null $ownerType = null,
        ?string $ownerUserID = null,
        ?string $page = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;

    /**
     * @api
     *
     * @param string $pluginID ID of the Plugin (prefixed `plugin_`)
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas this endpoint is in beta: requests must send `ce-plugins-2026-09-01` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $pluginID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): DeletedPlugin;
}
