<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Organization;

use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Organization\Invites\AlreadyMemberException;
use Anthropic\Organization\Invites\CannotInviteEmailsWithUnverifiedDomainsException;
use Anthropic\Organization\Invites\EmailDomainNotAllowedException;
use Anthropic\Organization\Invites\InviteAlreadyExistsException;
use Anthropic\Organization\Invites\InviteCreateParams;
use Anthropic\Organization\Invites\InviteDeleteResponse;
use Anthropic\Organization\Invites\InviteListParams;
use Anthropic\Organization\Invites\OrganizationInvite;
use Anthropic\Organization\OrgMemberLimitExceededException;
use Anthropic\Organization\RBACGroups\RBACGroupGrantsOwnerAccessException;
use Anthropic\Organization\RBACGroups\RBACGroupOwnerAccessUnconfirmedException;
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
     * @throws AlreadyMemberException The email address already belongs to a user in the organization. The message names the user.
     * @throws CannotInviteEmailsWithUnverifiedDomainsException The email address's domain is not one of the verified domains of the organization's parent organization.
     * @throws EmailDomainNotAllowedException The organization restricts invites to an allowed list of email domains, and the list is empty or does not include the email address's domain.
     * @throws InviteAlreadyExistsException A pending invite already exists for the email address. The message names the invite.
     * @throws OrgMemberLimitExceededException The organization has reached the member limit that Anthropic set for it. Pending invites count toward the limit.
     * @throws RBACGroupGrantsOwnerAccessException A role attached to an RBAC Group in the request grants owner access, so this API does not add members to that group (directly or through an invite), remove its members, or delete it. Make the change in the organization's admin settings in Claude.
     * @throws RBACGroupOwnerAccessUnconfirmedException The API could not finish checking whether an RBAC Group in the request grants owner access, so it made no change. Retrying the same request will not help. Make the change in the organization's admin settings in Claude.
     * @throws APIException
     */
    public function create(
        array|InviteCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $inviteID ID of the Invite.
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
     * @param string $inviteID ID of the Invite.
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
