<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization;

use Anthropic\Beta\Organization\RBACGroups\RBACGroup;
use Anthropic\Beta\Organization\RBACGroups\RBACGroupCreateParams;
use Anthropic\Beta\Organization\RBACGroups\RBACGroupDeleteResponse;
use Anthropic\Beta\Organization\RBACGroups\RBACGroupListParams;
use Anthropic\Beta\Organization\RBACGroups\RBACGroupUpdateParams;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\RBACGroupsRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class RBACGroupsRawService implements RBACGroupsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create an RBAC Group in the Claude Enterprise tenant. Groups created via the API have source type `"direct"`.
     *
     * The RBAC Groups API is available to Claude Enterprise organizations only.
     *
     * @param array{name: string}|RBACGroupCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<RBACGroup>
     *
     * @throws APIException
     */
    public function create(
        array|RBACGroupCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = RBACGroupCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/organizations/rbac_groups?beta=true',
            body: (object) $parsed,
            options: $options,
            convert: RBACGroup::class,
        );
    }

    /**
     * @api
     *
     * Retrieve an RBAC Group by ID.
     *
     * The RBAC Groups API is available to Claude Enterprise organizations only.
     *
     * @param string $rbacGroupID ID of the RBAC Group
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<RBACGroup>
     *
     * @throws APIException
     */
    public function retrieve(
        string $rbacGroupID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/organizations/rbac_groups/%1$s?beta=true', $rbacGroupID],
            options: $requestOptions,
            convert: RBACGroup::class,
        );
    }

    /**
     * @api
     *
     * Update an RBAC Group's name. Groups provisioned by an identity provider (source type `"scim"`) cannot be modified via the API while an organization in the tenant uses SCIM provisioning.
     *
     * The RBAC Groups API is available to Claude Enterprise organizations only.
     *
     * @param string $rbacGroupID ID of the RBAC Group
     * @param array{name?: string|null}|RBACGroupUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<RBACGroup>
     *
     * @throws APIException
     */
    public function update(
        string $rbacGroupID,
        array|RBACGroupUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = RBACGroupUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/organizations/rbac_groups/%1$s?beta=true', $rbacGroupID],
            body: (object) $parsed,
            options: $options,
            convert: RBACGroup::class,
        );
    }

    /**
     * @api
     *
     * List RBAC Groups in the Claude Enterprise tenant.
     *
     * The RBAC Groups API is available to Claude Enterprise organizations only.
     *
     * @param array{limit?: int, page?: string|null}|RBACGroupListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<RBACGroup>>
     *
     * @throws APIException
     */
    public function list(
        array|RBACGroupListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = RBACGroupListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/organizations/rbac_groups?beta=true',
            query: $parsed,
            options: $options,
            convert: RBACGroup::class,
            page: PageCursor::class,
        );
    }

    /**
     * @api
     *
     * Delete an RBAC Group. Groups provisioned by an identity provider (source type `"scim"`) cannot be deleted via the API while an organization in the tenant uses SCIM provisioning.
     *
     * The RBAC Groups API is available to Claude Enterprise organizations only.
     *
     * @param string $rbacGroupID ID of the RBAC Group
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<RBACGroupDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $rbacGroupID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/organizations/rbac_groups/%1$s?beta=true', $rbacGroupID],
            options: $requestOptions,
            convert: RBACGroupDeleteResponse::class,
        );
    }
}
