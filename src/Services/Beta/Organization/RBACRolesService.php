<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization;

use Anthropic\Beta\Organization\RBACRoles\RBACRole;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\RBACRolesContract;
use Anthropic\Services\Beta\Organization\RBACRoles\PermissionsService;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class RBACRolesService implements RBACRolesContract
{
    /**
     * @api
     */
    public RBACRolesRawService $raw;

    /**
     * @api
     */
    public PermissionsService $permissions;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new RBACRolesRawService($client);
        $this->permissions = new PermissionsService($client);
    }

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
     * @throws APIException
     */
    public function retrieve(
        string $rbacRoleID,
        RequestOptions|array|null $requestOptions = null
    ): RBACRole {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($rbacRoleID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List RBAC Roles in the organization.
     *
     * The RBAC Roles API is available to Claude Enterprise organizations only.
     *
     * @param int $limit Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     * @param string|null $page optionally set to the `next_page` token from the previous response
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<RBACRole>
     *
     * @throws APIException
     */
    public function list(
        ?int $limit = null,
        ?string $page = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor {
        $params = Util::removeNulls(['limit' => $limit, 'page' => $page]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
