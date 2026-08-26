<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Invites;

use Anthropic\Beta\Organization\Invites\InviteCreateParams\Role;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Invite a user to join the organization by email.
 *
 * On plans that draw members from a finite pool of purchased seats, the invite automatically consumes a seat from the lowest tier with availability; there is no seat-tier parameter. When no seat is free the request fails with a 400 error rather than purchasing a seat.
 *
 * @see Anthropic\Services\Beta\Organization\InvitesService::create()
 *
 * @phpstan-type InviteCreateParamsShape = array{
 *   email: string, role: Role|value-of<Role>, rbacGroupIDs?: list<string>|null
 * }
 */
final class InviteCreateParams implements BaseModel
{
    /** @use SdkModel<InviteCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Email of the User.
     */
    #[Required]
    public string $email;

    /**
     * Role for the invited User.
     *
     * The accepted values depend on the organization type. Console and API organizations accept `user`, `developer`, `billing`, and `claude_code_user`; `admin` cannot be assigned through the API. Claude Enterprise organizations accept `user` and `managed`.
     *
     * @var value-of<Role> $role
     */
    #[Required(enum: Role::class)]
    public string $role;

    /**
     * RBAC group IDs to assign to the User when the Invite is accepted. A non-empty array is accepted only for a Claude Enterprise organization with RBAC groups, and requires the key to carry the `write:rbac_groups` scope.
     *
     * @var list<string>|null $rbacGroupIDs
     */
    #[Optional('rbac_group_ids', list: 'string')]
    public ?array $rbacGroupIDs;

    /**
     * `new InviteCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * InviteCreateParams::with(email: ..., role: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new InviteCreateParams)->withEmail(...)->withRole(...)
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
     * @param Role|value-of<Role> $role
     * @param list<string>|null $rbacGroupIDs
     */
    public static function with(
        string $email,
        Role|string $role,
        ?array $rbacGroupIDs = null
    ): self {
        $self = new self;

        $self['email'] = $email;
        $self['role'] = $role;

        null !== $rbacGroupIDs && $self['rbacGroupIDs'] = $rbacGroupIDs;

        return $self;
    }

    /**
     * Email of the User.
     */
    public function withEmail(string $email): self
    {
        $self = clone $this;
        $self['email'] = $email;

        return $self;
    }

    /**
     * Role for the invited User.
     *
     * The accepted values depend on the organization type. Console and API organizations accept `user`, `developer`, `billing`, and `claude_code_user`; `admin` cannot be assigned through the API. Claude Enterprise organizations accept `user` and `managed`.
     *
     * @param Role|value-of<Role> $role
     */
    public function withRole(Role|string $role): self
    {
        $self = clone $this;
        $self['role'] = $role;

        return $self;
    }

    /**
     * RBAC group IDs to assign to the User when the Invite is accepted. A non-empty array is accepted only for a Claude Enterprise organization with RBAC groups, and requires the key to carry the `write:rbac_groups` scope.
     *
     * @param list<string> $rbacGroupIDs
     */
    public function withRBACGroupIDs(array $rbacGroupIDs): self
    {
        $self = clone $this;
        $self['rbacGroupIDs'] = $rbacGroupIDs;

        return $self;
    }
}
