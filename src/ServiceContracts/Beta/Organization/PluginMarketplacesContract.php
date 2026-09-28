<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplace;
use Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplaceListParams\OwnerType;
use Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplaceListParams\Source;
use Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplaceUpdateParams\DefaultInstallationPreference;
use Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplaceValidationReport;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\FileParam;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface PluginMarketplacesContract
{
    /**
     * @api
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
    ): PluginMarketplace;

    /**
     * @api
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
    ): PluginMarketplace;

    /**
     * @api
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
    ): PageCursor;

    /**
     * @api
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
    ): PluginMarketplaceValidationReport;

    /**
     * @api
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
    ): PluginMarketplaceValidationReport;
}
