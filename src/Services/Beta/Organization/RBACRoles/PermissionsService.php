<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\RBACRoles;

use Anthropic\Beta\Organization\RBACRoles\Permissions\BetaRBACRolePermission;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\RBACRoles\PermissionsContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class PermissionsService implements PermissionsContract
{
    /**
     * @api
     */
    public PermissionsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new PermissionsRawService($client);
    }

    /**
     * @api
     *
     * List the permissions an RBAC Role grants.
     *
     * The RBAC Roles API is available to Claude Enterprise organizations only.
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
    ): PageCursor {
        $params = Util::removeNulls(['limit' => $limit, 'page' => $page]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list($rbacRoleID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
