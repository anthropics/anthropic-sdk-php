<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Organization\RBACRoles;

use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Organization\RBACRoleNotFoundException;
use Anthropic\Organization\RBACRoles\Permissions\PermissionListParams;
use Anthropic\Organization\RBACRoles\Permissions\RBACRolePermission;
use Anthropic\OrganizationTypeNotSupportedException;
use Anthropic\PageCursor;
use Anthropic\ParentOrganizationRequiredException;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface PermissionsRawContract
{
    /**
     * @api
     *
     * @param string $rbacRoleID ID of the RBAC Role.
     * @param array<string,mixed>|PermissionListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<RBACRolePermission>>
     *
     * @throws OrganizationTypeNotSupportedException
     * @throws ParentOrganizationRequiredException
     * @throws RBACRoleNotFoundException
     * @throws APIException
     */
    public function list(
        string $rbacRoleID,
        array|PermissionListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
