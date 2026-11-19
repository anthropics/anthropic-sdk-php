<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\ClaudeCode\ManagedSettings;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\BetaRequestBodyTimeoutException;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\BetaSettingsDocumentLimitExceededException;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\BetaSettingsHistoryLimitExceededException;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\Configuration\BetaClaudeCodeManagedSettingsConfiguration;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\Configuration\BetaClaudeCodeManagedSettingsOrganizationModeParam;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\Configuration\BetaClaudeCodeManagedSettingsRBACGroupsModeParam;
use Anthropic\Client;
use Anthropic\CMEKKeyDisabledException;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\RequestOptions;
use Anthropic\SandboxEgressRestrictedException;
use Anthropic\ServiceContracts\Beta\Organization\ClaudeCode\ManagedSettings\ConfigurationContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 * @phpstan-import-type BetaClaudeCodeManagedSettingsModeParamShape from \Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\Configuration\BetaClaudeCodeManagedSettingsModeParam
 */
final class ConfigurationService implements ConfigurationContract
{
    /**
     * @api
     */
    public ConfigurationRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ConfigurationRawService($client);
    }

    /**
     * @api
     *
     * Retrieve the organization's Claude Code managed settings mode and RBAC Group order.
     *
     * **Accepted credentials:** an organization-level Admin API key with the `read:claude_code_managed_settings` scope.
     *
     * Every request must include the beta header `anthropic-beta: ce-claude-code-managed-settings-2026-10-06`. A request without it, or from an organization not enabled for this beta, returns `404`. The Claude Code Managed Settings API is in beta and is available to Claude Enterprise organizations only.
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas This endpoint is in beta: requests must send `ce-claude-code-managed-settings-2026-10-06` in this header.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null
    ): BetaClaudeCodeManagedSettingsConfiguration {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Change the organization's Claude Code managed settings mode, the RBAC Group order, or both, in one atomic write.
     *
     * To change the order, send `rbac_group_order` with the `rbac_group_order_version` from the read the change is based on. If the order has changed since that read, the request returns `409`: read it again and retry. To switch modes only if the order has not changed, send the current `rbac_group_order` and `rbac_group_order_version` with the new `mode`.
     *
     * A switch to `rbac_groups` mode with no RBAC Group settings and no default settings copies the organization settings into a new default, in the same write, so members keep the settings they had. The copy does not follow later changes to the organization settings. If the organization settings cannot be copied, the request returns `400` and changes nothing. If they cannot be read, are over 1 MiB or are not valid, setting the default settings first avoids the copy.
     *
     * After a switch to `rbac_groups` mode, a member in no listed RBAC Group receives the default settings, or no settings if no default is set, not the organization settings.
     *
     * **Accepted credentials:** an organization-level Admin API key with the `write:claude_code_managed_settings` scope.
     *
     * Every request must include the beta header `anthropic-beta: ce-claude-code-managed-settings-2026-10-06`. A request without it, or from an organization not enabled for this beta, returns `404`. The Claude Code Managed Settings API is in beta and is available to Claude Enterprise organizations only.
     *
     * A write that returns `503` may have applied. Retrying it is safe.
     *
     * @param BetaClaudeCodeManagedSettingsModeParamShape $mode Body param: The new mode, as an object such as `{"type": "rbac_groups"}`.
     * @param list<string> $rbacGroupOrder Body param: Every RBAC Group that has settings, each listed once, in the new order, highest precedence first. Requires `rbac_group_order_version`.
     * @param string $rbacGroupOrderVersion Body param: The `rbac_group_order_version` from the read this change is based on. Requires `rbac_group_order`.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas Header param: This endpoint is in beta: requests must send `ce-claude-code-managed-settings-2026-10-06` in this header.
     * @param RequestOpts|null $requestOptions
     *
     * @throws CMEKKeyDisabledException
     * @throws BetaRequestBodyTimeoutException
     * @throws BetaSettingsDocumentLimitExceededException
     * @throws BetaSettingsHistoryLimitExceededException
     * @throws SandboxEgressRestrictedException
     * @throws APIException
     */
    public function update(
        BetaClaudeCodeManagedSettingsOrganizationModeParam|array|BetaClaudeCodeManagedSettingsRBACGroupsModeParam|null $mode = null,
        ?array $rbacGroupOrder = null,
        ?string $rbacGroupOrderVersion = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaClaudeCodeManagedSettingsConfiguration {
        $params = Util::removeNulls(
            [
                'mode' => $mode,
                'rbacGroupOrder' => $rbacGroupOrder,
                'rbacGroupOrderVersion' => $rbacGroupOrderVersion,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
