<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization;

use Anthropic\Beta\Organization\Invites\InviteCreateParams;
use Anthropic\Beta\Organization\Invites\InviteDeleteResponse;
use Anthropic\Beta\Organization\Invites\InviteListParams;
use Anthropic\Beta\Organization\Invites\OrganizationInvite;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Page;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface InvitesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|InviteCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<OrganizationInvite>
     *
     * @throws APIException
     */
    public function create(
        array|InviteCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|InviteListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Page<OrganizationInvite>>
     *
     * @throws APIException
     */
    public function list(
        array|InviteListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;
}
