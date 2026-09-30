<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\RBACGroups;

use Anthropic\Beta\Organization\RBACGroups\Members\BetaRBACGroupMember;
use Anthropic\Beta\Organization\RBACGroups\Members\MemberRemoveResponse;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\RBACGroups\MembersContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class MembersService implements MembersContract
{
    /**
     * @api
     */
    public MembersRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new MembersRawService($client);
    }

    /**
     * @api
     *
     * List members of an RBAC Group.
     *
     * The RBAC Groups API is available to Claude Enterprise organizations only.
     *
     * @param string $rbacGroupID ID of the RBAC Group
     * @param int $limit Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     * @param string|null $page optionally set to the `next_page` token from the previous response
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<BetaRBACGroupMember>
     *
     * @throws APIException
     */
    public function list(
        string $rbacGroupID,
        ?int $limit = null,
        ?string $page = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor {
        $params = Util::removeNulls(['limit' => $limit, 'page' => $page]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list($rbacGroupID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Add a User to an RBAC Group. Membership of groups provisioned by an identity provider (source type `"scim"`) cannot be modified via the API while an organization in the tenant uses SCIM provisioning.
     *
     * The RBAC Groups API is available to Claude Enterprise organizations only.
     *
     * @param string $rbacGroupID ID of the RBAC Group
     * @param string $userID ID of the User
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function add(
        string $rbacGroupID,
        string $userID,
        RequestOptions|array|null $requestOptions = null,
    ): BetaRBACGroupMember {
        $params = Util::removeNulls(['userID' => $userID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->add($rbacGroupID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Remove a User from an RBAC Group. Membership of groups provisioned by an identity provider (source type `"scim"`) cannot be modified via the API while an organization in the tenant uses SCIM provisioning.
     *
     * The RBAC Groups API is available to Claude Enterprise organizations only.
     *
     * @param string $userID ID of the User
     * @param string $rbacGroupID ID of the RBAC Group
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function remove(
        string $userID,
        string $rbacGroupID,
        RequestOptions|array|null $requestOptions = null,
    ): MemberRemoveResponse {
        $params = Util::removeNulls(['rbacGroupID' => $rbacGroupID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->remove($userID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
