<?php

declare(strict_types=1);

namespace Anthropic\Services\Organization\Federation\Rules;

use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\Organization\Federation\Rules\FederationRuleWorkspace;
use Anthropic\Organization\Federation\Rules\Workspaces\WorkspaceRemoveResponse;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Organization\Federation\Rules\WorkspacesContract;

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
     * @param string $federationRuleID ID of the federation rule
     * @param int $limit number of results per page
     * @param string|null $page opaque cursor from a previous response's `next_page`
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<FederationRuleWorkspace>
     *
     * @throws APIException
     */
    public function list(
        string $federationRuleID,
        ?int $limit = null,
        ?string $page = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor {
        $params = Util::removeNulls(['limit' => $limit, 'page' => $page]);

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
     * @param string $federationRuleID ID of the federation rule
     * @param string $workspaceID tagged ID of the workspace to enable this rule for
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function add(
        string $federationRuleID,
        string $workspaceID,
        RequestOptions|array|null $requestOptions = null,
    ): FederationRuleWorkspace {
        $params = Util::removeNulls(['workspaceID' => $workspaceID]);

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
     * @param string $workspaceID ID of the workspace to disable for
     * @param string $federationRuleID ID of the federation rule
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function remove(
        string $workspaceID,
        string $federationRuleID,
        RequestOptions|array|null $requestOptions = null,
    ): WorkspaceRemoveResponse {
        $params = Util::removeNulls(['federationRuleID' => $federationRuleID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->remove($workspaceID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
