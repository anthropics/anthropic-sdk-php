<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization;

use Anthropic\Beta\Organization\RBACRoles\RBACRole;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Organization\RBACRoleNotFoundException;
use Anthropic\OrganizationTypeNotSupportedException;
use Anthropic\PageCursor;
use Anthropic\ParentOrganizationRequiredException;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface RBACRolesContract
{
    /**
     * @api
     *
     * @param string $rbacRoleID ID of the RBAC Role.
     * @param RequestOpts|null $requestOptions
     *
     * @throws OrganizationTypeNotSupportedException
     * @throws ParentOrganizationRequiredException
     * @throws RBACRoleNotFoundException
     * @throws APIException
     */
    public function retrieve(
        string $rbacRoleID,
        RequestOptions|array|null $requestOptions = null
    ): RBACRole;

    /**
     * @api
     *
     * @param int $limit Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     * @param string|null $page Optionally set to the `next_page` token from the previous response.
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<RBACRole>
     *
     * @throws OrganizationTypeNotSupportedException
     * @throws ParentOrganizationRequiredException
     * @throws APIException
     */
    public function list(
        ?int $limit = null,
        ?string $page = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;
}
