<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization;

use Anthropic\Beta\Organization\Invites\InviteCreateParams\Role;
use Anthropic\Beta\Organization\Invites\InviteDeleteResponse;
use Anthropic\Beta\Organization\Invites\InviteListParams\Status;
use Anthropic\Beta\Organization\Invites\OrganizationInvite;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Page;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface InvitesContract
{
    /**
     * @api
     *
     * @param string $email email of the User
     * @param Role|value-of<Role> $role Role for the invited User.
     *
     * The accepted values depend on the organization type. Console and API organizations accept `user`, `developer`, `billing`, and `claude_code_user`; `admin` cannot be assigned through the API. Claude Enterprise organizations accept `user` and `managed`.
     * @param list<string> $rbacGroupIDs RBAC group IDs to assign to the User when the Invite is accepted. A non-empty array is accepted only for a Claude Enterprise organization with RBAC groups, and requires the key to carry the `write:rbac_groups` scope.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $email,
        Role|string $role,
        ?array $rbacGroupIDs = null,
        RequestOptions|array|null $requestOptions = null,
    ): OrganizationInvite;

    /**
     * @api
     *
     * @param string $inviteID ID of the Invite
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $inviteID,
        RequestOptions|array|null $requestOptions = null
    ): OrganizationInvite;

    /**
     * @api
     *
     * @param string $afterID ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately after this object.
     * @param string $beforeID ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately before this object.
     * @param string $email Filter by the email address the Invite was sent to. Matches the same way as the Users list's `email` filter (normalized, case-insensitive).
     * @param int $limit Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     * @param list<string> $roles Filter to items whose `role` equals one of the supplied values. Repeatable; values are OR'ed together.
     *
     * Accepted values depend on the organization type: Console and API organizations accept `user`, `developer`, `billing`, `admin`, and `claude_code_user`; Claude Enterprise organizations accept `user`, `owner`, `primary_owner`, `membership_admin`, and `managed`.
     * @param list<Status|value-of<Status>> $statuses Filter by Invite status. Repeatable; values are OR'ed together. Omit to return `pending`, `accepted`, and `expired` Invites alike.
     * @param RequestOpts|null $requestOptions
     *
     * @return Page<OrganizationInvite>
     *
     * @throws APIException
     */
    public function list(
        ?string $afterID = null,
        ?string $beforeID = null,
        ?string $email = null,
        ?int $limit = null,
        ?array $roles = null,
        ?array $statuses = null,
        RequestOptions|array|null $requestOptions = null,
    ): Page;

    /**
     * @api
     *
     * @param string $inviteID ID of the Invite
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $inviteID,
        RequestOptions|array|null $requestOptions = null
    ): InviteDeleteResponse;
}
