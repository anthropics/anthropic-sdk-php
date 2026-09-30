<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\Plugins;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\Plugins\InstallationSettings\BetaDeletedPluginInstallationSetting;
use Anthropic\Beta\Organization\Plugins\InstallationSettings\BetaPluginInstallationSetting;
use Anthropic\Beta\Organization\Plugins\InstallationSettings\InstallationSettingListParams;
use Anthropic\Beta\Organization\Plugins\InstallationSettings\InstallationSettingListParams\TargetType;
use Anthropic\Beta\Organization\Plugins\InstallationSettings\InstallationSettingRemoveParams;
use Anthropic\Beta\Organization\Plugins\InstallationSettings\InstallationSettingSetParams;
use Anthropic\Beta\Organization\Plugins\InstallationSettings\InstallationSettingSetParams\InstallationPreference;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\Plugins\InstallationSettingsRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class InstallationSettingsRawService implements InstallationSettingsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * List an organization-owned Plugin's installation settings, which say which
     * members it is for, most recently created first.
     *
     * The list holds the Plugin's own organization-wide setting (absent while the Plugin
     * inherits its marketplace's default) and each RBAC Group's own setting. A
     * member-owned Plugin has shares instead, so this path returns 404 for one.
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
     *   targetType?: TargetType|value-of<TargetType>|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|InstallationSettingListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaPluginInstallationSetting>>
     *
     * @throws APIException
     */
    public function list(
        string $pluginID,
        array|InstallationSettingListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = InstallationSettingListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(
            ['limit', 'organizationID', 'page', 'targetType']
        );

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: [
                'v1/organizations/plugins/%1$s/installation_settings?beta=true',
                $pluginID,
            ],
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                ['organizationID' => 'organization_id', 'targetType' => 'target_type'],
            ),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'ce-plugins-2026-09-01']],
                $options,
            ),
            convert: BetaPluginInstallationSetting::class,
            page: PageCursor::class,
        );
    }

    /**
     * @api
     *
     * Remove an organization-owned Plugin's own installation setting for the whole
     * organization or for one RBAC Group.
     *
     * Removing the `organization` target returns the Plugin to its marketplace's default
     * installation setting and leaves the groups' settings in place. Removing a group's
     * setting makes the group's members fall back to the Plugin's organization-wide setting
     * or to the settings of their other groups.
     *
     * A target that holds no setting of its own returns 404 (a Plugin that already inherits
     * its marketplace's default holds no `organization` setting), and so does a member-owned
     * Plugin.
     *
     * A removal counts as one of the Plugin's installation-setting writes: send all of those
     * writes one at a time. If several arrive for the same Plugin at the same time, the server
     * handles them one after another and can answer some of them with `503` and
     * `x-should-retry: true` instead of applying them; wait a second or two and send the
     * removal again. A `404` on the repeat means the setting is already gone.
     *
     * **Accepted credentials:** an Admin API key with the `write:plugins` scope.
     *
     * Every request must include the beta header `anthropic-beta: ce-plugins-2026-09-01`. A request without it returns `404`, exactly as if the endpoint did not exist. The Plugins API is in beta and is available to Claude Enterprise organizations only. It is not available to Claude Platform (Claude Console) organizations, or to organizations with HIPAA readiness enabled.
     *
     * @param string $target Path param: The target whose own setting is removed: the literal `organization` for the Plugin's organization-wide setting, or an RBAC Group's ID (prefixed `rbac_group_`) for that group's own setting. Removing the `organization` setting returns the Plugin to its marketplace's default.
     * @param array{
     *   pluginID: string, betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|InstallationSettingRemoveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaDeletedPluginInstallationSetting>
     *
     * @throws APIException
     */
    public function remove(
        string $target,
        array|InstallationSettingRemoveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = InstallationSettingRemoveParams::parseRequest(
            $params,
            $requestOptions,
        );
        $pluginID = $parsed['pluginID'];
        unset($parsed['pluginID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: [
                'v1/organizations/plugins/%1$s/installation_settings/%2$s?beta=true',
                $pluginID,
                $target,
            ],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'ce-plugins-2026-09-01']],
                $options,
            ),
            convert: BetaDeletedPluginInstallationSetting::class,
        );
    }

    /**
     * @api
     *
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
     * @param string $target Path param: The target whose setting is written: the literal `organization` for the Plugin's organization-wide setting, or an RBAC Group's ID (prefixed `rbac_group_`) for that group's own setting. Writing the `organization` target stops the Plugin from inheriting its marketplace's default, even when the value written equals that default.
     * @param array{
     *   pluginID: string,
     *   installationPreference: InstallationPreference|value-of<InstallationPreference>,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|InstallationSettingSetParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaPluginInstallationSetting>
     *
     * @throws APIException
     */
    public function set(
        string $target,
        array|InstallationSettingSetParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = InstallationSettingSetParams::parseRequest(
            $params,
            $requestOptions,
        );
        $pluginID = $parsed['pluginID'];
        unset($parsed['pluginID']);
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/organizations/plugins/%1$s/installation_settings/%2$s?beta=true',
                $pluginID,
                $target,
            ],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                array_diff_key($parsed, array_flip(array_keys($header_params))),
                array_flip(['pluginID']),
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'ce-plugins-2026-09-01']],
                $options,
            ),
            convert: BetaPluginInstallationSetting::class,
        );
    }
}
