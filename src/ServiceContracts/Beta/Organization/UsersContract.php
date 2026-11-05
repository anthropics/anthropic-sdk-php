<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization;

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
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Organization\ConcurrentMembershipChangeException;
use Anthropic\Organization\Users\CannotRemoveLastMemberException;
use Anthropic\Page;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface UsersContract
{
    /**
     * @api
     *
     * @param string $userID ID of the User.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $userID,
        RequestOptions|array|null $requestOptions = null
    ): OrganizationUser;

    /**
     * @api
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
    ): OrganizationUser;

    /**
     * @api
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
    ): Page;

    /**
     * @api
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
    ): UserRemoveResponse;

    /**
     * @api
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
    ): OrganizationUser;
}
