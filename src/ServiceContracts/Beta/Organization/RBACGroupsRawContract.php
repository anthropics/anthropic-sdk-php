<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization;

use Anthropic\Beta\Organization\RBACGroups\DeletedRBACGroup;
use Anthropic\Beta\Organization\RBACGroups\RBACGroup;
use Anthropic\Beta\Organization\RBACGroups\RBACGroupCreateParams;
use Anthropic\Beta\Organization\RBACGroups\RBACGroupListParams;
use Anthropic\Beta\Organization\RBACGroups\RBACGroupUpdateParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Organization\RBACGroups\RBACGroupGrantsOwnerAccessException;
use Anthropic\Organization\RBACGroups\RBACGroupOwnerAccessUnconfirmedException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\SandboxEgressRestrictedException;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface RBACGroupsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|RBACGroupCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<RBACGroup>
     *
     * @throws SandboxEgressRestrictedException
     * @throws APIException
     */
    public function create(
        array|RBACGroupCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $rbacGroupID ID of the RBAC Group.
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<RBACGroup>
     *
     * @throws APIException
     */
    public function retrieve(
        string $rbacGroupID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $rbacGroupID ID of the RBAC Group.
     * @param array<string,mixed>|RBACGroupUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<RBACGroup>
     *
     * @throws SandboxEgressRestrictedException
     * @throws APIException
     */
    public function update(
        string $rbacGroupID,
        array|RBACGroupUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|RBACGroupListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<RBACGroup>>
     *
     * @throws APIException
     */
    public function list(
        array|RBACGroupListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $rbacGroupID ID of the RBAC Group.
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<DeletedRBACGroup>
     *
     * @throws RBACGroupGrantsOwnerAccessException
     * @throws RBACGroupOwnerAccessUnconfirmedException
     * @throws SandboxEgressRestrictedException
     * @throws APIException
     */
    public function delete(
        string $rbacGroupID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;
}
