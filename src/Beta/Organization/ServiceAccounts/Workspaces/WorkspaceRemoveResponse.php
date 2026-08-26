<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ServiceAccounts\Workspaces;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type WorkspaceRemoveResponseShape = array{
 *   serviceAccountID: string,
 *   type: 'service_account_workspace_member_deleted',
 *   workspaceID: string,
 * }
 */
final class WorkspaceRemoveResponse implements BaseModel
{
    /** @use SdkModel<WorkspaceRemoveResponseShape> */
    use SdkModel;

    /** @var 'service_account_workspace_member_deleted' $type */
    #[Required]
    public string $type = 'service_account_workspace_member_deleted';

    /**
     * Tagged service account ID (`svac_...`) named in the delete request. Removal is idempotent; see the endpoint description for the implicit-membership no-op.
     */
    #[Required('service_account_id')]
    public string $serviceAccountID;

    /**
     * Tagged workspace ID (`wrkspc_...`) named in the delete request.
     */
    #[Required('workspace_id')]
    public string $workspaceID;

    /**
     * `new WorkspaceRemoveResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WorkspaceRemoveResponse::with(serviceAccountID: ..., workspaceID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WorkspaceRemoveResponse)->withServiceAccountID(...)->withWorkspaceID(...)
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
        string $serviceAccountID,
        string $workspaceID
    ): self {
        $self = new self;

        $self['serviceAccountID'] = $serviceAccountID;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * Tagged service account ID (`svac_...`) named in the delete request. Removal is idempotent; see the endpoint description for the implicit-membership no-op.
     */
    public function withServiceAccountID(string $serviceAccountID): self
    {
        $self = clone $this;
        $self['serviceAccountID'] = $serviceAccountID;

        return $self;
    }

    /**
     * @param 'service_account_workspace_member_deleted' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Tagged workspace ID (`wrkspc_...`) named in the delete request.
     */
    public function withWorkspaceID(string $workspaceID): self
    {
        $self = clone $this;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }
}
