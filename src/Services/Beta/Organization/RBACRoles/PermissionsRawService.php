<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\RBACRoles;

use Anthropic\Beta\Organization\RBACRoles\Permissions\BetaRBACRolePermission;
use Anthropic\Beta\Organization\RBACRoles\Permissions\PermissionListParams;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Implementation\ApiCallInfo;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\RBACRoles\PermissionsRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class PermissionsRawService implements PermissionsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * List the permissions an RBAC Role grants.
     *
     * The RBAC Roles API is available to Claude Enterprise organizations only.
     *
     * @param string $rbacRoleID ID of the RBAC Role
     * @param array{limit?: int, page?: string|null}|PermissionListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaRBACRolePermission>>
     *
     * @throws APIException
     */
    public function list(
        string $rbacRoleID,
        array|PermissionListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = PermissionListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: [
                'v1/organizations/rbac_roles/%1$s/permissions?beta=true', $rbacRoleID,
            ],
            query: $parsed,
            options: $options->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.rbac_roles.permissions.list',
                route: '/v1/organizations/rbac_roles/{rbac_role_id}/permissions',
                query: ['limit', 'page'],
                attributes: ['anthropic.organization.rbac_role.id' => $rbacRoleID],
            )),
            convert: BetaRBACRolePermission::class,
            page: PageCursor::class,
        );
    }
}
