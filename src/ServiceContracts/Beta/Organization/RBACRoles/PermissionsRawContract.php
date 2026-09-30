<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\RBACRoles;

use Anthropic\Beta\Organization\RBACRoles\Permissions\BetaRBACRolePermission;
use Anthropic\Beta\Organization\RBACRoles\Permissions\PermissionListParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface PermissionsRawContract
{
    /**
     * @api
     *
     * @param string $rbacRoleID ID of the RBAC Role
     * @param array<string,mixed>|PermissionListParams $params
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
    ): BaseResponse;
}
