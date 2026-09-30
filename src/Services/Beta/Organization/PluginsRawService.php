<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\Plugins\DeletedPlugin;
use Anthropic\Beta\Organization\Plugins\Plugin;
use Anthropic\Beta\Organization\Plugins\PluginCreateParams;
use Anthropic\Beta\Organization\Plugins\PluginDeleteParams;
use Anthropic\Beta\Organization\Plugins\PluginListParams;
use Anthropic\Beta\Organization\Plugins\PluginListParams\OwnerType;
use Anthropic\Beta\Organization\Plugins\PluginRetrieveParams;
use Anthropic\Beta\Organization\Plugins\PluginUpdateParams;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\FileParam;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\PluginsRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class PluginsRawService implements PluginsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create an organization-owned Plugin and its first version by uploading the
     * version's files.
     *
     * The upload is `multipart/form-data`: the version's files (`files`, each part sent
     * as `files[]`), with an optional `marketplace_id` and `release_notes`. The manifest's `name` becomes the
     * Plugin's `name`, and `display_name`, `description` and `manifest_version` come
     * from the manifest too.
     *
     * `name` may contain lowercase letters (from any alphabet), digits, and hyphens, up
     * to 64 characters. Uppercase letters, spaces, underscores, and other punctuation are
     * rejected.
     *
     * The `name` must be unique within the marketplace: a name already taken
     * returns a 409 with `error_code` `plugin_name_taken` and, when a Plugin holds it,
     * that Plugin's ID in `details.plugin_id`. A Plugin going into the organization's
     * library marketplace is also refused with a 409 when one of its skills has the name of
     * an organization skill (a skill an administrator uploaded for the whole organization
     * in claude.ai): `error_code` `skill_name_taken`, with that name in
     * `details.skill_name`; rename the skill, or remove the organization skill in
     * claude.ai. A 503 with `error_code`
     * `registration_pending` means the Plugin and its version were stored (their IDs are
     * in `details`) but are not yet usable in claude.ai: do not retry the create (the
     * retry would return `plugin_name_taken`); create a version on the stored Plugin
     * instead, which completes it.
     *
     * For a worked example, see [Create a plugin](/docs/en/manage-claude/plugins-api#create-a-plugin)
     * in the Plugins API guide.
     *
     * **Accepted credentials:** an Admin API key with the `write:plugins` scope.
     *
     * Every request must include the beta header `anthropic-beta: ce-plugins-2026-09-01`. A request without it returns `404`, exactly as if the endpoint did not exist. The Plugins API is in beta and is available to Claude Enterprise organizations only. It is not available to Claude Platform (Claude Console) organizations, or to organizations with HIPAA readiness enabled.
     *
     * @param array{
     *   files: list<string|FileParam>,
     *   marketplaceID?: string,
     *   releaseNotes?: string,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|PluginCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Plugin>
     *
     * @throws APIException
     */
    public function create(
        array|PluginCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = PluginCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/organizations/plugins?beta=true',
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
            convert: Plugin::class,
        );
    }

    /**
     * @api
     *
     * Retrieve a Plugin by ID.
     *
     * **Accepted credentials:** an Admin API key with the `read:plugins` or `read:org_audit` scope, or a Compliance Access Key with the `read:compliance_org_data` scope.
     *
     * Every request must include the beta header `anthropic-beta: ce-plugins-2026-09-01`. A request without it returns `404`, exactly as if the endpoint did not exist. The Plugins API is in beta and is available to Claude Enterprise organizations only. It is not available to Claude Platform (Claude Console) organizations, or to organizations with HIPAA readiness enabled.
     *
     * @param string $pluginID path param: ID of the Plugin (prefixed `plugin_`)
     * @param array{
     *   organizationID?: string|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|PluginRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Plugin>
     *
     * @throws APIException
     */
    public function retrieve(
        string $pluginID,
        array|PluginRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = PluginRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(['organizationID']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/organizations/plugins/%1$s?beta=true', $pluginID],
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
            convert: Plugin::class,
        );
    }

    /**
     * @api
     *
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
     * @param string $pluginID path param: ID of the Plugin (prefixed `plugin_`)
     * @param array{
     *   servedVersionID: string,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|PluginUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Plugin>
     *
     * @throws APIException
     */
    public function update(
        string $pluginID,
        array|PluginUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = PluginUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/organizations/plugins/%1$s?beta=true', $pluginID],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
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
            convert: Plugin::class,
        );
    }

    /**
     * @api
     *
     * List the Plugins created under the organization, newest first: those in the
     * organization's own plugin marketplaces and those in members' personal plugin
     * marketplaces.
     *
     * Plugins in members' personal marketplaces are listed with the same detail as the
     * organization's own, and their files can be downloaded through the version archive
     * endpoint, which records each such download on the Compliance API activity feed.
     *
     * **Accepted credentials:** an Admin API key with the `read:plugins` or `read:org_audit` scope, or a Compliance Access Key with the `read:compliance_org_data` scope.
     *
     * Every request must include the beta header `anthropic-beta: ce-plugins-2026-09-01`. A request without it returns `404`, exactly as if the endpoint did not exist. The Plugins API is in beta and is available to Claude Enterprise organizations only. It is not available to Claude Platform (Claude Console) organizations, or to organizations with HIPAA readiness enabled.
     *
     * @param array{
     *   createdAtGt?: \DateTimeInterface|null,
     *   createdAtGte?: \DateTimeInterface|null,
     *   createdAtLt?: \DateTimeInterface|null,
     *   createdAtLte?: \DateTimeInterface|null,
     *   limit?: int,
     *   marketplaceID?: string|null,
     *   organizationID?: string|null,
     *   ownerType?: OwnerType|value-of<OwnerType>|null,
     *   ownerUserID?: string|null,
     *   page?: string|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|PluginListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<Plugin>>
     *
     * @throws APIException
     */
    public function list(
        array|PluginListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = PluginListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(
            [
                'createdAtGt',
                'createdAtGte',
                'createdAtLt',
                'createdAtLte',
                'limit',
                'marketplaceID',
                'organizationID',
                'ownerType',
                'ownerUserID',
                'page',
            ],
        );

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/organizations/plugins?beta=true',
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                [
                    'createdAtGt' => 'created_at[gt]',
                    'createdAtGte' => 'created_at[gte]',
                    'createdAtLt' => 'created_at[lt]',
                    'createdAtLte' => 'created_at[lte]',
                    'marketplaceID' => 'marketplace_id',
                    'organizationID' => 'organization_id',
                    'ownerType' => 'owner_type',
                    'ownerUserID' => 'owner_user_id',
                ],
            ),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'ce-plugins-2026-09-01']],
                $options,
            ),
            convert: Plugin::class,
            page: PageCursor::class,
        );
    }

    /**
     * @api
     *
     * Permanently delete a Plugin and every version it holds, exactly as when an
     * administrator deletes it in claude.ai. The Plugin may belong to the organization or
     * to a member, including a member who has since left the organization.
     *
     * An organization-owned Plugin's installation settings go with it; a member-owned
     * Plugin's shares are withdrawn and its owner no longer has it.
     *
     * To take an organization-owned Plugin out of use reversibly, set its
     * organization-wide installation setting to `not_available` instead (and
     * remove or change any group settings, which override it for their members). Only a
     * Plugin in a `manual` marketplace can be deleted here; one synchronized from a
     * repository is removed by removing it from the repository (400).
     *
     * **Accepted credentials:** an Admin API key with the `write:plugins` scope.
     *
     * Every request must include the beta header `anthropic-beta: ce-plugins-2026-09-01`. A request without it returns `404`, exactly as if the endpoint did not exist. The Plugins API is in beta and is available to Claude Enterprise organizations only. It is not available to Claude Platform (Claude Console) organizations, or to organizations with HIPAA readiness enabled.
     *
     * @param string $pluginID ID of the Plugin (prefixed `plugin_`)
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|PluginDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<DeletedPlugin>
     *
     * @throws APIException
     */
    public function delete(
        string $pluginID,
        array|PluginDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = PluginDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/organizations/plugins/%1$s?beta=true', $pluginID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'ce-plugins-2026-09-01']],
                $options,
            ),
            convert: DeletedPlugin::class,
        );
    }
}
