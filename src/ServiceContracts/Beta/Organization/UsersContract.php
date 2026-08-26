<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization;

use Anthropic\Beta\Organization\Users\OrganizationUser;
use Anthropic\Beta\Organization\Users\UserRemoveResponse;
use Anthropic\Beta\Organization\Users\UserUpdateParams\Role;
use Anthropic\Core\Exceptions\APIException;
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
     * @param string $userID ID of the User
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
     * @param string $userID ID of the User
     * @param Role|value-of<Role> $role New role for the User.
     *
     * The accepted values depend on the organization type. Console and API organizations accept `user`, `developer`, `billing`, and `claude_code_user`; `admin` cannot be assigned through the API. Claude Enterprise organizations accept `user` and `managed`.
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
     * @param string $email filter by user email
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
     * @param string $userID ID of the User
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function remove(
        string $userID,
        RequestOptions|array|null $requestOptions = null
    ): UserRemoveResponse;
}
