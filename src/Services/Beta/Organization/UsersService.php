<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\BetaOrganizationNotEnrolledInBetaException;
use Anthropic\Beta\Organization\Users\CannotSignOutManagedMemberException;
use Anthropic\Beta\Organization\Users\CannotSignOutMembershipAdminException;
use Anthropic\Beta\Organization\Users\CannotSignOutOwnerException;
use Anthropic\Beta\Organization\Users\CannotSignOutPrimaryOwnerException;
use Anthropic\Beta\Organization\Users\CannotSignOutPrivilegedMemberException;
use Anthropic\Beta\Organization\Users\CannotSignOutSelfException;
use Anthropic\Beta\Organization\Users\OrganizationUser;
use Anthropic\Beta\Organization\Users\UserRemoveResponse;
use Anthropic\Beta\Organization\Users\UserUpdateParams\Role;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\Organization\ConcurrentMembershipChangeException;
use Anthropic\Organization\Users\CannotRemoveLastMemberException;
use Anthropic\Page;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\UsersContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class UsersService implements UsersContract
{
    /**
     * @api
     */
    public UsersRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new UsersRawService($client);
    }

    /**
     * @api
     *
     * Retrieve a member of the organization by user ID.
     *
     * @param string $userID ID of the User.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $userID,
        RequestOptions|array|null $requestOptions = null
    ): OrganizationUser {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($userID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Update a member's organization role.
     *
     * @param string $userID ID of the User.
     * @param Role|value-of<Role> $role New role for the User.
     *
     * The accepted values depend on the organization type. Console and API organizations accept `user`, `developer`, `billing`, and `claude_code_user`; `admin` cannot be assigned through the API. Claude Enterprise organizations accept `user` and `managed`; changing a User's role to `managed` requires the `write:rbac_groups` scope in addition to `write:members`.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $userID,
        Role|string $role,
        RequestOptions|array|null $requestOptions = null,
    ): OrganizationUser {
        $params = Util::removeNulls(['role' => $role]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($userID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List the organization's members.
     *
     * @param string $afterID ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately after this object.
     * @param string $beforeID ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately before this object.
     * @param string $email Filter by user email.
     * @param int $limit Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     * @param list<string> $roles Filter to items whose `role` equals one of the supplied values. Repeatable; values are OR'ed together.
     *
     * Accepted values depend on the organization type: Console and API organizations accept `user`, `developer`, `billing`, `admin`, and `claude_code_user`; Claude Enterprise organizations accept `user`, `owner`, `primary_owner`, `membership_admin`, and `managed`.
     * @param RequestOpts|null $requestOptions
     *
     * @return Page<OrganizationUser>
     *
     * @throws APIException
     */
    public function list(
        ?string $afterID = null,
        ?string $beforeID = null,
        ?string $email = null,
        ?int $limit = null,
        ?array $roles = null,
        RequestOptions|array|null $requestOptions = null,
    ): Page {
        $params = Util::removeNulls(
            [
                'afterID' => $afterID,
                'beforeID' => $beforeID,
                'email' => $email,
                'limit' => $limit,
                'roles' => $roles,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Remove a member from the organization.
     *
     * @param string $userID ID of the User.
     * @param RequestOpts|null $requestOptions
     *
     * @throws CannotRemoveLastMemberException
     * @throws ConcurrentMembershipChangeException
     * @throws APIException
     */
    public function remove(
        string $userID,
        RequestOptions|array|null $requestOptions = null
    ): UserRemoveResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->remove($userID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Sign a member out of Claude everywhere, without removing them from the organization. This ends their sign-in sessions and removes their trusted devices wherever they use Claude, including other organizations and individual plans. It also ends the OAuth tokens issued to them for this organization, so apps such as Claude Code must sign in again.
     *
     * A token can take up to an hour to stop working, though it almost always stops at once. The member keeps their role and can sign in again right away. To keep them out, remove them from the organization or, if your organization uses single sign-on, block them in your identity provider. Signing out does not end API keys, OAuth tokens that were not issued for this organization, or the member's Claude Code cloud sessions and routines.
     *
     * You cannot sign out the organization's primary owner or the person your API key or token acts for, and a request to sign out another owner, a member with owner permissions, or a membership admin may be refused. A refused request returns a `400` or `403` error that says why. If the request returns `503`, send it again to finish; anything already ended stays ended.
     *
     * Every request must include the beta header `anthropic-beta: admin-user-sign-out-2026-10-08`. A request without it returns `400`. Sign-out is in beta. Anthropic turns it on for each organization and has turned it on for every Claude Enterprise organization; until yours is on, requests also return `400`. In a Claude Enterprise organization, an API key needs the `write:members` scope; a key without it gets `403`.
     *
     * @param string $userID ID of the User.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas This endpoint is in beta: requests must send `admin-user-sign-out-2026-10-08` in this header.
     * @param RequestOpts|null $requestOptions
     *
     * @throws CannotSignOutPrimaryOwnerException
     * @throws CannotSignOutSelfException
     * @throws BetaOrganizationNotEnrolledInBetaException
     * @throws CannotSignOutManagedMemberException
     * @throws CannotSignOutMembershipAdminException
     * @throws CannotSignOutOwnerException
     * @throws CannotSignOutPrivilegedMemberException
     * @throws APIException
     */
    public function signOut(
        string $userID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): OrganizationUser {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->signOut($userID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
