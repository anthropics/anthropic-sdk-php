<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\ClaudeCode\ManagedSettings;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\BetaRequestBodyTimeoutException;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\BetaSettingsDocumentLimitExceededException;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\BetaSettingsHistoryLimitExceededException;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\Configuration\BetaClaudeCodeManagedSettingsConfiguration;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\Configuration\ConfigurationRetrieveParams;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\Configuration\ConfigurationUpdateParams;
use Anthropic\Client;
use Anthropic\CMEKKeyDisabledException;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Implementation\ApiCallInfo;
use Anthropic\Core\Util;
use Anthropic\RequestOptions;
use Anthropic\SandboxEgressRestrictedException;
use Anthropic\ServiceContracts\Beta\Organization\ClaudeCode\ManagedSettings\ConfigurationRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 * @phpstan-import-type BetaClaudeCodeManagedSettingsModeParamShape from \Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\Configuration\BetaClaudeCodeManagedSettingsModeParam
 */
final class ConfigurationRawService implements ConfigurationRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Retrieve the organization's Claude Code managed settings mode and RBAC Group order.
     *
     * **Accepted credentials:** an organization-level Admin API key with the `read:claude_code_managed_settings` scope.
     *
     * Every request must include the beta header `anthropic-beta: ce-claude-code-managed-settings-2026-10-06`. A request without it, or from an organization not enabled for this beta, returns `404`. The Claude Code Managed Settings API is in beta and is available to Claude Enterprise organizations only.
     *
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|ConfigurationRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaClaudeCodeManagedSettingsConfiguration>
     *
     * @throws APIException
     */
    public function retrieve(
        array|ConfigurationRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ConfigurationRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/organizations/claude_code/managed_settings/configuration',
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
                name: 'anthropic.organization.claude_code.managed_settings.configuration.retrieve',
                route: '/v1/organizations/claude_code/managed_settings/configuration',
            )),
            convert: BetaClaudeCodeManagedSettingsConfiguration::class,
        );
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
     * @param array{
     *   mode?: BetaClaudeCodeManagedSettingsModeParamShape,
     *   rbacGroupOrder?: list<string>,
     *   rbacGroupOrderVersion?: string,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|ConfigurationUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaClaudeCodeManagedSettingsConfiguration>
     *
     * @throws CMEKKeyDisabledException
     * @throws BetaRequestBodyTimeoutException
     * @throws BetaSettingsDocumentLimitExceededException
     * @throws BetaSettingsHistoryLimitExceededException
     * @throws SandboxEgressRestrictedException
     * @throws APIException
     */
    public function update(
        array|ConfigurationUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ConfigurationUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/organizations/claude_code/managed_settings/configuration',
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
                name: 'anthropic.organization.claude_code.managed_settings.configuration.update',
                route: '/v1/organizations/claude_code/managed_settings/configuration',
            )),
            convert: BetaClaudeCodeManagedSettingsConfiguration::class,
        );
    }
}
