<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Federation\Rules;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Authorization rule binding an external OIDC identity to Anthropic.
 *
 * Evaluates the match conditions and mints an OAuth access token for the
 * resolved target, scoped to a single workspace where the rule is enabled
 * (chosen by the caller at exchange time when the rule is enabled for more
 * than one). For rules enabled via `workspace_ids` or
 * `applies_to_all_workspaces`, the target service account must be a member
 * of that workspace (it is implicitly a member of the default workspace);
 * rules carrying only the legacy `workspace_id` binding do not enforce
 * this.
 *
 * @phpstan-import-type BetaFederationRuleMatchShape from \Anthropic\Beta\Organization\Federation\Rules\BetaFederationRuleMatch
 * @phpstan-import-type BetaServiceAccountTargetShape from \Anthropic\Beta\Organization\Federation\Rules\BetaServiceAccountTarget
 *
 * @phpstan-type BetaFederationRuleShape = array{
 *   id: string,
 *   appliesToAllWorkspaces: bool,
 *   archivedAt: \DateTimeInterface|null,
 *   archivedByActorID: string|null,
 *   attributes: array<string,string>|null,
 *   createdAt: \DateTimeInterface,
 *   createdByActorID: string|null,
 *   description: string|null,
 *   issuerID: string,
 *   issuerName: string|null,
 *   match: BetaFederationRuleMatch|BetaFederationRuleMatchShape,
 *   name: string,
 *   oauthScope: string,
 *   target: BetaServiceAccountTarget|BetaServiceAccountTargetShape,
 *   tokenLifetimeSeconds: int,
 *   type: 'federation_rule',
 *   updatedAt: \DateTimeInterface,
 *   updatedByActorID: string|null,
 *   workspaceID: string|null,
 *   workspaceIDs: list<string>,
 * }
 */
final class BetaFederationRule implements BaseModel
{
    /** @use SdkModel<BetaFederationRuleShape> */
    use SdkModel;

    /** @var 'federation_rule' $type */
    #[Required]
    public string $type = 'federation_rule';

    /**
     * Tagged ID of the federation rule.
     */
    #[Required]
    public string $id;

    /**
     * When true, this rule is enabled for every workspace in the org (including ones created after the rule). `workspace_ids` is ignored at exchange time.
     */
    #[Required('applies_to_all_workspaces')]
    public bool $appliesToAllWorkspaces;

    /**
     * If set, this rule is archived and rejects token exchange.
     */
    #[Required('archived_at')]
    public ?\DateTimeInterface $archivedAt;

    /**
     * Tagged ID (`user_`/`svac_`) of the actor that archived this rule.
     */
    #[Required('archived_by_actor_id')]
    public ?string $archivedByActorID;

    /**
     * CEL expressions extracting named values from claims. Not yet supported; always null.
     *
     * @var array<string,string>|null $attributes
     */
    #[Required(map: 'string')]
    public ?array $attributes;

    /**
     * When this rule was created.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * Tagged ID (`user_`/`svac_`) of the actor that created this rule.
     */
    #[Required('created_by_actor_id')]
    public ?string $createdByActorID;

    /**
     * Optional free-text description.
     */
    #[Required]
    public ?string $description;

    /**
     * Tagged ID of the issuer whose tokens this rule accepts.
     */
    #[Required('issuer_id')]
    public string $issuerID;

    /**
     * Issuer's display name at read time.
     */
    #[Required('issuer_name')]
    public ?string $issuerName;

    /**
     * Conditions the verified JWT must satisfy for this rule to apply. All populated matcher fields must pass.
     */
    #[Required]
    public BetaFederationRuleMatch $match;

    /**
     * Admin-chosen slug identifier.
     */
    #[Required]
    public string $name;

    /**
     * Space-separated OAuth scopes granted on the minted token.
     */
    #[Required('oauth_scope')]
    public string $oauthScope;

    /**
     * Identity that tokens minted via this rule act as. Currently always a `service_account` target.
     */
    #[Required]
    public BetaServiceAccountTarget $target;

