<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\UserProfiles;

use Anthropic\Core\Exceptions\APIException;
use Anthropic\RequestOptions;
use Anthropic\UserProfiles\ActionURLs\UserProfileActionURL;
use Anthropic\UserProfiles\ActionURLs\UserProfileEnrollEndUserAction;

/**
 * @phpstan-import-type UserProfileEnrollEndUserActionShape from \Anthropic\UserProfiles\ActionURLs\UserProfileEnrollEndUserAction
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface ActionURLsContract
{
    /**
     * @api
     *
     * @param string $userProfileID Path param: The ID of the user profile the action is for (`uprof_...`).
     * @param UserProfileEnrollEndUserAction|UserProfileEnrollEndUserActionShape $action body param: The action that the person who opens the URL takes
     * @param string $workspaceID Header param: Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $userProfileID,
        UserProfileEnrollEndUserAction|array $action,
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): UserProfileActionURL;
}
