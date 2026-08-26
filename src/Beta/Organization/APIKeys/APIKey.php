<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\APIKeys;

use Anthropic\Beta\Organization\APIKeys\APIKey\Principal;
use Anthropic\Beta\Organization\APIKeys\APIKey\Scope;
use Anthropic\Beta\Organization\APIKeys\APIKey\Status;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type PrincipalVariants from \Anthropic\Beta\Organization\APIKeys\APIKey\Principal
 * @phpstan-import-type ScopeVariants from \Anthropic\Beta\Organization\APIKeys\APIKey\Scope
 * @phpstan-import-type APIKeyCreatedByShape from \Anthropic\Beta\Organization\APIKeys\APIKeyCreatedBy
 * @phpstan-import-type PrincipalShape from \Anthropic\Beta\Organization\APIKeys\APIKey\Principal
 * @phpstan-import-type ScopeShape from \Anthropic\Beta\Organization\APIKeys\APIKey\Scope
 *
 * @phpstan-type APIKeyShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   createdBy: null|APIKeyCreatedBy|APIKeyCreatedByShape,
 *   expiresAt: \DateTimeInterface|null,
 *   name: string,
 *   partialKeyHint: string|null,
 *   principal: PrincipalShape|null,
 *   scope: ScopeShape,
 *   status: Status|value-of<Status>,
 *   type: 'api_key',
 *   workspaceID: string|null,
 * }
 */
final class APIKey implements BaseModel
{
    /** @use SdkModel<APIKeyShape> */
    use SdkModel;

    /**
     * Object type.
     *
     * For API Keys, this is always `"api_key"`.
     *
     * @var 'api_key' $type
     */
    #[Required]
    public string $type = 'api_key';

    /**
     * ID of the API key.
     */
    #[Required]
    public string $id;

    /**
     * RFC 3339 datetime string indicating when the API Key was created.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * The ID and type of the actor that created the API key, or `null` when the
     * creator is not recorded (legacy, workload-identity-federated, or
     * system-created keys).
     */
    #[Required('created_by')]
    public ?APIKeyCreatedBy $createdBy;

    /**
     * RFC 3339 datetime string indicating when the API Key expires, or `null` if it never expires.
     */
    #[Required('expires_at')]
    public ?\DateTimeInterface $expiresAt;

    /**
     * Name of the API key.
     */
    #[Required]
    public string $name;

    /**
     * Partially redacted hint for the API key.
     */
    #[Required('partial_key_hint')]
    public ?string $partialKeyHint;

    /**
     * The principal the API key acts as (a User or a Service Account), or `null` if the API key is not bound to a principal.
     *
     * @var PrincipalVariants|null $principal
     */
    #[Required(union: Principal::class)]
    public APIKeyUserActor|APIKeyServiceAccountActor|null $principal;

    /**
     * Where the API key belongs: its Workspace (`{"type": "workspace", "workspace_id": "wrkspc_..."}`, with the Workspace's real ID even when it is the organization's default Workspace), or the organization (`{"type": "organization"}`) for a principal-bound API key that has no Workspace.
     *
     * @var ScopeVariants $scope
     */
    #[Required(union: Scope::class)]
    public APIKeyOrganizationScope|APIKeyWorkspaceScope $scope;

    /**
     * Status of the API key.
     *
     * @var value-of<Status> $status
     */
    #[Required(enum: Status::class)]
    public string $status;

    /**
     * @deprecated Use `scope` instead. `workspace_id` is `null` both for an API key in the default Workspace and for a principal-bound API key that has no Workspace.
     *
     * Deprecated: use `scope` instead. ID of the Workspace associated with the API key, or `null` if the API key belongs to the default Workspace. Also `null` for a principal-bound API key that has no Workspace; `scope` tells the two apart.
     */
    #[Required('workspace_id')]
    public ?string $workspaceID;

