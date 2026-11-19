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
use Anthropic\Beta\Organization\RBACGroups\RBACGroupNotFoundException;
use Anthropic\Client;
use Anthropic\CMEKKeyDisabledException;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\SandboxEgressRestrictedException;
use Anthropic\ServiceContracts\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroupsContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class RBACGroupsService implements RBACGroupsContract
{
    /**
     * @api
     */
    public RBACGroupsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new RBACGroupsRawService($client);
    }

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
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas This endpoint is in beta: requests must send `ce-claude-code-managed-settings-2026-10-06` in this header.
     * @param RequestOpts|null $requestOptions
     *
     * @throws BetaCMEKFeatureUnsupportedException
     * @throws CMEKKeyDisabledException
     * @throws BetaRBACGroupManagedSettingsNotFoundException
     * @throws APIException
     */
    public function retrieve(
        string $rbacGroupID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaClaudeCodeRBACGroupManagedSettings {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($rbacGroupID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
     * @param int $limit Query param: Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `100`.
     * @param string|null $page Query param: Optionally set to the `next_page` token from the previous response.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas Header param: This endpoint is in beta: requests must send `ce-claude-code-managed-settings-2026-10-06` in this header.
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<BetaClaudeCodeRBACGroupManagedSettingsSummary>
     *
     * @throws APIException
     */
    public function list(
        ?int $limit = null,
        ?string $page = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor {
        $params = Util::removeNulls(
            ['limit' => $limit, 'page' => $page, 'betas' => $betas]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas This endpoint is in beta: requests must send `ce-claude-code-managed-settings-2026-10-06` in this header.
     * @param RequestOpts|null $requestOptions
     *
     * @throws CMEKKeyDisabledException
     * @throws BetaSettingsHistoryLimitExceededException
     * @throws SandboxEgressRestrictedException
     * @throws BetaRBACGroupManagedSettingsNotFoundException
     * @throws APIException
     */
    public function delete(
        string $rbacGroupID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaDeletedClaudeCodeRBACGroupManagedSettings {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($rbacGroupID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
     * @param array<string,mixed> $settings Body param: The whole settings document, a JSON object of Claude Code managed settings. It replaces any stored document. At most 1 MiB as the server stores it, which can be larger than the request body.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas Header param: This endpoint is in beta: requests must send `ce-claude-code-managed-settings-2026-10-06` in this header.
     * @param RequestOpts|null $requestOptions
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
        array $settings,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaClaudeCodeRBACGroupManagedSettings {
        $params = Util::removeNulls(['settings' => $settings, 'betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->set($rbacGroupID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
