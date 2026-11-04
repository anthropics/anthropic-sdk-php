<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Organization;

use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Organization\ExternalKeys\ExternalKeyChangedException;
use Anthropic\Organization\Workspaces\KeyProfileMismatchException;
use Anthropic\Organization\Workspaces\Workspace;
use Anthropic\Organization\Workspaces\WorkspaceCreateParams;
use Anthropic\Organization\Workspaces\WorkspaceListParams;
use Anthropic\Organization\Workspaces\WorkspacePolicyViolationException;
use Anthropic\Organization\Workspaces\WorkspaceUpdateParams;
use Anthropic\Page;
use Anthropic\RequestOptions;
use Anthropic\UserProfiles\UserProfileNotFoundException;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface WorkspacesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|WorkspaceCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Workspace>
     *
     * @throws KeyProfileMismatchException The External Key is bound to a user profile, and the Workspace does not have that user profile. A Workspace can use only a key bound to its own user profile or a key that isn't bound to one.
     * @throws UserProfileNotFoundException The request depends on a user profile that does not exist in the organization or is no longer active. The request either names this user profile by ID, or names a resource, such as an External Key, that is bound to it.
     * @throws WorkspacePolicyViolationException The request breaks the organization's Workspace Policy. The message says which rule it broke; an organization admin can see and change the policy in the Console.
     * @throws ExternalKeyChangedException The external key changed while the request was validating it. Send the request again.
     * @throws APIException
     */
    public function create(
        array|WorkspaceCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $workspaceID ID of the Workspace.
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Workspace>
     *
     * @throws APIException
     */
    public function retrieve(
        string $workspaceID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|WorkspaceUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Workspace>
     *
     * @throws KeyProfileMismatchException The External Key is bound to a user profile, and the Workspace does not have that user profile. A Workspace can use only a key bound to its own user profile or a key that isn't bound to one.
     * @throws UserProfileNotFoundException The request depends on a user profile that does not exist in the organization or is no longer active. The request either names this user profile by ID, or names a resource, such as an External Key, that is bound to it.
     * @throws WorkspacePolicyViolationException The request breaks the organization's Workspace Policy. The message says which rule it broke; an organization admin can see and change the policy in the Console.
     * @throws ExternalKeyChangedException The external key changed while the request was validating it. Send the request again.
     * @throws APIException
     */
    public function update(
        string $workspaceID,
        array|WorkspaceUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|WorkspaceListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Page<Workspace>>
     *
     * @throws APIException
     */
    public function list(
        array|WorkspaceListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Workspace>
     *
     * @throws APIException
     */
    public function archive(
        string $workspaceID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;
}
