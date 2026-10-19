<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\UserProfiles;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\UserProfiles\ActionURLs\UserProfileActionURL;
use Anthropic\Beta\UserProfiles\ActionURLs\UserProfileEnrollEndUserAction;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\UserProfiles\ActionURLsContract;

/**
 * @phpstan-import-type UserProfileEnrollEndUserActionShape from \Anthropic\Beta\UserProfiles\ActionURLs\UserProfileEnrollEndUserAction
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class ActionURLsService implements ActionURLsContract
{
    /**
     * @api
     */
    public ActionURLsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ActionURLsRawService($client);
    }

    /**
     * @api
     *
     * Create Action URL
     *
     * @param string $userProfileID Path param: The ID of the user profile the action is for (`uprof_...`).
     * @param UserProfileEnrollEndUserAction|UserProfileEnrollEndUserActionShape $action body param: The action that the person who opens the URL takes
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
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
        ?array $betas = null,
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): UserProfileActionURL {
        $params = Util::removeNulls(
            ['action' => $action, 'betas' => $betas, 'workspaceID' => $workspaceID]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create($userProfileID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
