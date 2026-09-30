<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\RBACGroups;

use Anthropic\Beta\Organization\RBACGroups\Members\BetaRBACGroupMember;
use Anthropic\Beta\Organization\RBACGroups\Members\MemberRemoveResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface MembersContract
{
    /**
     * @api
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
    ): PageCursor;

    /**
     * @api
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
    ): BetaRBACGroupMember;

    /**
     * @api
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
    ): MemberRemoveResponse;
}
