<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization;

use Anthropic\Beta\Organization\Invites\InviteCreateParams;
use Anthropic\Beta\Organization\Invites\InviteCreateParams\Role;
use Anthropic\Beta\Organization\Invites\InviteDeleteResponse;
use Anthropic\Beta\Organization\Invites\InviteListParams;
use Anthropic\Beta\Organization\Invites\InviteListParams\Status;
use Anthropic\Beta\Organization\Invites\OrganizationInvite;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\Page;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\InvitesRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class InvitesRawService implements InvitesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Invite a user to join the organization by email.
     *
     * On plans that draw members from a finite pool of purchased seats, the invite automatically consumes a seat from the lowest tier with availability; there is no seat-tier parameter. When no seat is free the request fails with a 400 error rather than purchasing a seat.
     *
     * @param array{
     *   email: string, role: Role|value-of<Role>, rbacGroupIDs?: list<string>
     * }|InviteCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<OrganizationInvite>
     *
     * @throws APIException
     */
    public function create(
        array|InviteCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = InviteCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/organizations/invites?beta=true',
            body: (object) $parsed,
            options: $options,
            convert: OrganizationInvite::class,
        );
    }

    /**
     * @api
     *
     * Retrieve an invite by ID.
     *
     * @param string $inviteID ID of the Invite
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<OrganizationInvite>
     *
     * @throws APIException
     */
    public function retrieve(
        string $inviteID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/organizations/invites/%1$s?beta=true', $inviteID],
            options: $requestOptions,
            convert: OrganizationInvite::class,
        );
    }

    /**
     * @api
     *
     * List the organization's invites.
     *
     * @param array{
     *   afterID?: string,
     *   beforeID?: string,
     *   email?: string,
     *   limit?: int,
     *   roles?: list<string>,
     *   statuses?: list<Status|value-of<Status>>,
     * }|InviteListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Page<OrganizationInvite>>
     *
     * @throws APIException
     */
    public function list(
        array|InviteListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = InviteListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/organizations/invites?beta=true',
            query: Util::array_transform_keys(
                $parsed,
                ['afterID' => 'after_id', 'beforeID' => 'before_id']
            ),
            options: $options,
            convert: OrganizationInvite::class,
            page: Page::class,
        );
    }

    /**
     * @api
     *
     * Delete a pending invite.
     *
     * @param string $inviteID ID of the Invite
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<InviteDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $inviteID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/organizations/invites/%1$s?beta=true', $inviteID],
            options: $requestOptions,
            convert: InviteDeleteResponse::class,
        );
    }
}
