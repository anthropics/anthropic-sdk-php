<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization;

use Anthropic\Beta\Organization\Users\OrganizationUser;
use Anthropic\Beta\Organization\Users\UserListParams;
use Anthropic\Beta\Organization\Users\UserRemoveResponse;
use Anthropic\Beta\Organization\Users\UserUpdateParams;
use Anthropic\Beta\Organization\Users\UserUpdateParams\Role;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\Page;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\UsersRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class UsersRawService implements UsersRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Retrieve a member of the organization by user ID.
     *
     * @param string $userID ID of the User
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<OrganizationUser>
     *
     * @throws APIException
     */
    public function retrieve(
        string $userID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/organizations/users/%1$s?beta=true', $userID],
            options: $requestOptions,
            convert: OrganizationUser::class,
        );
    }

    /**
     * @api
     *
     * Update a member's organization role.
     *
     * @param string $userID ID of the User
     * @param array{role: Role|value-of<Role>}|UserUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<OrganizationUser>
     *
     * @throws APIException
     */
    public function update(
        string $userID,
        array|UserUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = UserUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/organizations/users/%1$s?beta=true', $userID],
            body: (object) $parsed,
            options: $options,
            convert: OrganizationUser::class,
        );
    }

    /**
     * @api
     *
     * List the organization's members.
     *
     * @param array{
     *   afterID?: string,
     *   beforeID?: string,
     *   email?: string,
     *   limit?: int,
     *   roles?: list<string>,
     * }|UserListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Page<OrganizationUser>>
     *
     * @throws APIException
     */
    public function list(
        array|UserListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = UserListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/organizations/users?beta=true',
            query: Util::array_transform_keys(
                $parsed,
                ['afterID' => 'after_id', 'beforeID' => 'before_id']
            ),
            options: $options,
            convert: OrganizationUser::class,
            page: Page::class,
        );
    }

    /**
     * @api
     *
     * Remove a member from the organization.
     *
     * @param string $userID ID of the User
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserRemoveResponse>
     *
     * @throws APIException
     */
    public function remove(
        string $userID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/organizations/users/%1$s?beta=true', $userID],
            options: $requestOptions,
            convert: UserRemoveResponse::class,
        );
    }
}
