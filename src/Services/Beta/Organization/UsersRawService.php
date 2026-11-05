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
use Anthropic\Beta\Organization\Users\UserListParams;
use Anthropic\Beta\Organization\Users\UserRemoveResponse;
use Anthropic\Beta\Organization\Users\UserSignOutParams;
use Anthropic\Beta\Organization\Users\UserUpdateParams;
use Anthropic\Beta\Organization\Users\UserUpdateParams\Role;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Implementation\ApiCallInfo;
use Anthropic\Core\Util;
use Anthropic\Organization\ConcurrentMembershipChangeException;
use Anthropic\Organization\Users\CannotRemoveLastMemberException;
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
     * @param string $userID ID of the User.
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
            path: ['v1/organizations/users/%1$s', $userID],
            options: RequestOptions::parse($requestOptions)->withQualifiers([
                'beta' => 'true',
            ])->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.users.retrieve',
                route: '/v1/organizations/users/{user_id}',
                attributes: ['anthropic.organization.user.id' => $userID],
            )),
            convert: OrganizationUser::class,
        );
    }

    /**
     * @api
     *
     * Update a member's organization role.
     *
     * @param string $userID ID of the User.
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
            path: ['v1/organizations/users/%1$s', $userID],
            body: (object) $parsed,
            options: $options->withQualifiers([
                'beta' => 'true',
            ])->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.users.update',
                route: '/v1/organizations/users/{user_id}',
                attributes: ['anthropic.organization.user.id' => $userID],
            )),
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
            path: 'v1/organizations/users',
            query: Util::array_transform_keys(
                $parsed,
                ['afterID' => 'after_id', 'beforeID' => 'before_id']
            ),
            options: $options->withQualifiers([
                'beta' => 'true',
            ])->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.users.list',
                route: '/v1/organizations/users',
                query: ['after_id', 'before_id', 'email', 'limit', 'roles'],
            )),
            convert: OrganizationUser::class,
            page: Page::class,
        );
    }

    /**
     * @api
     *
     * Remove a member from the organization.
     *
     * @param string $userID ID of the User.
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserRemoveResponse>
     *
     * @throws CannotRemoveLastMemberException
     * @throws ConcurrentMembershipChangeException
     * @throws APIException
     */
    public function remove(
        string $userID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/organizations/users/%1$s', $userID],
            options: RequestOptions::parse($requestOptions)->withQualifiers([
                'beta' => 'true',
            ])->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.users.remove',
                route: '/v1/organizations/users/{user_id}',
                attributes: ['anthropic.organization.user.id' => $userID],
            )),
            convert: UserRemoveResponse::class,
        );
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
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|UserSignOutParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<OrganizationUser>
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
        array|UserSignOutParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = UserSignOutParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/organizations/users/%1$s/sign_out', $userID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                [
                    'extraHeaders' => [
                        'anthropic-beta' => 'admin-user-sign-out-2026-10-08',
                    ],
                ],
                $options,
            )->withQualifiers(['beta' => 'true'])->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.users.sign_out',
                route: '/v1/organizations/users/{user_id}/sign_out',
                attributes: ['anthropic.organization.user.id' => $userID],
            )),
            convert: OrganizationUser::class,
        );
    }
}
