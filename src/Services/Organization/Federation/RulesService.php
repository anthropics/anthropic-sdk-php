<?php

declare(strict_types=1);

namespace Anthropic\Services\Organization\Federation;

use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\Organization\Federation\Rules\FederationRule;
use Anthropic\Organization\Federation\Rules\FederationRuleMatch;
use Anthropic\Organization\Federation\Rules\ServiceAccountTarget;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Organization\Federation\RulesContract;
use Anthropic\Services\Organization\Federation\Rules\WorkspacesService;

/**
 * @phpstan-import-type FederationRuleMatchShape from \Anthropic\Organization\Federation\Rules\FederationRuleMatch
 * @phpstan-import-type ServiceAccountTargetShape from \Anthropic\Organization\Federation\Rules\ServiceAccountTarget
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class RulesService implements RulesContract
{
    /**
     * @api
     */
    public RulesRawService $raw;

    /**
     * @api
     */
    public WorkspacesService $workspaces;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new RulesRawService($client);
        $this->workspaces = new WorkspacesService($client);
    }

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
     * @param string $issuerID tagged ID of the federation issuer
     * @param FederationRuleMatch|FederationRuleMatchShape $match Conditions the verified JWT must satisfy for this rule to apply. At least one of `subject_prefix` (other than a wildcard-only value like `*`), `claims`, or `condition` is required; `audience` alone is not sufficient.
     * @param string $name Slug identifier (lowercase, digits, hyphens). Unique within the organization; a duplicate name returns 409.
     * @param string $oauthScope Space-separated OAuth scopes. OAuth callers may only set `workspace:developer` or `workspace:inference`; other scopes (such as `org:admin`) require a Console session.
     * @param ServiceAccountTarget|ServiceAccountTargetShape $target Identity that tokens minted via this rule act as. Currently always a `service_account` target.
     * @param bool $appliesToAllWorkspaces when true, enable this rule for every workspace in the org (including workspaces created later)
     * @param string|null $description optional free-text description
     * @param int $tokenLifetimeSeconds Lifetime in seconds for access tokens minted via this rule (60-86400). Defaults to 3600 (1h). Minted tokens are capped at `max(60, min(this value, 2 × remaining assertion validity))` seconds.
     * @param string|null $workspaceID Tagged ID of the workspace to enable this rule for. Required unless `applies_to_all_workspaces` is true. Additional workspaces can be added via the `/federation_rules/{federation_rule_id}/workspaces` sub-resource.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $issuerID,
        FederationRuleMatch|array $match,
        string $name,
        string $oauthScope,
        ServiceAccountTarget|array $target,
        ?bool $appliesToAllWorkspaces = null,
        ?string $description = null,
        ?int $tokenLifetimeSeconds = null,
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): FederationRule {
        $params = Util::removeNulls(
            [
                'issuerID' => $issuerID,
                'match' => $match,
                'name' => $name,
                'oauthScope' => $oauthScope,
                'target' => $target,
                'appliesToAllWorkspaces' => $appliesToAllWorkspaces,
                'description' => $description,
                'tokenLifetimeSeconds' => $tokenLifetimeSeconds,
                'workspaceID' => $workspaceID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
     * @throws APIException
     */
    public function retrieve(
        string $federationRuleID,
        RequestOptions|array|null $requestOptions = null
    ): FederationRule {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($federationRuleID, requestOptions: $requestOptions);

        return $response->parse();
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
     * @param bool|null $appliesToAllWorkspaces When true, enables this rule for every workspace in the org (including workspaces created later). Setting `false` is rejected with 400 if no workspace would remain enabled; a rule with only a legacy `workspace_id` binding continues to mint.
     * @param string|null $description Replaces the description. Omit to leave unchanged; send `null` to clear (the field is stored as an empty string).
     * @param FederationRuleMatch|FederationRuleMatchShape|null $match Replaces the entire match object. All populated matcher fields must pass.
     * @param string|null $name Replaces the slug identifier (lowercase, digits, hyphens). Unique within the organization; a duplicate name returns 409.
     * @param string|null $oauthScope Replaces the space-separated OAuth scopes granted on minted tokens. OAuth callers may only set `workspace:developer` or `workspace:inference`; other scopes (such as `org:admin`) require a Console session.
     * @param ServiceAccountTarget|ServiceAccountTargetShape|null $target Replaces the entire target object. Currently always a `service_account` target.
     * @param int|null $tokenLifetimeSeconds Replaces the lifetime in seconds for access tokens minted via this rule (60-86400). Minted tokens are capped at `max(60, min(this value, 2 × remaining assertion validity))` seconds.
     * @param string|null $workspaceID Replaces the existing single workspace enablement (the previous one is removed). Rejected with 400 if the rule is enabled for more than one workspace; use the `/federation_rules/{federation_rule_id}/workspaces` sub-resource instead.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $federationRuleID,
        ?bool $appliesToAllWorkspaces = null,
        ?string $description = null,
        FederationRuleMatch|array|null $match = null,
        ?string $name = null,
        ?string $oauthScope = null,
        ServiceAccountTarget|array|null $target = null,
        ?int $tokenLifetimeSeconds = null,
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): FederationRule {
        $params = Util::removeNulls(
            [
                'appliesToAllWorkspaces' => $appliesToAllWorkspaces,
                'description' => $description,
                'match' => $match,
                'name' => $name,
                'oauthScope' => $oauthScope,
                'target' => $target,
                'tokenLifetimeSeconds' => $tokenLifetimeSeconds,
                'workspaceID' => $workspaceID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($federationRuleID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
     * @param bool $includeArchived Include archived resources. Defaults to false.
     * @param string|null $issuerID filter to rules referencing this federation issuer
     * @param int $limit number of results per page
     * @param string|null $page opaque cursor from a previous response's `next_page`
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<FederationRule>
     *
     * @throws APIException
     */
    public function list(
        ?bool $includeArchived = null,
        ?string $issuerID = null,
        ?int $limit = null,
        ?string $page = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor {
        $params = Util::removeNulls(
            [
                'includeArchived' => $includeArchived,
                'issuerID' => $issuerID,
                'limit' => $limit,
                'page' => $page,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
     * @throws APIException
     */
    public function archive(
        string $federationRuleID,
        RequestOptions|array|null $requestOptions = null
    ): FederationRule {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->archive($federationRuleID, requestOptions: $requestOptions);

        return $response->parse();
    }
}