    /**
     * Lifetime in seconds of access tokens minted via this rule. Minted tokens are capped at `max(60, min(this value, 2 × remaining assertion validity))` seconds.
     */
    #[Required('token_lifetime_seconds')]
    public int $tokenLifetimeSeconds;

    /**
     * When this rule was last updated.
     */
    #[Required('updated_at')]
    public \DateTimeInterface $updatedAt;

    /**
     * Tagged ID (`user_`/`svac_`) of the actor that last updated this rule.
     */
    #[Required('updated_by_actor_id')]
    public ?string $updatedByActorID;

    /**
     * Legacy single-workspace binding. Prefer `workspace_ids` and the `/federation_rules/{federation_rule_id}/workspaces` sub-resource for managing workspace enablement.
     */
    #[Required('workspace_id')]
    public ?string $workspaceID;

    /**
     * Tagged IDs of the workspaces this rule is enabled for. May be empty for older rules that only carry the legacy `workspace_id` binding. Ignored at exchange time when `applies_to_all_workspaces` is true (the list may still be non-empty).
     *
     * @var list<string> $workspaceIDs
     */
    #[Required('workspace_ids', list: 'string')]
    public array $workspaceIDs;

    /**
     * `new BetaFederationRule()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaFederationRule::with(
     *   id: ...,
     *   appliesToAllWorkspaces: ...,
     *   archivedAt: ...,
     *   archivedByActorID: ...,
     *   attributes: ...,
     *   createdAt: ...,
     *   createdByActorID: ...,
     *   description: ...,
     *   issuerID: ...,
     *   issuerName: ...,
     *   match: ...,
     *   name: ...,
     *   oauthScope: ...,
     *   target: ...,
     *   tokenLifetimeSeconds: ...,
     *   updatedAt: ...,
     *   updatedByActorID: ...,
     *   workspaceID: ...,
     *   workspaceIDs: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaFederationRule)
     *   ->withID(...)
     *   ->withAppliesToAllWorkspaces(...)
     *   ->withArchivedAt(...)
     *   ->withArchivedByActorID(...)
     *   ->withAttributes(...)
     *   ->withCreatedAt(...)
     *   ->withCreatedByActorID(...)
     *   ->withDescription(...)
     *   ->withIssuerID(...)
     *   ->withIssuerName(...)
     *   ->withMatch(...)
     *   ->withName(...)
     *   ->withOAuthScope(...)
     *   ->withTarget(...)
     *   ->withTokenLifetimeSeconds(...)
     *   ->withUpdatedAt(...)
     *   ->withUpdatedByActorID(...)
     *   ->withWorkspaceID(...)
     *   ->withWorkspaceIDs(...)
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
     * @param array<string,string>|null $attributes
     * @param BetaFederationRuleMatch|BetaFederationRuleMatchShape $match
     * @param BetaServiceAccountTarget|BetaServiceAccountTargetShape $target
     * @param list<string> $workspaceIDs
     */
    public static function with(
        string $id,
        bool $appliesToAllWorkspaces,
        ?\DateTimeInterface $archivedAt,
        ?string $archivedByActorID,
        ?array $attributes,
        \DateTimeInterface $createdAt,
        ?string $createdByActorID,
        ?string $description,
        string $issuerID,
        ?string $issuerName,
        BetaFederationRuleMatch|array $match,
        string $name,
        string $oauthScope,
        BetaServiceAccountTarget|array $target,
        int $tokenLifetimeSeconds,
        \DateTimeInterface $updatedAt,
        ?string $updatedByActorID,
        ?string $workspaceID,
        array $workspaceIDs,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['appliesToAllWorkspaces'] = $appliesToAllWorkspaces;
        $self['archivedAt'] = $archivedAt;
        $self['archivedByActorID'] = $archivedByActorID;
        $self['attributes'] = $attributes;
        $self['createdAt'] = $createdAt;
        $self['createdByActorID'] = $createdByActorID;
        $self['description'] = $description;
        $self['issuerID'] = $issuerID;
        $self['issuerName'] = $issuerName;
        $self['match'] = $match;
        $self['name'] = $name;
        $self['oauthScope'] = $oauthScope;
        $self['target'] = $target;
        $self['tokenLifetimeSeconds'] = $tokenLifetimeSeconds;
        $self['updatedAt'] = $updatedAt;
        $self['updatedByActorID'] = $updatedByActorID;
        $self['workspaceID'] = $workspaceID;
        $self['workspaceIDs'] = $workspaceIDs;

        return $self;
    }

