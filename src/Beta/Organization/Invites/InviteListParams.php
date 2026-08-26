<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Invites;

use Anthropic\Beta\Organization\Invites\InviteListParams\Status;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List the organization's invites.
 *
 * @see Anthropic\Services\Beta\Organization\InvitesService::list()
 *
 * @phpstan-type InviteListParamsShape = array{
 *   afterID?: string|null,
 *   beforeID?: string|null,
 *   email?: string|null,
 *   limit?: int|null,
 *   roles?: list<string>|null,
 *   statuses?: list<Status|value-of<Status>>|null,
 * }
 */
final class InviteListParams implements BaseModel
{
    /** @use SdkModel<InviteListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately after this object.
     */
    #[Optional]
    public ?string $afterID;

    /**
     * ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately before this object.
     */
    #[Optional]
    public ?string $beforeID;

    /**
     * Filter by the email address the Invite was sent to. Matches the same way as the Users list's `email` filter (normalized, case-insensitive).
     */
    #[Optional]
    public ?string $email;

    /**
     * Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Filter to items whose `role` equals one of the supplied values. Repeatable; values are OR'ed together.
     *
     * Accepted values depend on the organization type: Console and API organizations accept `user`, `developer`, `billing`, `admin`, and `claude_code_user`; Claude Enterprise organizations accept `user`, `owner`, `primary_owner`, `membership_admin`, and `managed`.
     *
     * @var list<string>|null $roles
     */
    #[Optional(list: 'string')]
    public ?array $roles;

    /**
     * Filter by Invite status. Repeatable; values are OR'ed together. Omit to return `pending`, `accepted`, and `expired` Invites alike.
     *
     * @var list<value-of<Status>>|null $statuses
     */
    #[Optional(list: Status::class)]
    public ?array $statuses;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string>|null $roles
     * @param list<Status|value-of<Status>>|null $statuses
     */
    public static function with(
        ?string $afterID = null,
        ?string $beforeID = null,
        ?string $email = null,
        ?int $limit = null,
        ?array $roles = null,
        ?array $statuses = null,
    ): self {
        $self = new self;

        null !== $afterID && $self['afterID'] = $afterID;
        null !== $beforeID && $self['beforeID'] = $beforeID;
        null !== $email && $self['email'] = $email;
        null !== $limit && $self['limit'] = $limit;
        null !== $roles && $self['roles'] = $roles;
        null !== $statuses && $self['statuses'] = $statuses;

        return $self;
    }

    /**
     * ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately after this object.
     */
    public function withAfterID(string $afterID): self
    {
        $self = clone $this;
        $self['afterID'] = $afterID;

        return $self;
    }

    /**
     * ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately before this object.
     */
    public function withBeforeID(string $beforeID): self
    {
        $self = clone $this;
        $self['beforeID'] = $beforeID;

        return $self;
    }

    /**
     * Filter by the email address the Invite was sent to. Matches the same way as the Users list's `email` filter (normalized, case-insensitive).
     */
    public function withEmail(string $email): self
    {
        $self = clone $this;
        $self['email'] = $email;

        return $self;
    }

    /**
     * Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Filter to items whose `role` equals one of the supplied values. Repeatable; values are OR'ed together.
     *
     * Accepted values depend on the organization type: Console and API organizations accept `user`, `developer`, `billing`, `admin`, and `claude_code_user`; Claude Enterprise organizations accept `user`, `owner`, `primary_owner`, `membership_admin`, and `managed`.
     *
     * @param list<string> $roles
     */
    public function withRoles(array $roles): self
    {
        $self = clone $this;
        $self['roles'] = $roles;

        return $self;
    }

    /**
     * Filter by Invite status. Repeatable; values are OR'ed together. Omit to return `pending`, `accepted`, and `expired` Invites alike.
     *
     * @param list<Status|value-of<Status>> $statuses
     */
    public function withStatuses(array $statuses): self
    {
        $self = clone $this;
        $self['statuses'] = $statuses;

        return $self;
    }
}
