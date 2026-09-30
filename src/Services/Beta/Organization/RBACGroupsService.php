<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization;

use Anthropic\Beta\Organization\RBACGroups\RBACGroup;
use Anthropic\Beta\Organization\RBACGroups\RBACGroupDeleteResponse;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\RBACGroupsContract;
use Anthropic\Services\Beta\Organization\RBACGroups\MembersService;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class RBACGroupsService implements RBACGroupsContract
{
    /**
     * @api
     */
    public RBACGroupsRawService $raw;

    /**
     * @api
     */
    public MembersService $members;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new RBACGroupsRawService($client);
        $this->members = new MembersService($client);
    }

    /**
     * @api
     *
     * Create an RBAC Group in the Claude Enterprise tenant. Groups created via the API have source type `"direct"`.
     *
     * The RBAC Groups API is available to Claude Enterprise organizations only.
     *
     * @param string $name Name of the RBAC Group. Not uniqueness-enforced.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $name,
        RequestOptions|array|null $requestOptions = null
    ): RBACGroup {
        $params = Util::removeNulls(['name' => $name]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Retrieve an RBAC Group by ID.
     *
     * The RBAC Groups API is available to Claude Enterprise organizations only.
     *
     * @param string $rbacGroupID ID of the RBAC Group
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $rbacGroupID,
        RequestOptions|array|null $requestOptions = null
    ): RBACGroup {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($rbacGroupID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Update an RBAC Group's name. Groups provisioned by an identity provider (source type `"scim"`) cannot be modified via the API while an organization in the tenant uses SCIM provisioning.
     *
     * The RBAC Groups API is available to Claude Enterprise organizations only.
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
    ): RBACGroup {
        $params = Util::removeNulls(['name' => $name]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($rbacGroupID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List RBAC Groups in the Claude Enterprise tenant.
     *
     * The RBAC Groups API is available to Claude Enterprise organizations only.
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
    ): PageCursor {
        $params = Util::removeNulls(['limit' => $limit, 'page' => $page]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Delete an RBAC Group. Groups provisioned by an identity provider (source type `"scim"`) cannot be deleted via the API while an organization in the tenant uses SCIM provisioning.
     *
     * The RBAC Groups API is available to Claude Enterprise organizations only.
     *
     * @param string $rbacGroupID ID of the RBAC Group
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $rbacGroupID,
        RequestOptions|array|null $requestOptions = null
    ): RBACGroupDeleteResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($rbacGroupID, requestOptions: $requestOptions);

        return $response->parse();
    }
}
