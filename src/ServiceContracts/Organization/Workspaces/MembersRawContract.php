<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Organization\Workspaces;

use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Organization\Workspaces\Members\MemberAddParams;
use Anthropic\Organization\Workspaces\Members\MemberListParams;
use Anthropic\Organization\Workspaces\Members\MemberRemoveParams;
use Anthropic\Organization\Workspaces\Members\MemberRemoveResponse;
use Anthropic\Organization\Workspaces\Members\MemberRetrieveParams;
use Anthropic\Organization\Workspaces\Members\MemberUpdateParams;
use Anthropic\Organization\Workspaces\WorkspaceMember;
use Anthropic\Page;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface MembersRawContract
{
    /**
     * @api
     *
     * @param string $userID ID of the User
     * @param array<string,mixed>|MemberRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<WorkspaceMember>
     *
     * @throws APIException
     */
    public function retrieve(
        string $userID,
        array|MemberRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $userID path param: ID of the User
     * @param array<string,mixed>|MemberUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<WorkspaceMember>
     *
     * @throws APIException
     */
    public function update(
        string $userID,
        array|MemberUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $workspaceID ID of the Workspace
     * @param array<string,mixed>|MemberListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Page<WorkspaceMember>>
     *
     * @throws APIException
     */
    public function list(
        string $workspaceID,
        array|MemberListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $workspaceID ID of the Workspace
     * @param array<string,mixed>|MemberAddParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<WorkspaceMember>
     *
     * @throws APIException
     */
    public function add(
        string $workspaceID,
        array|MemberAddParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $userID ID of the User
     * @param array<string,mixed>|MemberRemoveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<MemberRemoveResponse>
     *
     * @throws APIException
     */
    public function remove(
        string $userID,
        array|MemberRemoveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
