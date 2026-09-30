<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\Plugins;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\Plugins\InstallationSettings\BetaDeletedPluginInstallationSetting;
use Anthropic\Beta\Organization\Plugins\InstallationSettings\BetaPluginInstallationSetting;
use Anthropic\Beta\Organization\Plugins\InstallationSettings\InstallationSettingListParams\TargetType;
use Anthropic\Beta\Organization\Plugins\InstallationSettings\InstallationSettingSetParams\InstallationPreference;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface InstallationSettingsContract
{
    /**
     * @api
     *
     * @param string $pluginID path param: ID of the Plugin (prefixed `plugin_`)
     * @param int $limit Query param: Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `100`.
     * @param string|null $organizationID Query param: For a `read:org_audit` or `read:compliance_org_data` key created for all of a parent organization's linked organizations: a child organization of that parent to read instead of the organization the key was created in, given as the organization's UUID or its `org_`-prefixed ID. A value that is neither returns a 400; an organization that is not a child of the key's parent, or where the Plugins API is not available, returns a 404. Any other key may pass only its own organization's ID here; another organization returns a 404.
     * @param string|null $page query param: Optionally set to the `next_page` token from the previous response
     * @param TargetType|value-of<TargetType>|null $targetType query param: Only settings for this kind of target: `organization` (the organization-wide setting) or `rbac_group` (an RBAC Group's)
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `ce-plugins-2026-09-01` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<BetaPluginInstallationSetting>
     *
     * @throws APIException
     */
    public function list(
        string $pluginID,
        ?int $limit = null,
        ?string $organizationID = null,
        ?string $page = null,
        TargetType|string|null $targetType = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;

    /**
     * @api
     *
     * @param string $target Path param: The target whose own setting is removed: the literal `organization` for the Plugin's organization-wide setting, or an RBAC Group's ID (prefixed `rbac_group_`) for that group's own setting. Removing the `organization` setting returns the Plugin to its marketplace's default.
     * @param string $pluginID path param: ID of the Plugin (prefixed `plugin_`)
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `ce-plugins-2026-09-01` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function remove(
        string $target,
        string $pluginID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaDeletedPluginInstallationSetting;

    /**
     * @api
     *
     * @param string $target Path param: The target whose setting is written: the literal `organization` for the Plugin's organization-wide setting, or an RBAC Group's ID (prefixed `rbac_group_`) for that group's own setting. Writing the `organization` target stops the Plugin from inheriting its marketplace's default, even when the value written equals that default.
     * @param string $pluginID path param: ID of the Plugin (prefixed `plugin_`)
     * @param InstallationPreference|value-of<InstallationPreference> $installationPreference body param: The installation setting the target is to hold for this Plugin: one of `required`, `auto_install`, `available`, `not_available`
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `ce-plugins-2026-09-01` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function set(
        string $target,
        string $pluginID,
        InstallationPreference|string $installationPreference,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaPluginInstallationSetting;
}
