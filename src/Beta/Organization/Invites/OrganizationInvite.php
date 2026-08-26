<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Invites;

use Anthropic\Beta\Organization\BetaOrganizationRole;
use Anthropic\Beta\Organization\Invites\OrganizationInvite\Status;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type OrganizationInviteShape = array{
 *   id: string,
 *   acceptedAt: \DateTimeInterface|null,
 *   email: string,
 *   expiresAt: \DateTimeInterface,
 *   invitedAt: \DateTimeInterface,
 *   rbacGroupIDs: list<string>,
 *   role: BetaOrganizationRole|value-of<BetaOrganizationRole>,
 *   status: Status|value-of<Status>,
 *   type: 'invite',
 * }
 */
final class OrganizationInvite implements BaseModel
{
    /** @use SdkModel<OrganizationInviteShape> */
    use SdkModel;

    /**
     * Object type.
     *
     * For Invites, this is always `"invite"`.
     *
     * @var 'invite' $type
     */
    #[Required]
    public string $type = 'invite';

    /**
     * ID of the Invite.
     */
    #[Required]
    public string $id;

    /**
     * RFC 3339 datetime string indicating when the Invite was accepted, or null.
     */
    #[Required('accepted_at')]
    public ?\DateTimeInterface $acceptedAt;

    /**
     * Email of the User being invited.
     */
    #[Required]
    public string $email;

    /**
     * RFC 3339 datetime string indicating when the Invite expires.
     */
    #[Required('expires_at')]
    public \DateTimeInterface $expiresAt;

    /**
     * RFC 3339 datetime string indicating when the Invite was created.
     */
    #[Required('invited_at')]
    public \DateTimeInterface $invitedAt;

    /**
     * RBAC group IDs recorded on the Invite (Claude Enterprise organizations), to be assigned to the User when the Invite is accepted. `[]` when none.
     *
     * @var list<string> $rbacGroupIDs
     */
    #[Required('rbac_group_ids', list: 'string')]
    public array $rbacGroupIDs;

    /**
     * Organization role of the User.
     *
     * @var value-of<BetaOrganizationRole> $role
     */
    #[Required(enum: BetaOrganizationRole::class)]
    public string $role;

    /**
     * Status of the Invite.
     *
     * @var value-of<Status> $status
     */
    #[Required(enum: Status::class)]
    public string $status;

    /**
     * `new OrganizationInvite()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * OrganizationInvite::with(
     *   id: ...,
     *   acceptedAt: ...,
     *   email: ...,
     *   expiresAt: ...,
     *   invitedAt: ...,
     *   rbacGroupIDs: ...,
     *   role: ...,
     *   status: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new OrganizationInvite)
     *   ->withID(...)
     *   ->withAcceptedAt(...)
     *   ->withEmail(...)
     *   ->withExpiresAt(...)
     *   ->withInvitedAt(...)
     *   ->withRBACGroupIDs(...)
     *   ->withRole(...)
     *   ->withStatus(...)
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
     * @param list<string> $rbacGroupIDs
     * @param BetaOrganizationRole|value-of<BetaOrganizationRole> $role
     * @param Status|value-of<Status> $status
     */
    public static function with(
        string $id,
        ?\DateTimeInterface $acceptedAt,
        string $email,
        \DateTimeInterface $expiresAt,
        \DateTimeInterface $invitedAt,
        array $rbacGroupIDs,
        BetaOrganizationRole|string $role,
        Status|string $status,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['acceptedAt'] = $acceptedAt;
        $self['email'] = $email;
        $self['expiresAt'] = $expiresAt;
        $self['invitedAt'] = $invitedAt;
        $self['rbacGroupIDs'] = $rbacGroupIDs;
        $self['role'] = $role;
        $self['status'] = $status;

        return $self;
    }

    /**
     * ID of the Invite.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * RFC 3339 datetime string indicating when the Invite was accepted, or null.
     */
    public function withAcceptedAt(?\DateTimeInterface $acceptedAt): self
    {
        $self = clone $this;
        $self['acceptedAt'] = $acceptedAt;

        return $self;
    }

    /**
     * Email of the User being invited.
     */
    public function withEmail(string $email): self
    {
        $self = clone $this;
        $self['email'] = $email;

        return $self;
    }

    /**
     * RFC 3339 datetime string indicating when the Invite expires.
     */
    public function withExpiresAt(\DateTimeInterface $expiresAt): self
    {
        $self = clone $this;
        $self['expiresAt'] = $expiresAt;

        return $self;
    }

    /**
     * RFC 3339 datetime string indicating when the Invite was created.
     */
    public function withInvitedAt(\DateTimeInterface $invitedAt): self
    {
        $self = clone $this;
        $self['invitedAt'] = $invitedAt;

        return $self;
    }

    /**
     * RBAC group IDs recorded on the Invite (Claude Enterprise organizations), to be assigned to the User when the Invite is accepted. `[]` when none.
     *
     * @param list<string> $rbacGroupIDs
     */
    public function withRBACGroupIDs(array $rbacGroupIDs): self
    {
        $self = clone $this;
        $self['rbacGroupIDs'] = $rbacGroupIDs;

        return $self;
    }

    /**
     * Organization role of the User.
     *
     * @param BetaOrganizationRole|value-of<BetaOrganizationRole> $role
     */
    public function withRole(BetaOrganizationRole|string $role): self
    {
        $self = clone $this;
        $self['role'] = $role;

        return $self;
    }

    /**
     * Status of the Invite.
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
     * For Invites, this is always `"invite"`.
     *
     * @param 'invite' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