    /**
     * Tagged ID of the federation rule.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * When true, this rule is enabled for every workspace in the org (including ones created after the rule). `workspace_ids` is ignored at exchange time.
     */
    public function withAppliesToAllWorkspaces(
        bool $appliesToAllWorkspaces
    ): self {
        $self = clone $this;
        $self['appliesToAllWorkspaces'] = $appliesToAllWorkspaces;

        return $self;
    }

    /**
     * If set, this rule is archived and rejects token exchange.
     */
    public function withArchivedAt(?\DateTimeInterface $archivedAt): self
    {
        $self = clone $this;
        $self['archivedAt'] = $archivedAt;

        return $self;
    }

    /**
     * Tagged ID (`user_`/`svac_`) of the actor that archived this rule.
     */
    public function withArchivedByActorID(?string $archivedByActorID): self
    {
        $self = clone $this;
        $self['archivedByActorID'] = $archivedByActorID;

        return $self;
    }

    /**
     * CEL expressions extracting named values from claims. Not yet supported; always null.
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
     * When this rule was created.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Tagged ID (`user_`/`svac_`) of the actor that created this rule.
     */
    public function withCreatedByActorID(?string $createdByActorID): self
    {
        $self = clone $this;
        $self['createdByActorID'] = $createdByActorID;

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
     * Tagged ID of the issuer whose tokens this rule accepts.
     */
    public function withIssuerID(string $issuerID): self
    {
        $self = clone $this;
        $self['issuerID'] = $issuerID;

        return $self;
    }

    /**
     * Issuer's display name at read time.
     */
    public function withIssuerName(?string $issuerName): self
    {
        $self = clone $this;
        $self['issuerName'] = $issuerName;

        return $self;
    }

    /**
     * Conditions the verified JWT must satisfy for this rule to apply. All populated matcher fields must pass.
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
     * Admin-chosen slug identifier.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Space-separated OAuth scopes granted on the minted token.
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
     * Lifetime in seconds of access tokens minted via this rule. Minted tokens are capped at `max(60, min(this value, 2 × remaining assertion validity))` seconds.
     */
    public function withTokenLifetimeSeconds(int $tokenLifetimeSeconds): self
    {
        $self = clone $this;
        $self['tokenLifetimeSeconds'] = $tokenLifetimeSeconds;

        return $self;
    }

    /**
     * @param 'federation_rule' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * When this rule was last updated.
     */
    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * Tagged ID (`user_`/`svac_`) of the actor that last updated this rule.
     */
    public function withUpdatedByActorID(?string $updatedByActorID): self
    {
        $self = clone $this;
        $self['updatedByActorID'] = $updatedByActorID;

        return $self;
    }

    /**
     * Legacy single-workspace binding. Prefer `workspace_ids` and the `/federation_rules/{federation_rule_id}/workspaces` sub-resource for managing workspace enablement.
     */
    public function withWorkspaceID(?string $workspaceID): self
    {
        $self = clone $this;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * Tagged IDs of the workspaces this rule is enabled for. May be empty for older rules that only carry the legacy `workspace_id` binding. Ignored at exchange time when `applies_to_all_workspaces` is true (the list may still be non-empty).
     *
     * @param list<string> $workspaceIDs
     */
    public function withWorkspaceIDs(array $workspaceIDs): self
    {
        $self = clone $this;
        $self['workspaceIDs'] = $workspaceIDs;

        return $self;
    }
}
