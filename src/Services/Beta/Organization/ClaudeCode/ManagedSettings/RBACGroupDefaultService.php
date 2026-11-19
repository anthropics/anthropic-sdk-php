<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\ClaudeCode\ManagedSettings;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\BetaRequestBodyTimeoutException;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\BetaCMEKFeatureUnsupportedException;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\BetaSettingsDocumentLimitExceededException;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\BetaSettingsHistoryLimitExceededException;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroupDefault\BetaClaudeCodeRBACGroupDefaultManagedSettings;
use Anthropic\Client;
use Anthropic\CMEKKeyDisabledException;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\RequestOptions;
use Anthropic\SandboxEgressRestrictedException;
use Anthropic\ServiceContracts\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroupDefaultContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class RBACGroupDefaultService implements RBACGroupDefaultContract
{
    /**
     * @api
     */
    public RBACGroupDefaultRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new RBACGroupDefaultRawService($client);
    }

    /**
     * @api
     *
     * Retrieve the default Claude Code managed settings, which members who belong to no RBAC Group in `rbac_group_order` receive in `rbac_groups` mode.
     *
     * **Accepted credentials:** an organization-level Admin API key with the `read:claude_code_managed_settings` scope.
     *
     * Every request must include the beta header `anthropic-beta: ce-claude-code-managed-settings-2026-10-06`. A request without it, or from an organization not enabled for this beta, returns `404`. The Claude Code Managed Settings API is in beta and is available to Claude Enterprise organizations only.
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas This endpoint is in beta: requests must send `ce-claude-code-managed-settings-2026-10-06` in this header.
     * @param RequestOpts|null $requestOptions
     *
     * @throws BetaCMEKFeatureUnsupportedException
     * @throws CMEKKeyDisabledException
     * @throws APIException
     */
    public function retrieve(
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null
    ): BetaClaudeCodeRBACGroupDefaultManagedSettings {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Set or replace the default Claude Code managed settings, or clear them with `null`.
     *
     * **Accepted credentials:** an organization-level Admin API key with the `write:claude_code_managed_settings` scope.
     *
     * Every request must include the beta header `anthropic-beta: ce-claude-code-managed-settings-2026-10-06`. A request without it, or from an organization not enabled for this beta, returns `404`. The Claude Code Managed Settings API is in beta and is available to Claude Enterprise organizations only.
     *
     * A write that returns `503` may have applied. Retrying it is safe.
     *
     * @param array<string,mixed>|null $settings Body param: The whole settings document, a JSON object of Claude Code managed settings. It replaces any stored document, or `null` clears the default settings. At most 1 MiB as the server stores it, which can be larger than the request body.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas Header param: This endpoint is in beta: requests must send `ce-claude-code-managed-settings-2026-10-06` in this header.
     * @param RequestOpts|null $requestOptions
     *
     * @throws BetaCMEKFeatureUnsupportedException
     * @throws CMEKKeyDisabledException
     * @throws BetaRequestBodyTimeoutException
     * @throws BetaSettingsDocumentLimitExceededException
     * @throws BetaSettingsHistoryLimitExceededException
     * @throws SandboxEgressRestrictedException
     * @throws APIException
     */
    public function update(
        ?array $settings,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaClaudeCodeRBACGroupDefaultManagedSettings {
        $params = Util::removeNulls(
            ['settings' => $settings, 'betas' => $betas],
            except: ['settings']
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
