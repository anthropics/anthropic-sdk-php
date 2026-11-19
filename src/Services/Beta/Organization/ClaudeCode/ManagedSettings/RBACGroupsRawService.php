<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\ClaudeCode\ManagedSettings;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\BetaRequestBodyTimeoutException;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\BetaCMEKFeatureUnsupportedException;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\BetaRBACGroupManagedSettingsNotFoundException;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\BetaRBACGroupOrderLimitExceededException;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\BetaSettingsDocumentLimitExceededException;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\BetaSettingsHistoryLimitExceededException;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroups\BetaClaudeCodeRBACGroupManagedSettings;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroups\BetaClaudeCodeRBACGroupManagedSettingsSummary;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroups\BetaDeletedClaudeCodeRBACGroupManagedSettings;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroups\RBACGroupDeleteParams;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroups\RBACGroupListParams;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroups\RBACGroupRetrieveParams;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroups\RBACGroupSetParams;
use Anthropic\Beta\Organization\RBACGroups\RBACGroupNotFoundException;
use Anthropic\Client;
use Anthropic\CMEKKeyDisabledException;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Implementation\ApiCallInfo;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\SandboxEgressRestrictedException;
use Anthropic\ServiceContracts\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroupsRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class RBACGroupsRawService implements RBACGroupsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Retrieve an RBAC Group's Claude Code managed settings.
     *
     * **Accepted credentials:** an organization-level Admin API key with the `read:claude_code_managed_settings` scope.
     *
     * Every request must include the beta header `anthropic-beta: ce-claude-code-managed-settings-2026-10-06`. A request without it, or from an organization not enabled for this beta, returns `404`. The Claude Code Managed Settings API is in beta and is available to Claude Enterprise organizations only.
     *
     * @param string $rbacGroupID The RBAC Group's ID, prefixed `rbac_group_`.
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|RBACGroupRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaClaudeCodeRBACGroupManagedSettings>
     *
     * @throws BetaCMEKFeatureUnsupportedException
     * @throws CMEKKeyDisabledException
     * @throws BetaRBACGroupManagedSettingsNotFoundException
     * @throws APIException
     */
    public function retrieve(
        string $rbacGroupID,
        array|RBACGroupRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = RBACGroupRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: [
                'v1/organizations/claude_code/managed_settings/rbac_groups/%1$s',
                $rbacGroupID,
            ],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                [
                    'extraHeaders' => [
                        'anthropic-beta' => 'ce-claude-code-managed-settings-2026-10-06',
                    ],
                ],
                $options,
            )->withQualifiers(['beta' => 'true'])->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.claude_code.managed_settings.rbac_groups.retrieve',
                route: '/v1/organizations/claude_code/managed_settings/rbac_groups/{rbac_group_id}',
                attributes: [
                    'anthropic.organization.claude_code.managed_setting.rbac_group.id' => $rbacGroupID,
                ],
            )),
            convert: BetaClaudeCodeRBACGroupManagedSettings::class,
        );
    }

    /**
     * @api
     *
     * List the RBAC Groups that have Claude Code managed settings, highest precedence first.
     *
     * Each entry gives the group's status and timestamps, not its settings. The list includes deleted groups that still have settings, and leaves out the default settings. If the order changes between pages, the request returns `409`: list again from the first page.
     *
     * **Accepted credentials:** an organization-level Admin API key with the `read:claude_code_managed_settings` scope.
     *
     * Every request must include the beta header `anthropic-beta: ce-claude-code-managed-settings-2026-10-06`. A request without it, or from an organization not enabled for this beta, returns `404`. The Claude Code Managed Settings API is in beta and is available to Claude Enterprise organizations only.
     *
     * @param array{
     *   limit?: int,
     *   page?: string|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|RBACGroupListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaClaudeCodeRBACGroupManagedSettingsSummary>>
     *
     * @throws APIException
     */
    public function list(
        array|RBACGroupListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = RBACGroupListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(['limit', 'page']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/organizations/claude_code/managed_settings/rbac_groups',
            query: array_intersect_key($parsed, $query_params),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                [
                    'extraHeaders' => [
                        'anthropic-beta' => 'ce-claude-code-managed-settings-2026-10-06',
                    ],
                ],
                $options,
            )->withQualifiers(['beta' => 'true'])->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.claude_code.managed_settings.rbac_groups.list',
                route: '/v1/organizations/claude_code/managed_settings/rbac_groups',
                query: ['limit', 'page'],
            )),
            convert: BetaClaudeCodeRBACGroupManagedSettingsSummary::class,
            page: PageCursor::class,
        );
    }

    /**
     * @api
     *
     * Delete an RBAC Group's Claude Code managed settings and remove the group from `rbac_group_order`.
     *
     * A group with no settings returns `404` with the error code `rbac_group_managed_settings_not_found`. That code on a retry of a delete that returned `503` means the settings are gone.
     *
     * **Accepted credentials:** an organization-level Admin API key with the `write:claude_code_managed_settings` scope.
     *
     * Every request must include the beta header `anthropic-beta: ce-claude-code-managed-settings-2026-10-06`. A request without it, or from an organization not enabled for this beta, returns `404`. The Claude Code Managed Settings API is in beta and is available to Claude Enterprise organizations only.
     *
     * A write that returns `503` may have applied. Retrying it is safe.
     *
     * @param string $rbacGroupID The RBAC Group's ID, prefixed `rbac_group_`.
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|RBACGroupDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaDeletedClaudeCodeRBACGroupManagedSettings>
     *
     * @throws CMEKKeyDisabledException
     * @throws BetaSettingsHistoryLimitExceededException
     * @throws SandboxEgressRestrictedException
     * @throws BetaRBACGroupManagedSettingsNotFoundException
     * @throws APIException
     */
    public function delete(
        string $rbacGroupID,
        array|RBACGroupDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = RBACGroupDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: [
                'v1/organizations/claude_code/managed_settings/rbac_groups/%1$s',
                $rbacGroupID,
            ],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                [
                    'extraHeaders' => [
                        'anthropic-beta' => 'ce-claude-code-managed-settings-2026-10-06',
                    ],
                ],
                $options,
            )->withQualifiers(['beta' => 'true'])->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.claude_code.managed_settings.rbac_groups.delete',
                route: '/v1/organizations/claude_code/managed_settings/rbac_groups/{rbac_group_id}',
                attributes: [
                    'anthropic.organization.claude_code.managed_setting.rbac_group.id' => $rbacGroupID,
                ],
            )),
            convert: BetaDeletedClaudeCodeRBACGroupManagedSettings::class,
        );
    }

    /**
     * @api
     *
     * Create or replace an RBAC Group's Claude Code managed settings.
     *
     * New settings join the end of `rbac_group_order`, and existing settings keep their place. Until the group is moved up, its members who also belong to an earlier group keep that group's settings. In `organization` mode a write changes no member's settings until the organization switches to `rbac_groups` mode. Once a group has settings, that switch no longer copies the organization settings into default settings, so members in no RBAC Group in `rbac_group_order` receive no settings unless you set the default settings before the switch.
     *
     * Get the group's ID from the RBAC Groups API. One key can hold `read:rbac_groups` and `write:claude_code_managed_settings`.
     *
     * **Accepted credentials:** an organization-level Admin API key with the `write:claude_code_managed_settings` scope.
     *
     * Every request must include the beta header `anthropic-beta: ce-claude-code-managed-settings-2026-10-06`. A request without it, or from an organization not enabled for this beta, returns `404`. The Claude Code Managed Settings API is in beta and is available to Claude Enterprise organizations only.
     *
     * A write that returns `503` may have applied. Retrying it is safe.
     *
     * @param string $rbacGroupID Path param: The RBAC Group's ID, prefixed `rbac_group_`.
     * @param array{
     *   settings: array<string,mixed>,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|RBACGroupSetParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaClaudeCodeRBACGroupManagedSettings>
     *
     * @throws BetaCMEKFeatureUnsupportedException
     * @throws CMEKKeyDisabledException
     * @throws BetaRBACGroupOrderLimitExceededException
     * @throws BetaRequestBodyTimeoutException
     * @throws BetaSettingsDocumentLimitExceededException
     * @throws BetaSettingsHistoryLimitExceededException
     * @throws SandboxEgressRestrictedException
     * @throws RBACGroupNotFoundException
     * @throws APIException
     */
    public function set(
        string $rbacGroupID,
        array|RBACGroupSetParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = RBACGroupSetParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/organizations/claude_code/managed_settings/rbac_groups/%1$s',
                $rbacGroupID,
            ],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: RequestOptions::parse(
                [
                    'extraHeaders' => [
                        'anthropic-beta' => 'ce-claude-code-managed-settings-2026-10-06',
                    ],
                ],
                $options,
            )->withQualifiers(['beta' => 'true'])->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.claude_code.managed_settings.rbac_groups.set',
                route: '/v1/organizations/claude_code/managed_settings/rbac_groups/{rbac_group_id}',
                attributes: [
                    'anthropic.organization.claude_code.managed_setting.rbac_group.id' => $rbacGroupID,
                ],
            )),
            convert: BetaClaudeCodeRBACGroupManagedSettings::class,
        );
    }
}
