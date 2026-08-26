<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Federation\Rules;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaFederationRuleWorkspaceShape = array{
 *   createdAt: \DateTimeInterface,
 *   createdByActorID: string|null,
 *   federationRuleID: string,
 *   type: 'federation_rule_workspace',
 *   workspaceID: string,
 *   workspaceName: string|null,
 * }
 */
final class BetaFederationRuleWorkspace implements BaseModel
{
    /** @use SdkModel<BetaFederationRuleWorkspaceShape> */
    use SdkModel;

    /** @var 'federation_rule_workspace' $type */
    #[Required]
    public string $type = 'federation_rule_workspace';

    /**
     * When this workspace was enabled for the rule.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * Tagged ID (`user_...` or `svac_...`) of the actor that enabled this workspace for the rule, if known.
     */
    #[Required('created_by_actor_id')]
    public ?string $createdByActorID;

    /**
     * Tagged ID of the federation rule.
     */
    #[Required('federation_rule_id')]
    public string $federationRuleID;

    /**
     * Tagged ID of the workspace this rule is enabled for.
     */
    #[Required('workspace_id')]
    public string $workspaceID;

    /**
     * Workspace display name. Populated when listing; null in the enable response.
     */
    #[Required('workspace_name')]
    public ?string $workspaceName;

    /**
     * `new BetaFederationRuleWorkspace()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaFederationRuleWorkspace::with(
     *   createdAt: ...,
     *   createdByActorID: ...,
     *   federationRuleID: ...,
     *   workspaceID: ...,
     *   workspaceName: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaFederationRuleWorkspace)
     *   ->withCreatedAt(...)
     *   ->withCreatedByActorID(...)
     *   ->withFederationRuleID(...)
     *   ->withWorkspaceID(...)
     *   ->withWorkspaceName(...)
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
     */
    public static function with(
        \DateTimeInterface $createdAt,
        ?string $createdByActorID,
        string $federationRuleID,
        string $workspaceID,
        ?string $workspaceName,
    ): self {
        $self = new self;

        $self['createdAt'] = $createdAt;
        $self['createdByActorID'] = $createdByActorID;
        $self['federationRuleID'] = $federationRuleID;
        $self['workspaceID'] = $workspaceID;
        $self['workspaceName'] = $workspaceName;

        return $self;
    }

    /**
     * When this workspace was enabled for the rule.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Tagged ID (`user_...` or `svac_...`) of the actor that enabled this workspace for the rule, if known.
     */
    public function withCreatedByActorID(?string $createdByActorID): self
    {
        $self = clone $this;
        $self['createdByActorID'] = $createdByActorID;

        return $self;
    }

    /**
     * Tagged ID of the federation rule.
     */
    public function withFederationRuleID(string $federationRuleID): self
    {
        $self = clone $this;
        $self['federationRuleID'] = $federationRuleID;

        return $self;
    }

    /**
     * @param 'federation_rule_workspace' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Tagged ID of the workspace this rule is enabled for.
     */
    public function withWorkspaceID(string $workspaceID): self
    {
        $self = clone $this;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * Workspace display name. Populated when listing; null in the enable response.
     */
    public function withWorkspaceName(?string $workspaceName): self
    {
        $self = clone $this;
        $self['workspaceName'] = $workspaceName;

        return $self;
    }
}
