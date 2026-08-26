<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\Federation\Rules;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\Federation\Rules\BetaFederationRuleWorkspace;
use Anthropic\Beta\Organization\Federation\Rules\Workspaces\WorkspaceRemoveResponse;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\Federation\Rules\WorkspacesContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class WorkspacesService implements WorkspacesContract
{
    /**
     * @api
     */
    public WorkspacesRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new WorkspacesRawService($client);
    }

    /**
     * @api
     *
     * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
     *
     * List workspaces where this federation rule is enabled.
     *
     * Returns all workspace enablements in a single response; the `limit` and
     * `page` parameters are accepted but have no effect, and `next_page` is
     * always `null`. Returns explicit per-workspace enablements only; for
     * rules with `applies_to_all_workspaces` or a legacy single
     * `workspace_id`, check those fields on the rule itself.
     *
     * @param string $federationRuleID path param: ID of the federation rule
     * @param int $limit query param: Number of results per page
     * @param string|null $page query param: Opaque cursor from a previous response's `next_page`
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<BetaFederationRuleWorkspace>
     *
     * @throws APIException
     */
    public function list(
        string $federationRuleID,
        ?int $limit = null,
        ?string $page = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor {
        $params = Util::removeNulls(
            ['limit' => $limit, 'page' => $page, 'betas' => $betas]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list($federationRuleID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
     *
     * Enable a federation rule for a workspace.
     *
     * Idempotent; re-enabling returns the existing enablement. The rule and
     * workspace must both belong to your organization. Membership of the
     * rule's target service account in this workspace is not checked at
     * enablement: token exchange into this workspace is rejected unless the
     * target is a member (it is implicitly a member of the default workspace).
     * Archived rules are rejected with 400. OAuth callers may only manage rules
     * whose `oauth_scope` is `workspace:developer` or `workspace:inference`;
     * other scopes require a Console session.
     *
     * @param string $federationRuleID path param: ID of the federation rule
     * @param string $workspaceID body param: Tagged ID of the workspace to enable this rule for
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function add(
        string $federationRuleID,
        string $workspaceID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaFederationRuleWorkspace {
        $params = Util::removeNulls(
            ['workspaceID' => $workspaceID, 'betas' => $betas]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->add($federationRuleID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
     *
     * Disable a federation rule for a workspace.
     *
     * Idempotent; succeeds even if the enablement was already removed. OAuth
     * callers may only manage rules whose `oauth_scope` is
     * `workspace:developer` or `workspace:inference`; other scopes require a
     * Console session.
     *
     * @param string $workspaceID path param: ID of the workspace to disable for
     * @param string $federationRuleID path param: ID of the federation rule
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function remove(
        string $workspaceID,
        string $federationRuleID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): WorkspaceRemoveResponse {
        $params = Util::removeNulls(
            ['federationRuleID' => $federationRuleID, 'betas' => $betas]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->remove($workspaceID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
