<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization;

use Anthropic\Beta\Organization\RBACGroups\RBACGroup;
use Anthropic\Beta\Organization\RBACGroups\RBACGroupDeleteResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface RBACGroupsContract
{
    /**
     * @api
     *
     * @param string $name Name of the RBAC Group. Not uniqueness-enforced.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $name,
        RequestOptions|array|null $requestOptions = null
    ): RBACGroup;

    /**
     * @api
     *
     * @param string $rbacGroupID ID of the RBAC Group
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $rbacGroupID,
        RequestOptions|array|null $requestOptions = null
    ): RBACGroup;

    /**
     * @api
     *
     * @param string $rbacGroupID ID of the RBAC Group
     * @param string|null $name Name of the RBAC Group. Not uniqueness-enforced.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $rbacGroupID,
        ?string $name = null,
        RequestOptions|array|null $requestOptions = null,
    ): RBACGroup;

    /**
     * @api
     *
     * @param int $limit Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     * @param string|null $page optionally set to the `next_page` token from the previous response
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<RBACGroup>
     *
     * @throws APIException
     */
    public function list(
        ?int $limit = null,
        ?string $page = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;

    /**
     * @api
     *
     * @param string $rbacGroupID ID of the RBAC Group
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $rbacGroupID,
        RequestOptions|array|null $requestOptions = null
    ): RBACGroupDeleteResponse;
}
