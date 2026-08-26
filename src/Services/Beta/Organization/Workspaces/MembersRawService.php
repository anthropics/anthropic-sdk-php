<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\Workspaces;

use Anthropic\Beta\Organization\Workspaces\Members\MemberAddParams;
use Anthropic\Beta\Organization\Workspaces\Members\MemberListParams;
use Anthropic\Beta\Organization\Workspaces\Members\MemberRemoveParams;
use Anthropic\Beta\Organization\Workspaces\Members\MemberRemoveResponse;
use Anthropic\Beta\Organization\Workspaces\Members\MemberRetrieveParams;
use Anthropic\Beta\Organization\Workspaces\Members\MemberUpdateParams;
use Anthropic\Beta\Organization\Workspaces\NoBillingWorkspaceRole;
use Anthropic\Beta\Organization\Workspaces\WorkspaceMember;
use Anthropic\Beta\Organization\Workspaces\WorkspaceRole;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\Page;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\Workspaces\MembersRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class MembersRawService implements MembersRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Get Workspace Member
     *
     * @param string $userID ID of the User
     * @param array{workspaceID: string}|MemberRetrieveParams $params
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
    ): BaseResponse {
        [$parsed, $options] = MemberRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );
        $workspaceID = $parsed['workspaceID'];
        unset($parsed['workspaceID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: [
                'v1/organizations/workspaces/%1$s/members/%2$s?beta=true',
                $workspaceID,
                $userID,
            ],
            options: $options,
            convert: WorkspaceMember::class,
        );
    }

    /**
     * @api
     *
     * Update Workspace Member
     *
     * @param string $userID path param: ID of the User
     * @param array{
     *   workspaceID: string, workspaceRole: value-of<WorkspaceRole>
     * }|MemberUpdateParams $params
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
    ): BaseResponse {
        [$parsed, $options] = MemberUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $workspaceID = $parsed['workspaceID'];
        unset($parsed['workspaceID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/organizations/workspaces/%1$s/members/%2$s?beta=true',
                $workspaceID,
                $userID,
            ],
            body: (object) array_diff_key($parsed, array_flip(['workspaceID'])),
            options: $options,
            convert: WorkspaceMember::class,
        );
    }

    /**
     * @api
     *
     * List Workspace Members
     *
     * @param string $workspaceID ID of the Workspace
     * @param array{
     *   afterID?: string, beforeID?: string, limit?: int
     * }|MemberListParams $params
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
    ): BaseResponse {
        [$parsed, $options] = MemberListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: [
                'v1/organizations/workspaces/%1$s/members?beta=true', $workspaceID,
            ],
            query: Util::array_transform_keys(
                $parsed,
                ['afterID' => 'after_id', 'beforeID' => 'before_id']
            ),
            options: $options,
            convert: WorkspaceMember::class,
            page: Page::class,
        );
    }

    /**
     * @api
     *
     * Create Workspace Member
     *
     * @param string $workspaceID ID of the Workspace
     * @param array{
     *   userID: string, workspaceRole: value-of<NoBillingWorkspaceRole>
     * }|MemberAddParams $params
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
    ): BaseResponse {
        [$parsed, $options] = MemberAddParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/organizations/workspaces/%1$s/members?beta=true', $workspaceID,
            ],
            body: (object) $parsed,
            options: $options,
            convert: WorkspaceMember::class,
        );
    }

    /**
     * @api
     *
     * Delete Workspace Member
     *
     * @param string $userID ID of the User
     * @param array{workspaceID: string}|MemberRemoveParams $params
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
    ): BaseResponse {
        [$parsed, $options] = MemberRemoveParams::parseRequest(
            $params,
            $requestOptions,
        );
        $workspaceID = $parsed['workspaceID'];
        unset($parsed['workspaceID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: [
                'v1/organizations/workspaces/%1$s/members/%2$s?beta=true',
                $workspaceID,
                $userID,
            ],
            options: $options,
            convert: MemberRemoveResponse::class,
        );
    }
}
