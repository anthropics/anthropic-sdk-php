<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplace;
use Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplaceListParams\OwnerType;
use Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplaceListParams\Source;
use Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplaceUpdateParams\DefaultInstallationPreference;
use Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplaceValidationReport;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\FileParam;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\PluginMarketplacesContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class PluginMarketplacesService implements PluginMarketplacesContract
{
    /**
     * @api
     */
    public PluginMarketplacesRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new PluginMarketplacesRawService($client);
    }

    /**
     * @api
     *
     * Retrieve a plugin marketplace by ID.
     *
     * **Accepted credentials:** an Admin API key with the `read:plugins` or `read:org_audit` scope, or a Compliance Access Key with the `read:compliance_org_data` scope.
     *
     * Every request must include the beta header `anthropic-beta: ce-plugins-2026-09-01`. A request without it returns `404`, exactly as if the endpoint did not exist. The Plugins API is in beta and is available to Claude Enterprise organizations only. It is not available to Claude Platform (Claude Console) organizations, or to organizations with HIPAA readiness enabled.
     *
     * @param string $marketplaceID path param: ID of the plugin marketplace (prefixed `marketplace_`)
     * @param string|null $organizationID Query param: For a `read:org_audit` or `read:compliance_org_data` key created for all of a parent organization's linked organizations: a child organization of that parent to read instead of the organization the key was created in, given as the organization's UUID or its `org_`-prefixed ID. A value that is neither returns a 400; an organization that is not a child of the key's parent, or where the Plugins API is not available, returns a 404. Any other key may pass only its own organization's ID here; another organization returns a 404.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `ce-plugins-2026-09-01` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $marketplaceID,
        ?string $organizationID = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PluginMarketplace {
        $params = Util::removeNulls(
            ['organizationID' => $organizationID, 'betas' => $betas]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($marketplaceID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Set the default installation setting of one of the organization's own plugin
     * marketplaces. Every Plugin in it without a setting of its own gets this default as
     * its organization-wide setting, including Plugins added later.
     *
     * Pass it as `default_installation_preference`. A member's personal marketplace
     * cannot be updated here (403).
     *
     * **Accepted credentials:** an Admin API key with the `write:plugins` scope.
     *
     * Every request must include the beta header `anthropic-beta: ce-plugins-2026-09-01`. A request without it returns `404`, exactly as if the endpoint did not exist. The Plugins API is in beta and is available to Claude Enterprise organizations only. It is not available to Claude Platform (Claude Console) organizations, or to organizations with HIPAA readiness enabled.
     *
     * @param string $marketplaceID path param: ID of the plugin marketplace (prefixed `marketplace_`)
     * @param DefaultInstallationPreference|value-of<DefaultInstallationPreference> $defaultInstallationPreference Body param: The organization-wide installation setting every Plugin in the marketplace without one of its own gets: one of `required`, `auto_install`, `available`, `not_available`. Once set it can be changed but not removed.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `ce-plugins-2026-09-01` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $marketplaceID,
        DefaultInstallationPreference|string $defaultInstallationPreference,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PluginMarketplace {
        $params = Util::removeNulls(
            [
                'defaultInstallationPreference' => $defaultInstallationPreference,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($marketplaceID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List the plugin marketplaces Plugins live in, newest first: the organization's own
     * and its members' personal ones.
     *
     * Plugin marketplaces are created, connected to a repository and deleted in
     * claude.ai, not through this API. The organization's library marketplace, the
     * organization-owned `manual` marketplace that uploads go to when no marketplace is
     * named, is created the first time something is put in it and is listed from then on.
     *
     * **Accepted credentials:** an Admin API key with the `read:plugins` or `read:org_audit` scope, or a Compliance Access Key with the `read:compliance_org_data` scope.
     *
     * Every request must include the beta header `anthropic-beta: ce-plugins-2026-09-01`. A request without it returns `404`, exactly as if the endpoint did not exist. The Plugins API is in beta and is available to Claude Enterprise organizations only. It is not available to Claude Platform (Claude Console) organizations, or to organizations with HIPAA readiness enabled.
     *
     * @param int $limit Query param: Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     * @param string|null $organizationID Query param: For a `read:org_audit` or `read:compliance_org_data` key created for all of a parent organization's linked organizations: a child organization of that parent to read instead of the organization the key was created in, given as the organization's UUID or its `org_`-prefixed ID. A value that is neither returns a 400; an organization that is not a child of the key's parent, or where the Plugins API is not available, returns a 404. Any other key may pass only its own organization's ID here; another organization returns a 404.
     * @param OwnerType|value-of<OwnerType>|null $ownerType query param: `organization` for the organization's plugin marketplaces, `user` for members' personal plugin marketplaces
     * @param string|null $page query param: Optionally set to the `next_page` token from the previous response
     * @param Source|value-of<Source>|null $source Query param: Only plugin marketplaces with this `source`: `manual` for those whose Plugins are uploaded; `github`, `gitlab` or `public_git` for those synchronized from a Git repository. `directory` (Anthropic's catalog) is never listed here.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `ce-plugins-2026-09-01` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<PluginMarketplace>
     *
     * @throws APIException
     */
    public function list(
        ?int $limit = null,
        ?string $organizationID = null,
        OwnerType|string|null $ownerType = null,
        ?string $page = null,
        Source|string|null $source = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor {
        $params = Util::removeNulls(
            [
                'limit' => $limit,
                'organizationID' => $organizationID,
                'ownerType' => $ownerType,
                'page' => $page,
                'source' => $source,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Check whether a plugin marketplace, uploaded as a `.zip` of the marketplace
     * directory, would synchronize into claude.ai, without connecting or storing it.
     *
     * To check a public GitHub repository instead, use Validate Plugin Marketplace Repository.
     *
     * The report says whether `marketplace.json` is well-formed, which plugins a
     * synchronization would skip and why, and which plugins would synchronize only in
     * part, with some files left out. An archive that cannot be read as a marketplace is reported, not refused: the response is a report with `valid: false`. Plugin sources outside the marketplace
     * are fetched anonymously from GitHub, so a private one is reported as not found; a
     * source on any other host is not fetched here, and the report notes that it will be
     * checked when the marketplace actually synchronizes.
     *
     * Nothing is recorded on the Compliance API activity feed.
     *
     * For a worked example, see [Validate marketplace content](/docs/en/manage-claude/plugins-api#validate-marketplace-content)
     * in the Plugins API guide.
     *
     * **Accepted credentials:** an Admin API key with the `read:plugins` or `write:plugins` scope; `read:org_audit` and `read:compliance_org_data` do not grant it.
     *
     * Every request must include the beta header `anthropic-beta: ce-plugins-2026-09-01`. A request without it returns `404`, exactly as if the endpoint did not exist. The Plugins API is in beta and is available to Claude Enterprise organizations only. It is not available to Claude Platform (Claude Console) organizations, or to organizations with HIPAA readiness enabled.
     *
     * @param string|FileParam $archive Body param: A .zip of the marketplace directory (its contents at the root, or wrapped in one folder as a Git host's download produces), sent as a file part with a filename; DEFLATE- or STORE-compressed, at most 32 MB. A part sent without a filename, a second archive part, or any other form field is a 400; a larger archive is a 413.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `ce-plugins-2026-09-01` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function validateArchive(
        string|FileParam $archive,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PluginMarketplaceValidationReport {
        $params = Util::removeNulls(['archive' => $archive, 'betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->validateArchive(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Check whether a plugin marketplace held in a public GitHub repository would
     * synchronize into claude.ai, without connecting or storing it.
     *
     * To check a `.zip` of the marketplace directory instead, use Validate Plugin Marketplace Archive.
     *
     * The report says whether `marketplace.json` is well-formed, which plugins a
     * synchronization would skip and why, and which plugins would synchronize only in
     * part, with some files left out. A repository that is missing, private, or has no such branch or commit is reported, not refused: the response is a report with `valid: false`. Plugin sources outside the marketplace
     * are fetched anonymously from GitHub, so a private one is reported as not found; a
     * source on any other host is not fetched here, and the report notes that it will be
     * checked when the marketplace actually synchronizes.
     *
     * Nothing is recorded on the Compliance API activity feed.
     *
     * For a worked example, see [Validate marketplace content](/docs/en/manage-claude/plugins-api#validate-marketplace-content)
     * in the Plugins API guide.
     *
     * **Accepted credentials:** an Admin API key with the `read:plugins` or `write:plugins` scope; `read:org_audit` and `read:compliance_org_data` do not grant it.
     *
     * Every request must include the beta header `anthropic-beta: ce-plugins-2026-09-01`. A request without it returns `404`, exactly as if the endpoint did not exist. The Plugins API is in beta and is available to Claude Enterprise organizations only. It is not available to Claude Platform (Claude Console) organizations, or to organizations with HIPAA readiness enabled.
     *
     * @param string $repositoryURL Body param: The `https://` URL of a public repository on github.com that holds the marketplace. Any other host, a URL with credentials in it, or one that does not name a repository is a 400.
     * @param string|null $ref Body param: The branch to validate the tip of, or the full 40-character SHA of the commit to validate. When omitted, the branch a synchronization would read (usually the repository's default branch); if that is not the default branch, the report's `ref` says which branch was read. An empty string, or a value that is neither a branch name nor a 40-character SHA, is a 400.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `ce-plugins-2026-09-01` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function validateRepository(
        string $repositoryURL,
        ?string $ref = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PluginMarketplaceValidationReport {
        $params = Util::removeNulls(
            ['repositoryURL' => $repositoryURL, 'ref' => $ref, 'betas' => $betas]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->validateRepository(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
