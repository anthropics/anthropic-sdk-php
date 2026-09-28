<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\Plugins;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\Plugins\Versions\BetaPluginVersion;
use Anthropic\Beta\Organization\Plugins\Versions\VersionCreateParams;
use Anthropic\Beta\Organization\Plugins\Versions\VersionDownloadParams;
use Anthropic\Beta\Organization\Plugins\Versions\VersionListParams;
use Anthropic\Beta\Organization\Plugins\Versions\VersionRetrieveParams;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\FileParam;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\Plugins\VersionsRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class VersionsRawService implements VersionsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

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
     * @param array{
     *   files: list<string|FileParam>,
     *   releaseNotes?: string,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|VersionCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaPluginVersion>
     *
     * @throws APIException
     */
    public function create(
        string $pluginID,
        array|VersionCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = VersionCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/organizations/plugins/%1$s/versions?beta=true', $pluginID],
            headers: Util::array_transform_keys(
                [
                    'Content-Type' => 'multipart/form-data',
                    ...array_intersect_key(
                        $parsed,
                        array_flip(array_keys($header_params))
                    ),
                ],
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'ce-plugins-2026-09-01']],
                $options,
            ),
            convert: BetaPluginVersion::class,
        );
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
     * @param array{
     *   pluginID: string,
     *   organizationID?: string|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|VersionRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaPluginVersion>
     *
     * @throws APIException
     */
    public function retrieve(
        string $version,
        array|VersionRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = VersionRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );
        $pluginID = $parsed['pluginID'];
        unset($parsed['pluginID']);
        $query_params = array_flip(['organizationID']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: [
                'v1/organizations/plugins/%1$s/versions/%2$s?beta=true',
                $pluginID,
                $version,
            ],
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                ['organizationID' => 'organization_id'],
            ),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'ce-plugins-2026-09-01']],
                $options,
            ),
            convert: BetaPluginVersion::class,
        );
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
     * @param array{
     *   limit?: int,
     *   organizationID?: string|null,
     *   page?: string|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|VersionListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaPluginVersion>>
     *
     * @throws APIException
     */
    public function list(
        string $pluginID,
        array|VersionListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = VersionListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(['limit', 'organizationID', 'page']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/organizations/plugins/%1$s/versions?beta=true', $pluginID],
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                ['organizationID' => 'organization_id'],
            ),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'ce-plugins-2026-09-01']],
                $options,
            ),
            convert: BetaPluginVersion::class,
            page: PageCursor::class,
        );
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
     * @param array{
     *   pluginID: string,
     *   organizationID?: string|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|VersionDownloadParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<string>
     *
     * @throws APIException
     */
    public function download(
        string $version,
        array|VersionDownloadParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = VersionDownloadParams::parseRequest(
            $params,
            $requestOptions,
        );
        $pluginID = $parsed['pluginID'];
        unset($parsed['pluginID']);
        $query_params = array_flip(['organizationID']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: [
                'v1/organizations/plugins/%1$s/versions/%2$s/content?beta=true',
                $pluginID,
                $version,
            ],
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                ['organizationID' => 'organization_id'],
            ),
            headers: Util::array_transform_keys(
                ['Accept' => 'application/binary', ...$header_params],
                ['betas' => 'anthropic-beta'],
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'ce-plugins-2026-09-01']],
                $options,
            ),
            convert: 'string',
        );
    }
}
