<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Federation\Rules\Workspaces;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type WorkspaceRemoveResponseShape = array{
 *   federationRuleID: string,
 *   type: 'federation_rule_workspace_deleted',
 *   workspaceID: string,
 * }
 */
final class WorkspaceRemoveResponse implements BaseModel
{
    /** @use SdkModel<WorkspaceRemoveResponseShape> */
    use SdkModel;

    /** @var 'federation_rule_workspace_deleted' $type */
    #[Required]
    public string $type = 'federation_rule_workspace_deleted';

    /**
     * Tagged ID of the federation rule.
     */
    #[Required('federation_rule_id')]
    public string $federationRuleID;

    /**
     * Tagged ID of the workspace named in the delete request. Removal is idempotent.
     */
    #[Required('workspace_id')]
    public string $workspaceID;

    /**
     * `new WorkspaceRemoveResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WorkspaceRemoveResponse::with(federationRuleID: ..., workspaceID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WorkspaceRemoveResponse)->withFederationRuleID(...)->withWorkspaceID(...)
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
        string $federationRuleID,
        string $workspaceID
    ): self {
        $self = new self;

        $self['federationRuleID'] = $federationRuleID;
        $self['workspaceID'] = $workspaceID;

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
     * @param 'federation_rule_workspace_deleted' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Tagged ID of the workspace named in the delete request. Removal is idempotent.
     */
    public function withWorkspaceID(string $workspaceID): self
    {
        $self = clone $this;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }
}
