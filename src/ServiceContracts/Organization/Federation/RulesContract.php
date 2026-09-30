<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Organization\Federation;

use Anthropic\Core\Exceptions\APIException;
use Anthropic\Organization\Federation\Rules\FederationRule;
use Anthropic\Organization\Federation\Rules\FederationRuleMatch;
use Anthropic\Organization\Federation\Rules\ServiceAccountTarget;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type FederationRuleMatchShape from \Anthropic\Organization\Federation\Rules\FederationRuleMatch
 * @phpstan-import-type ServiceAccountTargetShape from \Anthropic\Organization\Federation\Rules\ServiceAccountTarget
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface RulesContract
{
    /**
     * @api
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
    ): FederationRule;

    /**
     * @api
     *
     * @param string $federationRuleID ID of the federation rule
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $federationRuleID,
        RequestOptions|array|null $requestOptions = null
    ): FederationRule;

    /**
     * @api
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
    ): FederationRule;

    /**
     * @api
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
    ): PageCursor;

    /**
     * @api
     *
     * @param string $federationRuleID ID of the federation rule to archive
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function archive(
        string $federationRuleID,
        RequestOptions|array|null $requestOptions = null
    ): FederationRule;
}
