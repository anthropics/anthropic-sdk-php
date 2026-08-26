<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Federation\Rules;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
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
 * @see Anthropic\Services\Beta\Organization\Federation\RulesService::update()
 *
 * @phpstan-import-type BetaFederationRuleMatchShape from \Anthropic\Beta\Organization\Federation\Rules\BetaFederationRuleMatch
 * @phpstan-import-type BetaServiceAccountTargetShape from \Anthropic\Beta\Organization\Federation\Rules\BetaServiceAccountTarget
 *
 * @phpstan-type RuleUpdateParamsShape = array{
 *   appliesToAllWorkspaces?: bool|null,
 *   attributes?: array<string,string>|null,
 *   description?: string|null,
 *   match?: null|BetaFederationRuleMatch|BetaFederationRuleMatchShape,
 *   name?: string|null,
 *   oauthScope?: string|null,
 *   target?: null|BetaServiceAccountTarget|BetaServiceAccountTargetShape,
 *   tokenLifetimeSeconds?: int|null,
 *   workspaceID?: string|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class RuleUpdateParams implements BaseModel
{
    /** @use SdkModel<RuleUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * When true, enables this rule for every workspace in the org (including workspaces created later). Setting `false` is rejected with 400 if no workspace would remain enabled; a rule with only a legacy `workspace_id` binding continues to mint.
     */
    #[Optional('applies_to_all_workspaces', nullable: true)]
    public ?bool $appliesToAllWorkspaces;

    /**
     * Replaces the CEL expressions `{name: expr}` extracting named values from claims. Send null to clear them. Not yet supported; any non-empty value is rejected with 400.
     *
     * @var array<string,string>|null $attributes
     */
    #[Optional(map: 'string', nullable: true)]
    public ?array $attributes;

    /**
     * Replaces the description. Omit to leave unchanged; send `null` to clear (the field is stored as an empty string).
     */
    #[Optional(nullable: true)]
    public ?string $description;

    /**
     * Does the incoming JWT qualify?
     *
     * All populated fields must pass; omitted fields are skipped. At least one
     * of `subject_prefix` (other than a wildcard-only value like `*`), `claims`,
     * or `condition` is required; `audience` alone is not sufficient.
     */
    #[Optional(nullable: true)]
    public ?BetaFederationRuleMatch $match;

    /**
     * Replaces the slug identifier (lowercase, digits, hyphens). Unique within the organization; a duplicate name returns 409.
     */
    #[Optional(nullable: true)]
    public ?string $name;

    /**
     * Replaces the space-separated OAuth scopes granted on minted tokens. OAuth callers may only set `workspace:developer` or `workspace:inference`; other scopes (such as `org:admin`) require a Console session.
     */
    #[Optional('oauth_scope', nullable: true)]
    public ?string $oauthScope;

    /**
     * Bind to a fixed service account by ID.
     */
    #[Optional(nullable: true)]
    public ?BetaServiceAccountTarget $target;

    /**
     * Replaces the lifetime in seconds for access tokens minted via this rule (60-86400). Minted tokens are capped at `max(60, min(this value, 2 × remaining assertion validity))` seconds.
     */
    #[Optional('token_lifetime_seconds', nullable: true)]
    public ?int $tokenLifetimeSeconds;

    /**
     * Replaces the existing single workspace enablement (the previous one is removed). Rejected with 400 if the rule is enabled for more than one workspace; use the `/federation_rules/{federation_rule_id}/workspaces` sub-resource instead.
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

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param array<string,string>|null $attributes
     * @param BetaFederationRuleMatch|BetaFederationRuleMatchShape|null $match
     * @param BetaServiceAccountTarget|BetaServiceAccountTargetShape|null $target
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
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
    ): self {
        $self = new self;

        null !== $appliesToAllWorkspaces && $self['appliesToAllWorkspaces'] = $appliesToAllWorkspaces;
        null !== $attributes && $self['attributes'] = $attributes;
        null !== $description && $self['description'] = $description;
        null !== $match && $self['match'] = $match;
        null !== $name && $self['name'] = $name;
        null !== $oauthScope && $self['oauthScope'] = $oauthScope;
        null !== $target && $self['target'] = $target;
        null !== $tokenLifetimeSeconds && $self['tokenLifetimeSeconds'] = $tokenLifetimeSeconds;
        null !== $workspaceID && $self['workspaceID'] = $workspaceID;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * When true, enables this rule for every workspace in the org (including workspaces created later). Setting `false` is rejected with 400 if no workspace would remain enabled; a rule with only a legacy `workspace_id` binding continues to mint.
     */
    public function withAppliesToAllWorkspaces(
        ?bool $appliesToAllWorkspaces
    ): self {
        $self = clone $this;
        $self['appliesToAllWorkspaces'] = $appliesToAllWorkspaces;

        return $self;
    }

    /**
     * Replaces the CEL expressions `{name: expr}` extracting named values from claims. Send null to clear them. Not yet supported; any non-empty value is rejected with 400.
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
     * Replaces the description. Omit to leave unchanged; send `null` to clear (the field is stored as an empty string).
     */
    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Does the incoming JWT qualify?
     *
     * All populated fields must pass; omitted fields are skipped. At least one
     * of `subject_prefix` (other than a wildcard-only value like `*`), `claims`,
     * or `condition` is required; `audience` alone is not sufficient.
     *
     * @param BetaFederationRuleMatch|BetaFederationRuleMatchShape|null $match
     */
    public function withMatch(BetaFederationRuleMatch|array|null $match): self
    {
        $self = clone $this;
        $self['match'] = $match;

        return $self;
    }

    /**
     * Replaces the slug identifier (lowercase, digits, hyphens). Unique within the organization; a duplicate name returns 409.
     */
    public function withName(?string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Replaces the space-separated OAuth scopes granted on minted tokens. OAuth callers may only set `workspace:developer` or `workspace:inference`; other scopes (such as `org:admin`) require a Console session.
     */
    public function withOAuthScope(?string $oauthScope): self
    {
        $self = clone $this;
        $self['oauthScope'] = $oauthScope;

        return $self;
    }

    /**
     * Bind to a fixed service account by ID.
     *
     * @param BetaServiceAccountTarget|BetaServiceAccountTargetShape|null $target
     */
    public function withTarget(
        BetaServiceAccountTarget|array|null $target
    ): self {
        $self = clone $this;
        $self['target'] = $target;

        return $self;
    }

    /**
     * Replaces the lifetime in seconds for access tokens minted via this rule (60-86400). Minted tokens are capped at `max(60, min(this value, 2 × remaining assertion validity))` seconds.
     */
    public function withTokenLifetimeSeconds(?int $tokenLifetimeSeconds): self
    {
        $self = clone $this;
        $self['tokenLifetimeSeconds'] = $tokenLifetimeSeconds;

        return $self;
    }

    /**
     * Replaces the existing single workspace enablement (the previous one is removed). Rejected with 400 if the rule is enabled for more than one workspace; use the `/federation_rules/{federation_rule_id}/workspaces` sub-resource instead.
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
