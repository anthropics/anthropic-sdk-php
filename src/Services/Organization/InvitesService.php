<?php

declare(strict_types=1);

namespace Anthropic\Services\Organization;

use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\Organization\Invites\AlreadyMemberException;
use Anthropic\Organization\Invites\CannotInviteEmailsWithUnverifiedDomainsException;
use Anthropic\Organization\Invites\EmailDomainNotAllowedException;
use Anthropic\Organization\Invites\InviteAlreadyExistsException;
use Anthropic\Organization\Invites\InviteCreateParams\Role;
use Anthropic\Organization\Invites\InviteDeleteResponse;
use Anthropic\Organization\Invites\InviteListParams\Status;
use Anthropic\Organization\Invites\OrganizationInvite;
use Anthropic\Organization\OrgMemberLimitExceededException;
use Anthropic\Organization\RBACGroups\RBACGroupGrantsOwnerAccessException;
use Anthropic\Organization\RBACGroups\RBACGroupOwnerAccessUnconfirmedException;
use Anthropic\Page;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Organization\InvitesContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class InvitesService implements InvitesContract
{
    /**
     * @api
     */
    public InvitesRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new InvitesRawService($client);
    }

    /**
     * @api
     *
     * Invite a user to join the organization by email.
     *
     * On plans that draw members from a finite pool of purchased seats, the invite automatically consumes a seat from the lowest tier with availability; there is no seat-tier parameter. When no seat is free the request fails with a 400 error rather than purchasing a seat.
     *
     * @param string $email Email of the User.
     * @param Role|value-of<Role> $role Role for the invited User.
     *
     * The accepted values depend on the organization type. Console and API organizations accept `user`, `developer`, `billing`, and `claude_code_user`; `admin` cannot be assigned through the API. Claude Enterprise organizations accept `user` and `managed`; inviting with the `managed` role requires the `write:rbac_groups` scope in addition to `write:members`.
     * @param list<string> $rbacGroupIDs RBAC group IDs to assign to the User when the Invite is accepted. A non-empty array is accepted only for a Claude Enterprise organization with RBAC groups, and requires the key to carry the `write:rbac_groups` scope.
     * @param RequestOpts|null $requestOptions
     *
     * @throws AlreadyMemberException The email address already belongs to a user in the organization. The message names the user.
     * @throws CannotInviteEmailsWithUnverifiedDomainsException The email address's domain is not one of the verified domains of the organization's parent organization.
     * @throws EmailDomainNotAllowedException The organization restricts invites to an allowed list of email domains, and the list is empty or does not include the email address's domain.
     * @throws InviteAlreadyExistsException A pending invite already exists for the email address. The message names the invite.
     * @throws OrgMemberLimitExceededException The organization has reached the member limit that Anthropic set for it. Pending invites count toward the limit.
     * @throws RBACGroupGrantsOwnerAccessException A role attached to an RBAC Group in the request grants owner access, so this API does not add members to that group (directly or through an invite), remove its members, or delete it. Make the change in the organization's admin settings in Claude.
     * @throws RBACGroupOwnerAccessUnconfirmedException The API could not finish checking whether an RBAC Group in the request grants owner access, so it made no change. Retrying the same request will not help. Make the change in the organization's admin settings in Claude.
     * @throws APIException
     */
    public function create(
        string $email,
        Role|string $role,
        ?array $rbacGroupIDs = null,
        RequestOptions|array|null $requestOptions = null,
    ): OrganizationInvite {
        $params = Util::removeNulls(
            ['email' => $email, 'role' => $role, 'rbacGroupIDs' => $rbacGroupIDs]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Retrieve an invite by ID.
     *
     * @param string $inviteID ID of the Invite.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $inviteID,
        RequestOptions|array|null $requestOptions = null
    ): OrganizationInvite {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($inviteID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List the organization's invites.
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
    ): Page {
        $params = Util::removeNulls(
            [
                'afterID' => $afterID,
                'beforeID' => $beforeID,
                'email' => $email,
                'limit' => $limit,
                'roles' => $roles,
                'statuses' => $statuses,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Delete a pending invite.
     *
     * @param string $inviteID ID of the Invite.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $inviteID,
        RequestOptions|array|null $requestOptions = null
    ): InviteDeleteResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($inviteID, requestOptions: $requestOptions);

        return $response->parse();
    }
}
