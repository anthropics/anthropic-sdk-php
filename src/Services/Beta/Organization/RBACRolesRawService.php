<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization;

use Anthropic\Beta\Organization\RBACRoles\RBACRole;
use Anthropic\Beta\Organization\RBACRoles\RBACRoleListParams;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\RBACRolesRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class RBACRolesRawService implements RBACRolesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Retrieve an RBAC Role by ID.
     *
     * The RBAC Roles API is available to Claude Enterprise organizations only.
     *
     * @param string $rbacRoleID ID of the RBAC Role
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<RBACRole>
     *
     * @throws APIException
     */
    public function retrieve(
        string $rbacRoleID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/organizations/rbac_roles/%1$s?beta=true', $rbacRoleID],
            options: $requestOptions,
            convert: RBACRole::class,
        );
    }

    /**
     * @api
     *
     * List RBAC Roles in the organization.
     *
     * The RBAC Roles API is available to Claude Enterprise organizations only.
     *
     * @param array{limit?: int, page?: string|null}|RBACRoleListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<RBACRole>>
     *
     * @throws APIException
     */
    public function list(
        array|RBACRoleListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = RBACRoleListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/organizations/rbac_roles?beta=true',
            query: $parsed,
            options: $options,
            convert: RBACRole::class,
            page: PageCursor::class,
        );
    }
}
