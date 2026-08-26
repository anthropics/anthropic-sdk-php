<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Federation\Rules;

use Anthropic\Beta\AnthropicBeta;
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
 * @see Anthropic\Services\Beta\Organization\Federation\RulesService::create()
 *
 * @phpstan-import-type BetaFederationRuleMatchShape from \Anthropic\Beta\Organization\Federation\Rules\BetaFederationRuleMatch
 * @phpstan-import-type BetaServiceAccountTargetShape from \Anthropic\Beta\Organization\Federation\Rules\BetaServiceAccountTarget
 *
 * @phpstan-type RuleCreateParamsShape = array{
 *   issuerID: string,
 *   match: BetaFederationRuleMatch|BetaFederationRuleMatchShape,
 *   name: string,
 *   oauthScope: string,
 *   target: BetaServiceAccountTarget|BetaServiceAccountTargetShape,
 *   appliesToAllWorkspaces?: bool|null,
 *   attributes?: array<string,string>|null,
 *   description?: string|null,
 *   tokenLifetimeSeconds?: int|null,
 *   workspaceID?: string|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
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
    public BetaFederationRuleMatch $match;

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
    public BetaServiceAccountTarget $target;

    /**
     * When true, enable this rule for every workspace in the org (including workspaces created later).
     */
    #[Optional('applies_to_all_workspaces')]
    public ?bool $appliesToAllWorkspaces;

    /**
     * CEL expressions `{name: expr}` extracting named values from claims. Not yet supported; any non-empty value is rejected with 400.
     *
     * @var array<string,string>|null $attributes
     */
    #[Optional(map: 'string', nullable: true)]
    public ?array $attributes;

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
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

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
     * (new RuleCreateParams)
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
     * @param BetaFederationRuleMatch|BetaFederationRuleMatchShape $match
     * @param BetaServiceAccountTarget|BetaServiceAccountTargetShape $target
     * @param array<string,string>|null $attributes
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
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
    ): self {
        $self = new self;

        $self['issuerID'] = $issuerID;
        $self['match'] = $match;
        $self['name'] = $name;
        $self['oauthScope'] = $oauthScope;
        $self['target'] = $target;

        null !== $appliesToAllWorkspaces && $self['appliesToAllWorkspaces'] = $appliesToAllWorkspaces;
        null !== $attributes && $self['attributes'] = $attributes;
        null !== $description && $self['description'] = $description;
        null !== $tokenLifetimeSeconds && $self['tokenLifetimeSeconds'] = $tokenLifetimeSeconds;
        null !== $workspaceID && $self['workspaceID'] = $workspaceID;
        null !== $betas && $self['betas'] = $betas;

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
     * @param BetaFederationRuleMatch|BetaFederationRuleMatchShape $match
     */
    public function withMatch(BetaFederationRuleMatch|array $match): self
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
     * @param BetaServiceAccountTarget|BetaServiceAccountTargetShape $target
     */
    public function withTarget(BetaServiceAccountTarget|array $target): self
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
     * CEL expressions `{name: expr}` extracting named values from claims. Not yet supported; any non-empty value is rejected with 400.
     *
     * @param array<string,string>|null $attributes
     */
    public function withAttributes(?array $attributes): self
    {
        $self = clone $this;
        $self['attributes'] = $attributes;

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

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas
     */
    public function withBetas(array $betas): self
    {
        $self = clone $this;
        $self['betas'] = $betas;

        return $self;
    }
}
