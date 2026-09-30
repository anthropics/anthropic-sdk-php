<?php

declare(strict_types=1);

namespace Anthropic\Services\Organization\Federation\Rules;

use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Organization\Federation\Rules\FederationRuleWorkspace;
use Anthropic\Organization\Federation\Rules\Workspaces\WorkspaceAddParams;
use Anthropic\Organization\Federation\Rules\Workspaces\WorkspaceListParams;
use Anthropic\Organization\Federation\Rules\Workspaces\WorkspaceRemoveParams;
use Anthropic\Organization\Federation\Rules\Workspaces\WorkspaceRemoveResponse;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Organization\Federation\Rules\WorkspacesRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class WorkspacesRawService implements WorkspacesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

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
     * @param array{limit?: int, page?: string|null}|WorkspaceListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<FederationRuleWorkspace>>
     *
     * @throws APIException
     */
    public function list(
        string $federationRuleID,
        array|WorkspaceListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = WorkspaceListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: [
                'v1/organizations/federation_rules/%1$s/workspaces', $federationRuleID,
            ],
            query: $parsed,
            options: $options,
            convert: FederationRuleWorkspace::class,
            page: PageCursor::class,
        );
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
     * @param array{workspaceID: string}|WorkspaceAddParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FederationRuleWorkspace>
     *
     * @throws APIException
     */
    public function add(
        string $federationRuleID,
        array|WorkspaceAddParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = WorkspaceAddParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/organizations/federation_rules/%1$s/workspaces', $federationRuleID,
            ],
            body: (object) $parsed,
            options: $options,
            convert: FederationRuleWorkspace::class,
        );
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
     * @param array{federationRuleID: string}|WorkspaceRemoveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<WorkspaceRemoveResponse>
     *
     * @throws APIException
     */
    public function remove(
        string $workspaceID,
        array|WorkspaceRemoveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = WorkspaceRemoveParams::parseRequest(
            $params,
            $requestOptions,
        );
        $federationRuleID = $parsed['federationRuleID'];
        unset($parsed['federationRuleID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: [
                'v1/organizations/federation_rules/%1$s/workspaces/%2$s',
                $federationRuleID,
                $workspaceID,
            ],
            options: $options,
            convert: WorkspaceRemoveResponse::class,
        );
    }
}
