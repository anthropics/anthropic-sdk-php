<?php

declare(strict_types=1);

namespace Anthropic\Organization\Federation\Rules;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
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
 * @see Anthropic\Services\Organization\Federation\RulesService::create()
 *
 * @phpstan-import-type FederationRuleMatchShape from \Anthropic\Organization\Federation\Rules\FederationRuleMatch
 * @phpstan-import-type ServiceAccountTargetShape from \Anthropic\Organization\Federation\Rules\ServiceAccountTarget
 *
 * @phpstan-type RuleCreateParamsShape = array{
 *   issuerID: string,
 *   match: FederationRuleMatch|FederationRuleMatchShape,
 *   name: string,
 *   oauthScope: string,
 *   target: ServiceAccountTarget|ServiceAccountTargetShape,
 *   appliesToAllWorkspaces?: bool|null,
 *   description?: string|null,
 *   tokenLifetimeSeconds?: int|null,
 *   workspaceID?: string|null,
 * }
 */
final class RuleCreateParams implements BaseModel
{
    /** @use SdkModel<RuleCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Tagged ID of the federation issuer.
     */
    #[Required('issuer_id')]
    public string $issuerID;

    /**
     * Conditions the verified JWT must satisfy for this rule to apply. At least one of `subject_prefix` (other than a wildcard-only value like `*`), `claims`, or `condition` is required; `audience` alone is not sufficient.
     */
    #[Required]
    public FederationRuleMatch $match;

    /**
     * Slug identifier (lowercase, digits, hyphens). Unique within the organization; a duplicate name returns 409.
     */
    #[Required]
    public string $name;

    /**
     * Space-separated OAuth scopes. OAuth callers may only set `workspace:developer` or `workspace:inference`; other scopes (such as `org:admin`) require a Console session.
     */
    #[Required('oauth_scope')]
    public string $oauthScope;

    /**
     * Identity that tokens minted via this rule act as. Currently always a `service_account` target.
     */
    #[Required]
    public ServiceAccountTarget $target;

    /**
     * When true, enable this rule for every workspace in the org (including workspaces created later).
     */
    #[Optional('applies_to_all_workspaces')]
    public ?bool $appliesToAllWorkspaces;

    /**
     * Optional free-text description.
     */
    #[Optional(nullable: true)]
    public ?string $description;

    /**
     * Lifetime in seconds for access tokens minted via this rule (60-86400). Defaults to 3600 (1h). Minted tokens are capped at `max(60, min(this value, 2 × remaining assertion validity))` seconds.
     */
    #[Optional('token_lifetime_seconds')]
    public ?int $tokenLifetimeSeconds;

    /**
     * Tagged ID of the workspace to enable this rule for. Required unless `applies_to_all_workspaces` is true. Additional workspaces can be added via the `/federation_rules/{federation_rule_id}/workspaces` sub-resource.
     */
    #[Optional('workspace_id', nullable: true)]
    public ?string $workspaceID;

    /**
     * `new RuleCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * RuleCreateParams::with(
     *   issuerID: ..., match: ..., name: ..., oauthScope: ..., target: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new RuleCreateParams())
     *   ->withIssuerID(...)
     *   ->withMatch(...)
     *   ->withName(...)
     *   ->withOAuthScope(...)
     *   ->withTarget(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param FederationRuleMatch|FederationRuleMatchShape $match
     * @param ServiceAccountTarget|ServiceAccountTargetShape $target
     */
    public static function with(
        string $issuerID,
        FederationRuleMatch|array $match,
        string $name,
        string $oauthScope,
        ServiceAccountTarget|array $target,
        ?bool $appliesToAllWorkspaces = null,
        ?string $description = null,
        ?int $tokenLifetimeSeconds = null,
        ?string $workspaceID = null,
    ): self {
        $self = new self;

        $self['issuerID'] = $issuerID;
        $self['match'] = $match;
        $self['name'] = $name;
        $self['oauthScope'] = $oauthScope;
        $self['target'] = $target;

        null !== $appliesToAllWorkspaces && $self['appliesToAllWorkspaces'] = $appliesToAllWorkspaces;
        null !== $description && $self['description'] = $description;
        null !== $tokenLifetimeSeconds && $self['tokenLifetimeSeconds'] = $tokenLifetimeSeconds;
        null !== $workspaceID && $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * Tagged ID of the federation issuer.
     */
    public function withIssuerID(string $issuerID): self
    {
        $self = clone $this;
        $self['issuerID'] = $issuerID;

        return $self;
    }

    /**
     * Conditions the verified JWT must satisfy for this rule to apply. At least one of `subject_prefix` (other than a wildcard-only value like `*`), `claims`, or `condition` is required; `audience` alone is not sufficient.
     *
     * @param FederationRuleMatch|FederationRuleMatchShape $match
     */
    public function withMatch(FederationRuleMatch|array $match): self
    {
        $self = clone $this;
        $self['match'] = $match;

        return $self;
    }

    /**
     * Slug identifier (lowercase, digits, hyphens). Unique within the organization; a duplicate name returns 409.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Space-separated OAuth scopes. OAuth callers may only set `workspace:developer` or `workspace:inference`; other scopes (such as `org:admin`) require a Console session.
     */
    public function withOAuthScope(string $oauthScope): self
    {
        $self = clone $this;
        $self['oauthScope'] = $oauthScope;

        return $self;
    }

    /**
     * Identity that tokens minted via this rule act as. Currently always a `service_account` target.
     *
     * @param ServiceAccountTarget|ServiceAccountTargetShape $target
     */
    public function withTarget(ServiceAccountTarget|array $target): self
    {
        $self = clone $this;
        $self['target'] = $target;

        return $self;
    }

    /**
     * When true, enable this rule for every workspace in the org (including workspaces created later).
     */
    public function withAppliesToAllWorkspaces(
        bool $appliesToAllWorkspaces
    ): self {
        $self = clone $this;
        $self['appliesToAllWorkspaces'] = $appliesToAllWorkspaces;

        return $self;
    }

    /**
     * Optional free-text description.
     */
    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Lifetime in seconds for access tokens minted via this rule (60-86400). Defaults to 3600 (1h). Minted tokens are capped at `max(60, min(this value, 2 × remaining assertion validity))` seconds.
     */
    public function withTokenLifetimeSeconds(int $tokenLifetimeSeconds): self
    {
        $self = clone $this;
        $self['tokenLifetimeSeconds'] = $tokenLifetimeSeconds;

        return $self;
    }

    /**
     * Tagged ID of the workspace to enable this rule for. Required unless `applies_to_all_workspaces` is true. Additional workspaces can be added via the `/federation_rules/{federation_rule_id}/workspaces` sub-resource.
     */
    public function withWorkspaceID(?string $workspaceID): self
    {
        $self = clone $this;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }
}
