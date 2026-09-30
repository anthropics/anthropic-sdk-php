<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization;

use Anthropic\Beta\Organization\RBACRoles\RBACRole;
use Anthropic\Beta\Organization\RBACRoles\RBACRoleListParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface RBACRolesRawContract
{
    /**
     * @api
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|RBACRoleListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<RBACRole>>
     *
     * @throws APIException
     */
    public function list(
        array|RBACRoleListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
