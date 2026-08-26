<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\Federation;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\Federation\Rules\BetaFederationRule;
use Anthropic\Beta\Organization\Federation\Rules\BetaFederationRuleMatch;
use Anthropic\Beta\Organization\Federation\Rules\BetaServiceAccountTarget;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type BetaFederationRuleMatchShape from \Anthropic\Beta\Organization\Federation\Rules\BetaFederationRuleMatch
 * @phpstan-import-type BetaServiceAccountTargetShape from \Anthropic\Beta\Organization\Federation\Rules\BetaServiceAccountTarget
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface RulesContract
{
    /**
     * @api
     *
     * @param string $issuerID body param: Tagged ID of the federation issuer
     * @param BetaFederationRuleMatch|BetaFederationRuleMatchShape $match Body param: Conditions the verified JWT must satisfy for this rule to apply. At least one of `subject_prefix` (other than a wildcard-only value like `*`), `claims`, or `condition` is required; `audience` alone is not sufficient.
     * @param string $name Body param: Slug identifier (lowercase, digits, hyphens). Unique within the organization; a duplicate name returns 409.
     * @param string $oauthScope Body param: Space-separated OAuth scopes. OAuth callers may only set `workspace:developer` or `workspace:inference`; other scopes (such as `org:admin`) require a Console session.
     * @param BetaServiceAccountTarget|BetaServiceAccountTargetShape $target Body param: Identity that tokens minted via this rule act as. Currently always a `service_account` target.
     * @param bool $appliesToAllWorkspaces body param: When true, enable this rule for every workspace in the org (including workspaces created later)
     * @param array<string,string>|null $attributes Body param: CEL expressions `{name: expr}` extracting named values from claims. Not yet supported; any non-empty value is rejected with 400.
     * @param string|null $description body param: Optional free-text description
     * @param int $tokenLifetimeSeconds Body param: Lifetime in seconds for access tokens minted via this rule (60-86400). Defaults to 3600 (1h). Minted tokens are capped at `max(60, min(this value, 2 × remaining assertion validity))` seconds.
     * @param string|null $workspaceID Body param: Tagged ID of the workspace to enable this rule for. Required unless `applies_to_all_workspaces` is true. Additional workspaces can be added via the `/federation_rules/{federation_rule_id}/workspaces` sub-resource.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $issuerID,
        BetaFederationRuleMatch|array $match,
        string $name,
        string $oauthScope,
        BetaServiceAccountTarget|array $target,
        ?bool $appliesToAllWorkspaces = null,
        ?array $attributes = null,
        ?string $description = null,
        ?int $tokenLifetimeSeconds = null,
        ?string $workspaceID = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaFederationRule;

    /**
     * @api
     *
     * @param string $federationRuleID ID of the federation rule
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $federationRuleID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaFederationRule;

    /**
     * @api
     *
     * @param string $federationRuleID path param: ID of the federation rule to update
     * @param bool|null $appliesToAllWorkspaces Body param: When true, enables this rule for every workspace in the org (including workspaces created later). Setting `false` is rejected with 400 if no workspace would remain enabled; a rule with only a legacy `workspace_id` binding continues to mint.
     * @param array<string,string>|null $attributes Body param: Replaces the CEL expressions `{name: expr}` extracting named values from claims. Send null to clear them. Not yet supported; any non-empty value is rejected with 400.
     * @param string|null $description Body param: Replaces the description. Omit to leave unchanged; send `null` to clear (the field is stored as an empty string).
     * @param BetaFederationRuleMatch|BetaFederationRuleMatchShape|null $match Body param: Does the incoming JWT qualify?
     *
     * All populated fields must pass; omitted fields are skipped. At least one
     * of `subject_prefix` (other than a wildcard-only value like `*`), `claims`,
     * or `condition` is required; `audience` alone is not sufficient.
     * @param string|null $name Body param: Replaces the slug identifier (lowercase, digits, hyphens). Unique within the organization; a duplicate name returns 409.
     * @param string|null $oauthScope Body param: Replaces the space-separated OAuth scopes granted on minted tokens. OAuth callers may only set `workspace:developer` or `workspace:inference`; other scopes (such as `org:admin`) require a Console session.
     * @param BetaServiceAccountTarget|BetaServiceAccountTargetShape|null $target body param: Bind to a fixed service account by ID
     * @param int|null $tokenLifetimeSeconds Body param: Replaces the lifetime in seconds for access tokens minted via this rule (60-86400). Minted tokens are capped at `max(60, min(this value, 2 × remaining assertion validity))` seconds.
     * @param string|null $workspaceID Body param: Replaces the existing single workspace enablement (the previous one is removed). Rejected with 400 if the rule is enabled for more than one workspace; use the `/federation_rules/{federation_rule_id}/workspaces` sub-resource instead.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $federationRuleID,
        ?bool $appliesToAllWorkspaces = null,
        ?array $attributes = null,
        ?string $description = null,
        BetaFederationRuleMatch|array|null $match = null,
        ?string $name = null,
        ?string $oauthScope = null,
        BetaServiceAccountTarget|array|null $target = null,
        ?int $tokenLifetimeSeconds = null,
        ?string $workspaceID = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaFederationRule;

    /**
     * @api
     *
     * @param bool $includeArchived Query param: Include archived resources. Defaults to false.
     * @param string|null $issuerID query param: Filter to rules referencing this federation issuer
     * @param int $limit query param: Number of results per page
     * @param string|null $page query param: Opaque cursor from a previous response's `next_page`
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<BetaFederationRule>
     *
     * @throws APIException
     */
    public function list(
        ?bool $includeArchived = null,
        ?string $issuerID = null,
        ?int $limit = null,
        ?string $page = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;

    /**
     * @api
     *
     * @param string $federationRuleID ID of the federation rule to archive
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function archive(
        string $federationRuleID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaFederationRule;
}
