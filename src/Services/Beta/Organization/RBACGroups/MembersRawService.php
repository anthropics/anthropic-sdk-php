<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\RBACGroups;

use Anthropic\Beta\Organization\RBACGroups\Members\BetaRBACGroupMember;
use Anthropic\Beta\Organization\RBACGroups\Members\MemberAddParams;
use Anthropic\Beta\Organization\RBACGroups\Members\MemberListParams;
use Anthropic\Beta\Organization\RBACGroups\Members\MemberRemoveParams;
use Anthropic\Beta\Organization\RBACGroups\Members\MemberRemoveResponse;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\RBACGroups\MembersRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class MembersRawService implements MembersRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * List members of an RBAC Group.
     *
     * The RBAC Groups API is available to Claude Enterprise organizations only.
     *
     * @param string $rbacGroupID ID of the RBAC Group
     * @param array{limit?: int, page?: string|null}|MemberListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaRBACGroupMember>>
     *
     * @throws APIException
     */
    public function list(
        string $rbacGroupID,
        array|MemberListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = MemberListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: [
                'v1/organizations/rbac_groups/%1$s/members?beta=true', $rbacGroupID,
            ],
            query: $parsed,
            options: $options,
            convert: BetaRBACGroupMember::class,
            page: PageCursor::class,
        );
    }

    /**
     * @api
     *
     * Add a User to an RBAC Group. Membership of groups provisioned by an identity provider (source type `"scim"`) cannot be modified via the API while an organization in the tenant uses SCIM provisioning.
     *
     * The RBAC Groups API is available to Claude Enterprise organizations only.
     *
     * @param string $rbacGroupID ID of the RBAC Group
     * @param array{userID: string}|MemberAddParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaRBACGroupMember>
     *
     * @throws APIException
     */
    public function add(
        string $rbacGroupID,
        array|MemberAddParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = MemberAddParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/organizations/rbac_groups/%1$s/members?beta=true', $rbacGroupID,
            ],
            body: (object) $parsed,
            options: $options,
            convert: BetaRBACGroupMember::class,
        );
    }

    /**
     * @api
     *
     * Remove a User from an RBAC Group. Membership of groups provisioned by an identity provider (source type `"scim"`) cannot be modified via the API while an organization in the tenant uses SCIM provisioning.
     *
     * The RBAC Groups API is available to Claude Enterprise organizations only.
     *
     * @param string $userID ID of the User
     * @param array{rbacGroupID: string}|MemberRemoveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<MemberRemoveResponse>
     *
     * @throws APIException
     */
    public function remove(
        string $userID,
        array|MemberRemoveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = MemberRemoveParams::parseRequest(
            $params,
            $requestOptions,
        );
        $rbacGroupID = $parsed['rbacGroupID'];
        unset($parsed['rbacGroupID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: [
                'v1/organizations/rbac_groups/%1$s/members/%2$s?beta=true',
                $rbacGroupID,
                $userID,
            ],
            options: $options,
            convert: MemberRemoveResponse::class,
        );
    }
}
