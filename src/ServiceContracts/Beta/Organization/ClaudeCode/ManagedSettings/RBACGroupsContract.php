<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\ClaudeCode\ManagedSettings;

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
use Anthropic\CMEKKeyDisabledException;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\SandboxEgressRestrictedException;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface RBACGroupsContract
{
    /**
     * @api
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
    ): BetaClaudeCodeRBACGroupManagedSettings;

    /**
     * @api
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
    ): PageCursor;

    /**
     * @api
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
    ): BetaDeletedClaudeCodeRBACGroupManagedSettings;

    /**
     * @api
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
    ): BetaClaudeCodeRBACGroupManagedSettings;
}
