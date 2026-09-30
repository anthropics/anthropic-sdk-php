<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\RBACRoles;

use Anthropic\Beta\Organization\RBACRoles\Permissions\BetaRBACRolePermission;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface PermissionsContract
{
    /**
     * @api
     *
     * @param string $rbacRoleID ID of the RBAC Role
     * @param int $limit Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     * @param string|null $page optionally set to the `next_page` token from the previous response
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<BetaRBACRolePermission>
     *
     * @throws APIException
     */
    public function list(
        string $rbacRoleID,
        ?int $limit = null,
        ?string $page = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;
}
