<?php

declare(strict_types=1);

namespace Anthropic\Services\Organization\Federation;

use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\Organization\Federation\Rules\FederationRule;
use Anthropic\Organization\Federation\Rules\FederationRuleMatch;
use Anthropic\Organization\Federation\Rules\RuleCreateParams;
use Anthropic\Organization\Federation\Rules\RuleListParams;
use Anthropic\Organization\Federation\Rules\RuleUpdateParams;
use Anthropic\Organization\Federation\Rules\ServiceAccountTarget;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Organization\Federation\RulesRawContract;

/**
 * @phpstan-import-type FederationRuleMatchShape from \Anthropic\Organization\Federation\Rules\FederationRuleMatch
 * @phpstan-import-type ServiceAccountTargetShape from \Anthropic\Organization\Federation\Rules\ServiceAccountTarget
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class RulesRawService implements RulesRawContract
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
     * Create a federation rule owned by your organization.
     *
     * The referenced issuer and the target service account must already exist
     * in the same organization; invalid references are rejected with a 400
     * error. The workspace reference is validated. Membership is not checked
     * at rule creation: token exchange resolves a single enabled workspace per
     * call and is rejected unless the target service account is a member of
     * that workspace (it is implicitly a member of the default workspace).
     * Rules on well-known shared issuers (GitHub Actions, GitLab, Buildkite,
     * Terraform Cloud, Google) must constrain tenant identity via an
     * identity-bearing claim, a tenant-pinning subject prefix (such as
     * `repo:YOUR_ORG/...`), or a CEL condition referencing one of those
     * identity claims (e.g. `claims.repository_owner`). OAuth callers may only
     * manage rules whose `oauth_scope` is `workspace:developer` or
     * `workspace:inference`; other scopes require a Console session.
     *
     * @param array{
     *   issuerID: string,
     *   match: FederationRuleMatch|FederationRuleMatchShape,
     *   name: string,
     *   oauthScope: string,
     *   target: ServiceAccountTarget|ServiceAccountTargetShape,
     *   appliesToAllWorkspaces?: bool,
     *   description?: string|null,
     *   tokenLifetimeSeconds?: int,
     *   workspaceID?: string|null,
     * }|RuleCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FederationRule>
     *
     * @throws APIException
     */
    public function create(
        array|RuleCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = RuleCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/organizations/federation_rules',
            body: (object) $parsed,
            options: $options,
            convert: FederationRule::class,
        );
    }

    /**
     * @api
     *
     * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
     *
     * Retrieve a federation rule by its ID (`fdrl_...`).
     *
     * @param string $federationRuleID ID of the federation rule
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FederationRule>
     *
     * @throws APIException
     */
    public function retrieve(
        string $federationRuleID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/organizations/federation_rules/%1$s', $federationRuleID],
            options: $requestOptions,
            convert: FederationRule::class,
        );
    }

    /**
     * @api
     *
     * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
     *
     * Partially update a federation rule.
     *
     * `issuer_id` is immutable. `match` and `target` are replaced as whole
     * objects when set. Referenced service accounts and workspaces must exist
     * in your organization; invalid references are rejected with a 400 error.
     * Archived rules cannot be updated; this returns 400. Create a new rule
     * instead. Rules on well-known shared issuers (GitHub Actions, GitLab,
     * Buildkite, Terraform Cloud, Google) must constrain tenant identity via
     * an identity-bearing claim, a tenant-pinning subject prefix (such as
     * `repo:YOUR_ORG/...`), or a CEL condition referencing one of those
     * identity claims (e.g. `claims.repository_owner`). On these issuers the
     * requirement is re-checked on every update; if an existing rule's stored
     * match does not yet constrain tenant identity, any update (even a rename
     * or description change) must also supply a conforming `match` in the same
     * request. OAuth callers may only manage rules whose `oauth_scope` is
     * `workspace:developer` or `workspace:inference`; other scopes require a
     * Console session.
     *
     * @param string $federationRuleID ID of the federation rule to update
     * @param array{
     *   appliesToAllWorkspaces?: bool|null,
     *   description?: string|null,
     *   match?: FederationRuleMatch|FederationRuleMatchShape|null,
     *   name?: string|null,
     *   oauthScope?: string|null,
     *   target?: ServiceAccountTarget|ServiceAccountTargetShape|null,
     *   tokenLifetimeSeconds?: int|null,
     *   workspaceID?: string|null,
     * }|RuleUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FederationRule>
     *
     * @throws APIException
     */
    public function update(
        string $federationRuleID,
        array|RuleUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = RuleUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/organizations/federation_rules/%1$s', $federationRuleID],
            body: (object) $parsed,
            options: $options,
            convert: FederationRule::class,
        );
    }

    /**
     * @api
     *
     * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
     *
     * List federation rules in your organization.
     *
     * Optionally filter by issuer with `issuer_id`. Archived rules are excluded
     * unless `include_archived=true`.
     *
     * @param array{
     *   includeArchived?: bool,
     *   issuerID?: string|null,
     *   limit?: int,
     *   page?: string|null,
     * }|RuleListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<FederationRule>>
     *
     * @throws APIException
     */
    public function list(
        array|RuleListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = RuleListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/organizations/federation_rules',
            query: Util::array_transform_keys(
                $parsed,
                ['includeArchived' => 'include_archived', 'issuerID' => 'issuer_id'],
            ),
            options: $options,
            convert: FederationRule::class,
            page: PageCursor::class,
        );
    }

    /**
     * @api
     *
     * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
     *
     * Archive a federation rule.
     *
     * Token exchange through this rule stops immediately. Idempotent;
     * re-archiving returns the rule with its original `archived_at`. Archiving
     * clears the rule's workspace targeting (`workspace_id` and
     * `workspace_ids` are emptied). Tokens already minted before archive
     * remain valid until they expire. OAuth callers may only manage rules
     * whose `oauth_scope` is `workspace:developer` or `workspace:inference`;
     * other scopes require a Console session.
     *
     * @param string $federationRuleID ID of the federation rule to archive
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FederationRule>
     *
     * @throws APIException
     */
    public function archive(
        string $federationRuleID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/organizations/federation_rules/%1$s/archive', $federationRuleID,
            ],
            options: $requestOptions,
            convert: FederationRule::class,
        );
    }
}