    /**
     * `new APIKey()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * APIKey::with(
     *   id: ...,
     *   createdAt: ...,
     *   createdBy: ...,
     *   expiresAt: ...,
     *   name: ...,
     *   partialKeyHint: ...,
     *   principal: ...,
     *   scope: ...,
     *   status: ...,
     *   workspaceID: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new APIKey)
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withCreatedBy(...)
     *   ->withExpiresAt(...)
     *   ->withName(...)
     *   ->withPartialKeyHint(...)
     *   ->withPrincipal(...)
     *   ->withScope(...)
     *   ->withStatus(...)
     *   ->withWorkspaceID(...)
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
     * @param APIKeyCreatedBy|APIKeyCreatedByShape|null $createdBy
     * @param PrincipalShape|null $principal
     * @param ScopeShape $scope
     * @param Status|value-of<Status> $status
     */
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        APIKeyCreatedBy|array|null $createdBy,
        ?\DateTimeInterface $expiresAt,
        string $name,
        ?string $partialKeyHint,
        APIKeyUserActor|array|APIKeyServiceAccountActor|null $principal,
        APIKeyOrganizationScope|array|APIKeyWorkspaceScope $scope,
        Status|string $status,
        ?string $workspaceID,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['createdBy'] = $createdBy;
        $self['expiresAt'] = $expiresAt;
        $self['name'] = $name;
        $self['partialKeyHint'] = $partialKeyHint;
        $self['principal'] = $principal;
        $self['scope'] = $scope;
        $self['status'] = $status;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * ID of the API key.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * RFC 3339 datetime string indicating when the API Key was created.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * The ID and type of the actor that created the API key, or `null` when the
     * creator is not recorded (legacy, workload-identity-federated, or
     * system-created keys).
     *
     * @param APIKeyCreatedBy|APIKeyCreatedByShape|null $createdBy
     */
    public function withCreatedBy(APIKeyCreatedBy|array|null $createdBy): self
    {
        $self = clone $this;
        $self['createdBy'] = $createdBy;

        return $self;
    }

    /**
     * RFC 3339 datetime string indicating when the API Key expires, or `null` if it never expires.
     */
    public function withExpiresAt(?\DateTimeInterface $expiresAt): self
    {
        $self = clone $this;
        $self['expiresAt'] = $expiresAt;

        return $self;
    }

    /**
     * Name of the API key.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Partially redacted hint for the API key.
     */
    public function withPartialKeyHint(?string $partialKeyHint): self
    {
        $self = clone $this;
        $self['partialKeyHint'] = $partialKeyHint;

        return $self;
    }

    /**
     * The principal the API key acts as (a User or a Service Account), or `null` if the API key is not bound to a principal.
     *
     * @param PrincipalShape|null $principal
     */
    public function withPrincipal(
        APIKeyUserActor|array|APIKeyServiceAccountActor|null $principal
    ): self {
        $self = clone $this;
        $self['principal'] = $principal;

        return $self;
    }

    /**
     * Where the API key belongs: its Workspace (`{"type": "workspace", "workspace_id": "wrkspc_..."}`, with the Workspace's real ID even when it is the organization's default Workspace), or the organization (`{"type": "organization"}`) for a principal-bound API key that has no Workspace.
     *
     * @param ScopeShape $scope
     */
    public function withScope(
        APIKeyOrganizationScope|array|APIKeyWorkspaceScope $scope
    ): self {
        $self = clone $this;
        $self['scope'] = $scope;

        return $self;
    }

    /**
     * Status of the API key.
     *
     * @param Status|value-of<Status> $status
     */
    public function withStatus(Status|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * Object type.
     *
     * For API Keys, this is always `"api_key"`.
     *
     * @param 'api_key' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Deprecated: use `scope` instead. ID of the Workspace associated with the API key, or `null` if the API key belongs to the default Workspace. Also `null` for a principal-bound API key that has no Workspace; `scope` tells the two apart.
     */
    public function withWorkspaceID(?string $workspaceID): self
    {
        $self = clone $this;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }
}
